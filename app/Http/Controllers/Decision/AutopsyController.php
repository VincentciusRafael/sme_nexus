<?php

namespace App\Http\Controllers\Decision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutopsyController extends Controller
{
    public function index()
    {
        return view('decision.autopsy');
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

        $omzetChange = (($data['omzet_current'] - $data['omzet_prev']) / $data['omzet_prev']) * 100;
        $customerChange = (($data['customer_current'] - $data['customer_prev']) / $data['customer_prev']) * 100;
        $salesChange = (($data['sales_current'] - $data['sales_prev']) / $data['sales_prev']) * 100;

        $diagnoses = [];
        $recommendations = [];

        if ($omzetChange < -10) {
            $diagnoses[] = [
                'title' => 'Omzet Menurun Signifikan',
                'severity' => 'high',
                'description' => 'Omzet menurun ' . abs(round($omzetChange, 1)) . '% dari periode sebelumnya.',
            ];

            if ($customerChange < -10) {
                $diagnoses[] = [
                    'title' => 'Jumlah Pelanggan Menurun',
                    'severity' => 'high',
                    'description' => 'Jumlah pelanggan menurun ' . abs(round($customerChange, 1)) . '%.',
                ];
                $recommendations[] = [
                    'title' => 'Tingkatkan Akuisisi Pelanggan',
                    'description' => 'Fokuskan pada strategi marketing untuk menarik pelanggan baru.',
                    'priority' => 'high',
                ];
            }

            if ($salesChange < -10) {
                $diagnoses[] = [
                    'title' => 'Volume Penjualan Menurun',
                    'severity' => 'medium',
                    'description' => 'Volume penjualan menurun ' . abs(round($salesChange, 1)) . '%.',
                ];
                $recommendations[] = [
                    'title' => 'Tingkatkan Retensi Pelanggan',
                    'description' => 'Buat program loyalitas atau penawaran khusus untuk pelanggan existing.',
                    'priority' => 'medium',
                ];
            }
        }

        if ($data['marketing_spend'] > 0) {
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

        if ($data['operational_cost'] > 0) {
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

        if (empty($diagnoses)) {
            $diagnoses[] = [
                'title' => 'Bisnis Dalam Kondisi Baik',
                'severity' => 'low',
                'description' => 'Tidak ada masalah signifikan yang terdeteksi.',
            ];
            $recommendations[] = [
                'title' => 'Pertahankan Performa',
                'description' => 'Teruskan strategi yang sudah baik dan pantau secara berkala.',
                'priority' => 'low',
            ];
        }

        $hasHigh = collect($diagnoses)->contains('severity', 'high');
        $hasMedium = collect($diagnoses)->contains('severity', 'medium');
        $status = $hasHigh ? 'critical' : ($hasMedium ? 'warning' : 'ok');

        return view('decision.analysis', compact('data', 'diagnoses', 'recommendations', 'omzetChange', 'customerChange', 'salesChange', 'status'));
    }
}
