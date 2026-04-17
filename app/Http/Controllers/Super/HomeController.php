<?php

namespace App\Http\Controllers\Super;
use App\Models\{LeadSource, LeadContact, ContactFollowUp, Lead};
use Illuminate\Support\Collection;

class HomeController
{
    public function index()
    {
        $this->data['assign_lead'] = Lead::with('leadSource')
            ->whereNotNull('assign_rep')
            ->whereNotIn('status', ['Qualified', 'Sold'])
            ->get();

        $this->data['contacts'] = Lead::with('leadSource')
            ->whereNotNull('assign_rep')
            ->whereIn('status', ['Qualified'])
            ->get();

        $this->data['closed_sale'] = Lead::with('leadSource')
            ->whereNotNull('assign_rep')
            ->whereIn('status', ['Sold'])
            ->get();

        $allTrackedLeads = $this->data['assign_lead']
            ->concat($this->data['contacts'])
            ->concat($this->data['closed_sale']);

        $this->data['recent_leads'] = Lead::with(['leadSource', 'getAssignUserName'])
            ->whereNotNull('assign_rep')
            ->latest('id')
            ->take(6)
            ->get();

        $this->data['source_breakdown'] = $allTrackedLeads
            ->groupBy(function ($lead) {
                return optional($lead->leadSource)->source ?: 'Unknown Source';
            })
            ->map(function (Collection $leads, $source) use ($allTrackedLeads) {
                $count = $leads->count();
                $total = max($allTrackedLeads->count(), 1);

                return [
                    'source' => $source,
                    'count' => $count,
                    'percent' => round(($count / $total) * 100),
                ];
            })
            ->sortByDesc('count')
            ->take(8)
            ->values();

        return view('superadmin_dashboard',$this->data);
    }
}
