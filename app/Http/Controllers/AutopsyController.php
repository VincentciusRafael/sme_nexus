<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutopsyController extends Controller
{
    public function index()
    {
        return view('autopsy.index');
    }

    public function analyze(Request $request)
    {
        $data = $request->validate([
            'omzet_prev' => 'required|numeric',
            'omzet_current' => 'required|numeric',
            'customer_prev' => 'required|numeric',
            'customer_current' => 'required|numeric',
            'sales_prev' => 'required|numeric',
            'sales_current' => 'required|numeric',
            'product_count' => 'required|numeric',
            'avg_price' => 'required|numeric',
            'marketing_spend' => 'required|numeric',
            'operational_cost' => 'required|numeric',
        ]);

        // Hitung perubahan
        $omzetChange = (($data['omzet_current'] - $data['omzet_prev']) / $data['omzet_prev']) * 100;
        $customerChange = (($data['customer_current'] - $data['customer_prev']) / $data['customer_prev']) * 100;
        $salesChange = (($data['sales_current'] - $data['sales_prev']) / $data['sales_prev']) * 100;

        // Diagnosis masalah
        $diagnoses = [];
        $recommendations = [];

        // Analisis Omzet
        if ($omzetChange < -10) {
            $diagnoses[] = [
                'title' => 'Omzet Menurun Signifikan',
                'severity' => 'high',
                'description' => 'Omzet menurun ' . abs(round($omzetChange, 1)) . '% dari periode sebelumnya. Ini menunjukkan masalah serius dalam penjualan.',
            ];

            // Analisis penyebab
            if ($customerChange < -10) {
                $diagnoses[] = [
                    'title' => 'Jumlah Pelanggan Menurun',
                    'severity' => 'high',
                    'description' => 'Jumlah pelanggan menurun ' . abs(round($customerChange, 1)) . '. Ini adalah penyebab utama omzet menurun.',
                ];
                $recommendations[] = [
                    'title' => 'Tingkatkan Akuisisi Pelanggan',
                    'description' => 'Fokuskan pada strategi marketing untuk menarik pelanggan baru. Pertimbangkan promosi khusus atau diskon untuk pelanggan baru.',
                    'priority' => 'high',
                ];
            }

            if ($salesChange < -10) {
                $diagnoses[] = [
                    'title' => 'Volume Penjualan Menurun',
                    'severity' => 'medium',
                    'description' => 'Volume penjualan menurun ' . abs(round($salesChange, 1)) . '. Pelanggan yang ada mungkin mengurangi pembelian.',
                ];
                $recommendations[] = [
                    'title' => 'Tingkatkan Retensi Pelanggan',
                    'description' => 'Buat program loyalitas atau penawaran khusus untuk pelanggan existing agar mereka terus membeli.',
                    'priority' => 'medium',
                ];
            }

            if ($data['avg_price'] > 0 && $data['sales_current'] > 0) {
                $avgTransaction = $data['omzet_current'] / $data['sales_current'];
                if ($avgTransaction < $data['avg_price'] * 0.8) {
                    $diagnoses[] = [
                        'title' => 'Nilai Transaksi Menurun',
                        'severity' => 'medium',
                        'description' => 'Rata-rata nilai transaksi per penjualan menurun. Pelanggan membeli produk yang lebih murah.',
                    ];
                    $recommendations[] = [
                        'title' => 'Tingkatkan Nilai Transaksi',
                        'description' => 'Tawarkan produk dengan harga lebih tinggi atau bundling produk untuk meningkatkan nilai transaksi.',
                        'priority' => 'medium',
                    ];
                }
            }
        }

        // Analisis Marketing
        if ($data['marketing_spend'] > 0) {
            $marketingEfficiency = $data['omzet_current'] / $data['marketing_spend'];
            if ($marketingEfficiency < 3) {
                $diagnoses[] = [
                    'title' => 'Efisiensi Marketing Rendah',
                    'severity' => 'medium',
                    'description' => 'Rasio omzet terhadap biaya marketing hanya ' . round($marketingEfficiency, 1) . 'x. Ini di bawah standar industri (3-5x).',
                ];
                $recommendations[] = [
                    'title' => 'Optimalkan Strategi Marketing',
                    'description' => 'Evaluasi kembali channel marketing yang fokus pada yang memberikan ROI terbaik. Pertimbangkan untuk mengurangi biaya marketing yang tidak efektif.',
                    'priority' => 'medium',
                ];
            }
        }

        // Analisis Operasional
        if ($data['operational_cost'] > 0) {
            $operationalRatio = ($data['operational_cost'] / $data['omzet_current']) * 100;
            if ($operationalRatio > 70) {
                $diagnoses[] = [
                    'title' => 'Biaya Operasional Tinggi',
                    'severity' => 'high',
                    'description' => 'Biaya operasional mencapai ' . round($operationalRatio, 1) . '% dari omzet. Ini mengurangi margin keuntungan secara signifikan.',
                ];
                $recommendations[] = [
                    'title' => 'Kurangi Biaya Operasional',
                    'description' => 'Identifikasi area pengurangan biaya seperti negosiasi ulang dengan supplier, efisiensi energi, atau otomatisasi proses.',
                    'priority' => 'high',
                ];
            }
        }

        // Analisis Produk
        if ($data['product_count'] < 10) {
            $diagnoses[] = [
                'title' => 'Variasi Produk Terbatas',
                'severity' => 'low',
                'description' => 'Hanya ada ' . $data['product_count'] . ' produk. Variasi yang terbatas dapat mengurangi daya tarik bagi pelanggan.',
            ];
            $recommendations[] = [
                'title' => 'Tambahkan Variasi Produk',
                'description' => 'Pertimbangkan untuk menambah variasi produk atau layanan untuk menarik lebih banyak pelanggan.',
                'priority' => 'low',
            ];
        }

        // Jika tidak ada masalah
        if (empty($diagnoses)) {
            $diagnoses[] = [
                'title' => 'Bisnis Dalam Kondisi Baik',
                'severity' => 'low',
                'description' => 'Tidak ada masalah signifikan yang terdeteksi. Bisnis Anda berjalan dengan baik.',
            ];
            $recommendations[] = [
                'title' => 'Pertahankan Performa',
                'description' => 'Teruskan strategi yang sudah baik dan pantau secara berkala untuk memastikan tidak ada penurunan.',
                'priority' => 'low',
            ];
        }

        return view('autopsy.analysis', compact('data', 'diagnoses', 'recommendations', 'omzetChange', 'customerChange', 'salesChange'));
    }
}
