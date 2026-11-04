<?php

use App\Models\User;

test('admin dapat membuka seluruh halaman master data', function (string $routeName) {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route($routeName))
        ->assertOk();
})->with([
    'admin.business-autopsy.dashboard',
    'admin.business-autopsy.users.index',
    'admin.business-autopsy.users.create',
    'admin.business-autopsy.profiles.index',
    'admin.business-autopsy.profiles.create',
    'admin.business-autopsy.categories.index',
    'admin.business-autopsy.categories.create',
    'admin.business-autopsy.symptoms.index',
    'admin.business-autopsy.symptoms.create',
    'admin.business-autopsy.diagnoses.index',
    'admin.business-autopsy.diagnoses.create',
    'admin.business-autopsy.recommendations.index',
    'admin.business-autopsy.recommendations.create',
    'admin.business-autopsy.rules.index',
    'admin.business-autopsy.rules.create',
    'admin.business-autopsy.rules.tester',
    'admin.business-autopsy.audit.index',
]);

test('pemilik umkm tidak dapat membuka halaman admin master data', function (string $routeName) {
    $owner = User::factory()->create();

    $this->actingAs($owner)
        ->get(route($routeName))
        ->assertForbidden();
})->with([
    'admin.business-autopsy.users.index',
    'admin.business-autopsy.profiles.index',
    'admin.business-autopsy.categories.index',
    'admin.business-autopsy.symptoms.index',
    'admin.business-autopsy.diagnoses.index',
    'admin.business-autopsy.recommendations.index',
    'admin.business-autopsy.rules.index',
    'admin.business-autopsy.rules.tester',
    'admin.business-autopsy.audit.index',
]);
