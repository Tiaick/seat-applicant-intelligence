<?php

namespace EveTools\ApplicantIntelligence\Services;

class RiskScoringService
{
    /**
     * Score applicant risk based on provided signals.
     *
     * @param array $signals
     * @return array{risk_score:int,risk_band:string,reasons:array<int,string>}
     */
    public function score(array $signals): array
    {
        $score = 0;
        $reasons = [];

        $characterAge = (int) ($signals['character_age_days'] ?? 0);
        if ($characterAge < 30) {
            $score += 40;
            $reasons[] = 'Character age under 30 days';
        } elseif ($characterAge < 90) {
            $score += 20;
            $reasons[] = 'Character age under 90 days';
        }

        $corpChanges = (int) ($signals['corp_changes_12m'] ?? 0);
        if ($corpChanges >= 5) {
            $score += 30;
            $reasons[] = 'Frequent corporation changes (5+ in 12 months)';
        } elseif ($corpChanges >= 3) {
            $score += 15;
            $reasons[] = 'Multiple corporation changes (3-4 in 12 months)';
        }

        $npcCorpDays = (int) ($signals['npc_corp_days_12m'] ?? 0);
        if ($npcCorpDays > 180) {
            $score += 20;
            $reasons[] = 'Extended time in NPC corporations (over 180 days in 12 months)';
        }

        $redFlagTags = $signals['red_flag_tags'] ?? [];
        if (is_array($redFlagTags)) {
            foreach ($redFlagTags as $tag) {
                $score += 10;
                $reasons[] = "Red flag: {$tag}";
            }
        }

        $score = max(0, min(100, $score));

        $band = 'low';
        if ($score >= 60) {
            $band = 'high';
        } elseif ($score >= 30) {
            $band = 'medium';
        }

        return [
            'risk_score' => $score,
            'risk_band' => $band,
            'reasons' => $reasons,
        ];
    }
}
