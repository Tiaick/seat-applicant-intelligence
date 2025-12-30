<?php

namespace EveTools\ApplicantIntelligence\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    protected $table = 'applicant_profiles';

    protected $fillable = [
        'character_id',
        'signals',
        'risk_score',
        'risk_band',
    ];

    protected $casts = [
        'signals' => 'array',
        'risk_score' => 'integer',
    ];
}
