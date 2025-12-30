<?php

use EveTools\ApplicantIntelligence\Http\Controllers\ApplicantIntelligenceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('applicant-intelligence')->group(function () {
    Route::get('/', [ApplicantIntelligenceController::class, 'index'])->name('applicant-intelligence.index');
    Route::post('/', [ApplicantIntelligenceController::class, 'store'])->name('applicant-intelligence.store');
});
