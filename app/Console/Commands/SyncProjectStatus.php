<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use App\User;
class SyncProjectStatus extends Command
{
    protected $signature = 'projects:sync-status';
    protected $description = 'Sync project status from OpenSolar API and update leads';

    public function handle()
    {
        # Example: Fetch all leads that have a project_id
        $leads = Lead::whereNotNull('project_id')->get();

        foreach ($leads as $lead) {
            $user  = User::find($lead->assign_rep);
            $url = "https://api.opensolar.com/api/orgs/421/projects/{$lead->project_id}/";

            $response = Http::withToken($user->opensolar_token)
                            ->get($url);

            if ($response->successful()) {
                $project = $response->json();
                //echo '<pre>';print_r($decoded['project_sold']);die;
                # check if project status is "Sold"
               if (@$project['project_sold'] == 2) {
                    $lead->status = 'Sold';
                    $lead->save();

                    $this->info("Lead {$lead->id} updated to Sold.");
                }
            } else {
                $this->error("Failed to fetch project {$lead->project_id}");
            }
        }

        return 0;
    }
}
