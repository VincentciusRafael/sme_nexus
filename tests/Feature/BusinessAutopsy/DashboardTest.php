<?php

use App\Models\User;

test('sme owner dapat membuka dashboard business autopsy', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('business-autopsy.dashboard'));

    $response->assertOk();
    $response->assertSee('Dashboard UMKM');
});

test('admin tidak dapat membuka dashboard owner', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route('business-autopsy.dashboard'))
        ->assertForbidden();
});

test('admin dapat membuka dashboard admin business autopsy', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->get(route('admin.business-autopsy.dashboard'));

    $response->assertOk();
    $response->assertSee('Dashboard Admin');
});

test('sme owner tidak dapat membuka dashboard admin', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.business-autopsy.dashboard'))
        ->assertForbidden();
});

test('tamu diarahkan ke login saat membuka business autopsy', function () {
    $this->get(route('business-autopsy.dashboard'))
        ->assertRedirect(route('login'));
});
