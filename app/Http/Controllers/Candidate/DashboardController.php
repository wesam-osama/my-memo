<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Support\Frontend\MockCandidateData;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

/**
 * Figma 13 — Good morning, Maya (candidate dashboard).
 * Frontend presentation only.
 */
class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $dashboard = MockCandidateData::dashboard();
        $firstName = Str::of((string) auth()->user()?->name)->trim()->before(' ')->toString() ?: 'there';
        $dashboard['greeting'] = str_replace('Maya', $firstName, $dashboard['greeting']);

        return view('candidate.dashboard', [
            'pageTitle' => 'Overview | TalentBridge',
            'uiRole' => 'candidate',
            'showMockBanner' => false,
            'dashboard' => $dashboard,
            'frontendOnly' => true,
        ]);
    }
}
