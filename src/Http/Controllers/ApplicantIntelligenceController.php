<?php

namespace EveTools\ApplicantIntelligence\Http\Controllers;

use EveTools\ApplicantIntelligence\Models\ApplicantProfile;
use EveTools\ApplicantIntelligence\Services\RiskScoringService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApplicantIntelligenceController extends Controller
{
    public function index()
    {
        $profiles = ApplicantProfile::orderByDesc('updated_at')->get();

        return view('applicant-intelligence::index', compact('profiles'));
    }

    public function store(Request $request, RiskScoringService $scoringService)
    {
        $validated = $request->validate([
            'character_id' => ['required', 'integer'],
            'signals' => ['required', 'array'],
            'signals.character_age_days' => ['nullable', 'integer'],
            'signals.corp_changes_12m' => ['nullable', 'integer'],
            'signals.npc_corp_days_12m' => ['nullable', 'integer'],
            'signals.red_flag_tags' => ['nullable', 'array'],
        ]);

        $scoreResult = $scoringService->score($validated['signals']);

        $signals = $validated['signals'];
        $signals['reasons'] = $scoreResult['reasons'];

        ApplicantProfile::updateOrCreate(
            ['character_id' => $validated['character_id']],
            [
                'signals' => $signals,
                'risk_score' => $scoreResult['risk_score'],
                'risk_band' => $scoreResult['risk_band'],
            ]
        );

        return redirect()->back();
    }
}
