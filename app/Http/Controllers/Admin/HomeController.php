<?php

namespace App\Http\Controllers\Admin;
use App\Models\{LeadSource, LeadContact, ContactFollowUp, Lead};

class HomeController
{
    public function index()
    {
        $this->data['assign_lead'] = Lead::whereNotNull('assign_rep')->whereNotIn('status', ['Qualified', 'Sold'])->get();
        $this->data['contacts'] = Lead::whereNotNull('assign_rep')->whereIn('status', ['Qualified'])->get();
        $this->data['closed_sale'] = Lead::whereNotNull('assign_rep')->whereIn('status', ['Sold'])->get();
        return view('home',$this->data);
    }
}
