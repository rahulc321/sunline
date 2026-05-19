<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\User;

class RefreshApiToken extends Command
{
    protected $signature = 'token:refresh';
    protected $description = 'Refresh API token every 7 days';

    
    public function handle()
    {
        $this->info('OpenSolar token refresh started...');
    
        User::whereNotNull('email')
            ->whereNotNull('open_solar_password')
            ->chunk(50, function ($users) {
    
                foreach ($users as $user) {
    
                    try {
                        # call OpenSolar API
                        $response = Http::post('https://api.opensolar.com/api-token-auth/', [
                            'username' => $user->email,
                            'password' => $user->open_solar_password,
                        ]);
    
                        if (!$response->successful()) {
                            $this->error("Token failed for user ID: {$user->id}");
                            continue;
                        }
    
                        $data = $response->json();
    
                        if (empty($data['token'])) {
                            $this->error("Token missing for user ID: {$user->id}");
                            continue;
                        }
    
                        $newToken = $data['token'];
    
                        # update user token
                        $userModel = User::find($user->id);
                        $userModel->opensolar_token = $newToken;
                        $userModel->opensolar_token_expires_at = now()->addDays(7);
                        $userModel->save();
    
                        $this->info("Token updated for user ID: {$user->id}");
    
                    } catch (\Exception $e) {
                        $this->error("Error for user ID {$user->id}: " . $e->getMessage());
                    }
                }
            });
    
        $this->info('OpenSolar token refresh completed.');
    }
    
}
