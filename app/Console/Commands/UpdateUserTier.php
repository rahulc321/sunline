<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Models\Lead;
use App\Models\Tier;
use Carbon\Carbon;

class UpdateUserTier extends Command
{
    protected $signature = 'tier:update';
    protected $description = 'Update user solar & battery tier every month';

    public function handle()
    {
        $month = Carbon::now()->month;
        $year  = Carbon::now()->year;

        $users = User::whereHas('roles', function($q) {
            $q->where('title', 'Sales Rep');
        })->where('id',23)->get();
        
       
        foreach ($users as $user) {

            # count sold leads for this user
            $solarQuantity = Lead::where('status', 'sold')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('assign_rep', $user->id)
                ->where('category','Solar')
                ->count();

            $batteryQuantity = Lead::where('status', 'sold')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('assign_rep', $user->id)
            ->where('category','Battery')
            ->count();

            $sb = Lead::where('status', 'sold')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('assign_rep', $user->id)
            ->where('category','Solar+Battery')
            ->count();

            
            # get solar tier
            $solarTier = Tier::where('category', 'solar')
                ->where('min_value', '<=', $solarQuantity)
                ->where('max_value', '>=', $solarQuantity)
                ->first();

            # get battery tier
            $batteryTier = Tier::where('category', 'battery')
                ->where('min_value', '<=', $batteryQuantity)
                ->where('max_value', '>=', $batteryQuantity)
                ->first();
            
            //dd($solarTier?->tier_name);
            # update user tier in database


            if($sb > 0){
                $solarTier->tier_name += $sb;
                $batteryTier->tier_name += $sb;
            }

            $user1 = User::find($user->id);
            $user1->tier_solar = $solarTier->tier_name ?? 0;
            $user1->tier_battery = $batteryTier->tier_name ?? 0;
            $user1->save();

            // if ($user1) {
            //     $user1->update([
            //         'tier_solar'   => $solarTier->tier_name ?? 0,
            //         'tier_battery' => $batteryTier->tier_name ?? 0,
            //     ]);
            // }
        }

        $this->info('User tiers updated successfully.');
    }
}
