<?php

namespace App\Http\Controllers;

use App\Models\LearningVideo;
use App\Models\Opportunity;
use App\Models\OpportunitySubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OpportunityController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->validate(['type' => ['nullable','in:course,training,scholarship']])['type'] ?? 'course';
        $opportunities = Opportunity::where('type', $type)->where('is_active', true)
            ->orderByRaw("CASE availability_status WHEN 'open' THEN 1 WHEN 'consult' THEN 2 ELSE 3 END")
            ->orderBy('deadline')->get();
        $videos = LearningVideo::where('is_active', true)->where('section_type', $type)->latest()->get();
        return view('opportunities.index', compact('type', 'opportunities', 'videos'));
    }

    public function storeSubmission(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:30'],
            'organization_type' => ['required', 'in:institution,school,academy,training_center,other'],
            'organization_name' => ['required', 'string', 'max:180'],
            'opportunity_type' => ['required', 'in:course,training,scholarship'],
        ]);

        OpportunitySubmission::create($data + ['user_id' => $request->user()->id]);

        return back()->with('submission_success', 'Tu solicitud ha sido enviada. La revisaremos antes de publicarla y recibirás una respuesta en los próximos días.');
    }
}
