<?php

namespace Database\Seeders;

use App\Domain\BusinessAutopsy\Enums\RuleOperator;
use App\Domain\BusinessAutopsy\Enums\Severity;
use App\Models\BusinessAutopsy\Symptom;
use App\Models\BusinessCategory;
use Illuminate\Database\Seeder;

class BusinessAutopsyMasterSeeder extends Seeder
{
    /**
     * Seed kategori dan gejala dasar agar modul dapat langsung digunakan.
     */
    public function run(): void
    {
        foreach ([
            ['category_name' => 'Kuliner', 'deskripsi' => 'Usaha makanan dan minuman'],
            ['category_name' => 'Retail', 'deskripsi' => 'Perdagangan barang eceran'],
            ['category_name' => 'Jasa', 'deskripsi' => 'Usaha jasa dan konsultasi'],
            ['category_name' => 'Manufaktur', 'deskripsi' => 'Produksi dan pengolahan barang'],
            ['category_name' => 'Pertanian', 'deskripsi' => 'Pertanian, perkebunan, dan agribisnis'],
            ['category_name' => 'Teknologi', 'deskripsi' => 'Produk digital dan teknologi'],
        ] as $category) {
            BusinessCategory::query()->updateOrCreate(
                ['category_name' => $category['category_name']],
                ['deskripsi' => $category['deskripsi']]
            );
        }

        foreach ([
            [
                'code' => 'revenue_declined',
                'name' => 'Penurunan omzet',
                'description' => 'Omzet/pendapatan turun lebih dari 10% dibanding periode sebelumnya.',
                'metric_key' => 'revenue_change_percent',
                'operator' => RuleOperator::LessThan,
                'threshold' => -10,
                'severity' => Severity::High,
            ],
            [
                'code' => 'customer_declined',
                'name' => 'Penurunan jumlah pelanggan',
                'description' => 'Jumlah pelanggan turun lebih dari 20% dibanding periode sebelumnya.',
                'metric_key' => 'customer_change_percent',
                'operator' => RuleOperator::LessThan,
                'threshold' => -20,
                'severity' => Severity::Medium,
            ],
            [
                'code' => 'high_operating_cost',
                'name' => 'Biaya operasional tinggi',
                'description' => 'Rasio biaya operasional terhadap pendapatan melebihi 70%.',
                'metric_key' => 'operating_expense_ratio',
                'operator' => RuleOperator::GreaterThan,
                'threshold' => 70,
                'severity' => Severity::High,
            ],
            [
                'code' => 'low_profit_margin',
                'name' => 'Margin laba rendah',
                'description' => 'Margin laba di bawah 10%.',
                'metric_key' => 'profit_margin',
                'operator' => RuleOperator::LessThan,
                'threshold' => 10,
                'severity' => Severity::Medium,
            ],
        ] as $symptom) {
            Symptom::query()->updateOrCreate(
                ['code' => $symptom['code']],
                [
                    'name' => $symptom['name'],
                    'description' => $symptom['description'],
                    'metric_key' => $symptom['metric_key'],
                    'operator' => $symptom['operator']->value,
                    'threshold' => $symptom['threshold'],
                    'severity' => $symptom['severity']->value,
                    'is_active' => true,
                ]
            );
        }
    }
}
