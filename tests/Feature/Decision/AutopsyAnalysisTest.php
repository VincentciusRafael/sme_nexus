<?php

use App\Models\User;

test('analisis menampilkan error validasi pada halaman form', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->from('/decision/autopsy')
        ->post('/decision/autopsy/analyze', [
            'omzet_prev' => 0,
            'omzet_current' => 100,
            'customer_prev' => 10,
            'customer_current' => 8,
            'sales_prev' => 10,
            'sales_current' => 8,
            'product_count' => 5,
            'avg_price' => 1000,
            'marketing_spend' => 100,
            'operational_cost' => 100,
        ]);

    $response
        ->assertSessionHasErrors('omzet_prev')
        ->assertRedirect('/decision/autopsy');

    $this->actingAs($user)
        ->get('/decision/autopsy')
        ->assertOk()
        ->assertSee('Data belum dapat diproses.');
});
