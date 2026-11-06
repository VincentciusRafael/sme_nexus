<?php

use App\Http\Controllers\BusinessAutopsy\Admin\AuditLogController;
use App\Http\Controllers\BusinessAutopsy\Admin\BusinessCategoryController;
use App\Http\Controllers\BusinessAutopsy\Admin\DashboardController;
use App\Http\Controllers\BusinessAutopsy\Admin\DiagnosisController;
use App\Http\Controllers\BusinessAutopsy\Admin\RecommendationController;
use App\Http\Controllers\BusinessAutopsy\Admin\RuleController;
use App\Http\Controllers\BusinessAutopsy\Admin\RuleTesterController;
use App\Http\Controllers\BusinessAutopsy\Admin\SmeProfileController;
use App\Http\Controllers\BusinessAutopsy\Admin\SymptomController;
use App\Http\Controllers\BusinessAutopsy\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'verified', 'role:admin'])
    ->prefix('admin/business-autopsy')
    ->name('admin.business-autopsy.')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('users', UserController::class)->except('show');

        Route::resource('profiles', SmeProfileController::class)->except('show');

        Route::resource('categories', BusinessCategoryController::class)->except('show');

        Route::resource('symptoms', SymptomController::class)->except(['show', 'destroy']);
        Route::post('symptoms/{symptom}/deactivate', [SymptomController::class, 'deactivate'])->name('symptoms.deactivate');
        Route::post('symptoms/{symptom}/activate', [SymptomController::class, 'activate'])->name('symptoms.activate');

        Route::resource('diagnoses', DiagnosisController::class)->except(['show', 'destroy']);
        Route::post('diagnoses/{diagnosis}/deactivate', [DiagnosisController::class, 'deactivate'])->name('diagnoses.deactivate');
        Route::post('diagnoses/{diagnosis}/activate', [DiagnosisController::class, 'activate'])->name('diagnoses.activate');

        Route::get('rules/tester', [RuleTesterController::class, 'index'])->name('rules.tester');
        Route::post('rules/tester', [RuleTesterController::class, 'run'])->name('rules.tester.run');
        Route::resource('rules', RuleController::class)->except('destroy');
        Route::post('rules/{rule}/publish', [RuleController::class, 'publish'])->name('rules.publish');
        Route::post('rules/{rule}/deactivate', [RuleController::class, 'deactivate'])->name('rules.deactivate');
        Route::post('rules/{rule}/activate', [RuleController::class, 'activate'])->name('rules.activate');

        Route::resource('recommendations', RecommendationController::class)->except(['show', 'destroy']);
        Route::post('recommendations/{recommendation}/deactivate', [RecommendationController::class, 'deactivate'])->name('recommendations.deactivate');
        Route::post('recommendations/{recommendation}/activate', [RecommendationController::class, 'activate'])->name('recommendations.activate');

        Route::get('audit', [AuditLogController::class, 'index'])->name('audit.index');
    });
