<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeadCommission;
use App\User;
use App\Models\Lead;
use App\Models\Tier;

class CalculateLeadCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-lead-commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $leads = Lead::whereIn('status', ['Sold'])->get();

        foreach ($leads as $lead) {

            $userData = User::find($lead->assign_rep);

            $solarCommision = Tier::where('category', 'solar')
            ->where('tier_name', $userData->tier_solar)
             
            ->first();
    
            $batteryCommision = Tier::where('category', 'battery')
            ->where('tier_name', $userData->tier_battery)
             
            ->first();

            

            $solarRate   = $solarCommision->commission ?? 0;
            $batteryRate = $batteryCommision->commission ?? 0;

            $solarCommission = 0;
            $batteryCommission = 0;

            # solar
            if (in_array($lead->category, ['Solar', 'Solar+Battery'])) {
                $solarCommission = ($lead->solar_kw ?? 0) * $solarRate;
            }

            # battery
            if (in_array($lead->category, ['Battery', 'Solar+Battery'])) {
                $batteryCommission = ($lead->battery_kw ?? 0) * $batteryRate;
            }

            $totalCommission = $solarCommission + $batteryCommission;

            # Save or update record
            LeadCommission::updateOrCreate(
                ['lead_id' => $lead->id],
                [
                    'solar_commission'   => round($solarCommission, 2),
                    'battery_commission' => round($batteryCommission, 2),
                    'user_id'=> $lead->assign_rep,
                ]
            );
        }

        $this->info("Commission calculation completed.");
    }

}