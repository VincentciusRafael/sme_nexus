<?php

namespace App\Http\Controllers\Decision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutopsyController extends Controller
{
    private const TIER_STABLE = 0;
    private const TIER_RINGAN = 1;
    private const TIER_SEDANG = 2;
    private const TIER_SIGNIFIKAN = 3;
    private const TIER_ANJLOK = 4;

    private static function declineTier(float $change): int
    {
        if ($change > -1) {
            return self::TIER_STABLE;
        }
        if ($change >= -5) {
            return self::TIER_RINGAN;
        }
        if ($change >= -10) {
            return self::TIER_SEDANG;
        }
        if ($change >= -25) {
            return self::TIER_SIGNIFIKAN;
        }

        return self::TIER_ANJLOK;
    }

    private static function tierSeverity(int $tier): string
    {
        return match ($tier) {
            self::TIER_RINGAN => 'low',
            self::TIER_SEDANG => 'medium',
            default => 'high',
        };
    }

    private static function tierLabel(int $tier): string
    {
        return match ($tier) {
            self::TIER_RINGAN => 'Ringan',
            self::TIER_SEDANG => 'Sedang',
            self::TIER_SIGNIFIKAN => 'Signifikan',
            self::TIER_ANJLOK => 'Anjlok',
            default => '',
        };
    }

    public function index()
    {
        return view('decision.autopsy');
    }

    public function analyze(Request $request)
    {
        $data = $request->validate([
            'omzet_prev' => 'required|numeric|gt:0|max:999999999999999',
            'omzet_current' => 'required|numeric|min:0|max:999999999999999',
            'customer_prev' => 'required|numeric|gt:0|max:999999999999999',
            'customer_current' => 'required|numeric|min:0|max:999999999999999',
            'sales_prev' => 'required|numeric|gt:0|max:999999999999999',
            'sales_current' => 'required|numeric|min:0|max:999999999999999',
            'product_count' => 'required|numeric|min:0|max:9999999',
            'avg_price' => 'required|numeric|min:0|max:999999999999999',
            'marketing_spend' => 'required|numeric|min:0|max:999999999999999',
            'operational_cost' => 'required|numeric|min:0|max:999999999999999',
        ]);

        $omzetChange = (($data['omzet_current'] - $data['omzet_prev']) / $data['omzet_prev']) * 100;
        $customerChange = (($data['customer_current'] - $data['customer_prev']) / $data['customer_prev']) * 100;
        $salesChange = (($data['sales_current'] - $data['sales_prev']) / $data['sales_prev']) * 100;

        $omzetTier = self::declineTier($omzetChange);
        $customerTier = self::declineTier($customerChange);
        $salesTier = self::declineTier($salesChange);

        $diagnoses = [];
        $recommendations = [];

        // Setiap indikator dicek mandiri: mulai dari turun -1% sudah ada kondisi.
        // Makin parah turunnya, makin parah tier-nya (Ringan -> Sedang -> Signifikan -> Anjlok).
        if ($omzetTier > self::TIER_STABLE) {
            $label = self::tierLabel($omzetTier);
            $diagnoses[] = [
                'title' => "Omzet Menurun {$label}",
                'severity' => self::tierSeverity($omzetTier),
                'description' => 'Omzet menurun ' . abs(round($omzetChange, 1)) . '% dari periode sebelumnya. '
                    . ($omzetTier === self::TIER_ANJLOK ? 'Penurunan ini tergolong anjlok dan memerlukan evaluasi segera.' : ''),
            ];
            $recommendations[] = $omzetTier === self::TIER_RINGAN
                ? [
                    'title' => 'Pantau Penurunan Omzet',
                    'description' => 'Penurunan omzet masih ringan. Pantau tren beberapa hari ke depan dan pastikan tidak berlanjut.',
                    'priority' => 'low',
                ]
                : [
                    'title' => 'Evaluasi Penurunan Omzet',
                    'description' => 'Tinjau kanal penjualan dan strategi harga yang paling berdampak, lalu terapkan perbaikan bertahap.',
                    'priority' => self::tierSeverity($omzetTier),
                ];
        }

        if ($customerTier > self::TIER_STABLE) {
            $label = self::tierLabel($customerTier);
            $diagnoses[] = [
                'title' => "Jumlah Pelanggan Menurun {$label}",
                'severity' => self::tierSeverity($customerTier),
                'description' => 'Jumlah pelanggan menurun ' . abs(round($customerChange, 1)) . '%.'
                    . ($customerTier === self::TIER_ANJLOK ? ' Anjloknya jumlah pelanggan mengindikasikan masalah akuisisi atau retensi yang serius.' : ''),
            ];
            $recommendations[] = $customerTier === self::TIER_RINGAN
                ? [
                    'title' => 'Pantau Jumlah Pelanggan',
                    'description' => 'Penurunan pelanggan masih ringan. Pantau kampanye berjalan dan pastikan akuisisi tetap terjaga.',
                    'priority' => 'low',
                ]
                : [
                    'title' => 'Tingkatkan Akuisisi Pelanggan',
                    'description' => 'Fokuskan pada strategi marketing untuk menarik pelanggan baru dan perbaiki retensi pelanggan lama.',
                    'priority' => self::tierSeverity($customerTier),
                ];
        }

        if ($salesTier > self::TIER_STABLE) {
            $label = self::tierLabel($salesTier);
            $diagnoses[] = [
                'title' => "Volume Penjualan Menurun {$label}",
                'severity' => self::tierSeverity($salesTier),
                'description' => 'Volume penjualan menurun ' . abs(round($salesChange, 1)) . '%.'
                    . ($salesTier === self::TIER_ANJLOK ? ' Anjloknya volume penjualan memerlukan tindakan segera.' : ''),
            ];
            $recommendations[] = $salesTier === self::TIER_RINGAN
                ? [
                    'title' => 'Pantau Penjualan',
                    'description' => 'Penurunan penjualan masih ringan. Pantau stok, harga, dan trafik toko untuk mencegah memburuk.',
                    'priority' => 'low',
                ]
                : [
                    'title' => 'Tingkatkan Retensi Pelanggan',
                    'description' => 'Buat program loyalitas atau penawaran khusus untuk pelanggan existing.',
                    'priority' => self::tierSeverity($salesTier),
                ];
        }

        // Eskalasi gabungan: kalau ketiga indikator kompak turun, naikkan parah satu tingkat.
        $allDeclining = $omzetTier > self::TIER_STABLE
            && $customerTier > self::TIER_STABLE
            && $salesTier > self::TIER_STABLE;

        if ($allDeclining) {
            $worstTier = max($omzetTier, $customerTier, $salesTier);
            $escalatedTier = min($worstTier + 1, self::TIER_ANJLOK);
            $diagnoses[] = [
                'title' => 'Semua Indikator Turun Bersama',
                'severity' => self::tierSeverity($escalatedTier),
                'description' => 'Omzet, customer, dan penjualan turun bersamaan. Pola ini mengindikasikan masalah bisnis yang lebih luas, bukan fluktuasi satu indikator.',
            ];
            if ($escalatedTier >= self::TIER_SEDANG) {
                $recommendations[] = [
                    'title' => 'Evaluasi Menyeluruh',
                    'description' => 'Lakukan evaluasi menyeluruh atas produk, harga, marketing, dan operasional karena penurunan terjadi di semua indikator.',
                    'priority' => self::tierSeverity($escalatedTier),
                ];
            }
        }

        if ($data['marketing_spend'] > 0 && $data['omzet_current'] > 0) {
            $marketingEfficiency = $data['omzet_current'] / $data['marketing_spend'];
            if ($marketingEfficiency < 3) {
                $diagnoses[] = [
                    'title' => 'Efisiensi Marketing Rendah',
                    'severity' => 'medium',
                    'description' => 'Rasio omzet terhadap biaya marketing hanya ' . round($marketingEfficiency, 1) . 'x.',
                ];
                $recommendations[] = [
                    'title' => 'Optimalkan Strategi Marketing',
                    'description' => 'Evaluasi kembali channel marketing yang fokus pada yang memberikan ROI terbaik.',
                    'priority' => 'medium',
                ];
            }
        }

        if ($data['operational_cost'] > 0 && $data['omzet_current'] > 0) {
            $operationalRatio = ($data['operational_cost'] / $data['omzet_current']) * 100;
            if ($operationalRatio > 70) {
                $diagnoses[] = [
                    'title' => 'Biaya Operasional Tinggi',
                    'severity' => 'high',
                    'description' => 'Biaya operasional mencapai ' . round($operationalRatio, 1) . '% dari omzet.',
                ];
                $recommendations[] = [
                    'title' => 'Kurangi Biaya Operasional',
                    'description' => 'Identifikasi area pengurangan biaya seperti negosiasi ulang dengan supplier.',
                    'priority' => 'high',
                ];
            }
        }

        $allStable = $omzetTier === self::TIER_STABLE
            && $customerTier === self::TIER_STABLE
            && $salesTier === self::TIER_STABLE;

        if ($allStable) {
            $diagnoses[] = [
                'title' => 'Bisnis Dalam Kondisi Baik',
                'severity' => 'low',
                'description' => 'Tidak ada penurunan yang terdeteksi. Kondisi bisnis Anda masih tergolong baik.',
            ];
            $recommendations[] = [
                'title' => 'Pertahankan Performa',
                'description' => 'Teruskan strategi yang sudah baik dan pantau secara berkala.',
                'priority' => 'low',
            ];
        }

        $hasHigh = collect($diagnoses)->contains('severity', 'high');
        $hasMedium = collect($diagnoses)->contains('severity', 'medium');
        $status = $hasHigh ? 'critical' : ($hasMedium ? 'warning' : ($allStable ? 'ok' : 'monitor'));

        return view('decision.analysis', compact('data', 'diagnoses', 'recommendations', 'omzetChange', 'customerChange', 'salesChange', 'status'));
    }
}
