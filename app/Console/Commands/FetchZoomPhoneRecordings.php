<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchZoomPhoneRecordings extends Command
{
    protected $signature = 'zoom:fetch-phone-recordings';
    protected $description = 'Fetch today’s Zoom Phone recordings and store in DB';

    public function handle()
    {
        
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                Log::error('Unable to fetch Zoom access token');
                return;
            }

            $today = Carbon::now('UTC')->format('Y-m-d'); // Zoom uses UTC
            $baseUrl = "https://api.zoom.us/v2/phone/recordings";
            $pageSize = 300;
            $nextPageToken = '';
            $allRecordings = [];

            do {
                $url = $baseUrl . "?from={$today}&to={$today}&page_size={$pageSize}";
                if (!empty($nextPageToken)) {
                    $url .= "&next_page_token=" . urlencode($nextPageToken);
                }

                $response = Http::withToken($accessToken)->get($url);
                
                if ($response->failed()) {
                    Log::error('Failed to fetch Zoom recordings: ' . $response->body());
                    return;
                }

                $data = $response->json();
                if (!empty($data['recordings'])) {
                    $allRecordings = array_merge($allRecordings, $data['recordings']);
                }

                

                $nextPageToken = $data['next_page_token'] ?? '';

            } while (!empty($nextPageToken));
           
            foreach ($allRecordings as $rec) {
                 
                $startTime = isset($rec['date_time']) ? \Carbon\Carbon::parse($rec['date_time'])->toDateTimeString() : null;
                $endTime   = isset($rec['end_time']) ? \Carbon\Carbon::parse($rec['end_time'])->toDateTimeString() : null;
            
                DB::table('zoom_phone_recordings')->updateOrInsert(
                    ['recording_id' => $rec['id']],
                    [
                        'caller_number'  => $rec['caller_number'] ?? null,
                        'caller_name'    => $rec['caller_name'] ?? null,
                        'callee_number'  => $rec['callee_number'] ?? null,
                        'callee_name'    => $rec['callee_name'] ?? null,
                        'direction'      => $rec['direction'] ?? null,
                        'duration'       => $rec['duration'] ?? null,
                        'download_url'   => $rec['download_url'] ?? null,
                        'start_time'     => $startTime,
                        'end_time'       => $endTime,
                        'recording_type' => $rec['recording_type'] ?? null,
                        'call_id'        => $rec['call_id'] ?? null,
                        'updated_at'     => now(),
                        'created_at'     => now(),
                    ]
                );
            }
            echo 'Done';
            Log::info('Zoom phone recordings fetched and saved');

        } catch (\Exception $e) {

            dd($e->getMessage());
            Log::error('Error fetching Zoom recordings: ' . $e->getMessage());
        }
    }

    private function getAccessToken()
    {
        $clientId     = env('ZOOM_CLIENT_ID');
        $clientSecret = env('ZOOM_CLIENT_SECRET');
        $accountId    = env('ZOOM_ACCOUNT_ID');

        $response = Http::asForm()->withBasicAuth($clientId, $clientSecret)
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $accountId,
            ]);

        if ($response->failed()) {
            Log::error('Zoom Token Error: ' . $response->body());
            return null;
        }

        return $response->json()['access_token'];
    }
}
