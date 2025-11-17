<?php
use Illuminate\Support\Facades\Mail;
use App\Models\Email;
use App\Models\Lead;
use Carbon\Carbon;
use App\Models\Tier;


if (! function_exists('testFunction')) {
	function testFunction()
	{
		dd('test fun');
	}
}


if (! function_exists('sendGlobalEmail')) {
    function sendGlobalEmail($to, $subject, $body, $templateId = null, $category = null, $leadId = null,$type = null,$data=[])
    {
		//try {
            # replace placeholders
            foreach ($data as $key => $value) {
                $body = str_replace('{'.$key.'}', $value, $body);
                $subject = str_replace('{'.$key.'}', $value, $subject);
            }

            # render blade view into HTML
            $htmlBody = view('admin.emails.custom-email', [
                'subject' => $subject,
                'body'    => $body,
            ])->render();

            # send email
            Mail::html($htmlBody, function ($message) use ($to, $subject) {
                $message->to($to)
                        ->subject($subject);
            });

			 # save to db
			 Email::create([
                'template_id'     => $templateId,
                'category'        => $category,
                'subject'         => $subject,
                'body'            => $body,
				'type'            => $type,
                'recipient_email' => $to,
                'lead_id'         => $leadId,
            ]);

            return true;
        // } catch (\Exception $e) {
        //     \Log::error('Email send failed: '.$e->getMessage());
        //     return false;
        // }
    }

    
}


if (! function_exists('isSalesRep')) {
    /**
     * Check if the current authenticated user has the Sales Rep role
     *
     * @return int 1 if Sales Rep, 0 otherwise
     */
    function isSalesRep()
    {
        $user = Auth::user();
        if (!$user) {
            return 0;
        }

        // assuming your role title is stored in 'title'
        return $user->roles->contains('title', 'Sales Rep') ? 1 : 0;
    }
}

if (! function_exists('getCommision')) {
    /**
     * Check if the current authenticated user has the Sales Rep role
     *
     * @return int 1 if Sales Rep, 0 otherwise
     */
    function getCommision($userId)
    {   
        $user = Auth::user();
        $isSalesRep = $user->roles->contains('title', 'Sales Rep');

        # if sales rep, use current user ID, otherwise use provided user ID
        $finalUserId = $isSalesRep ? $user->id : $userId;

        $user->id = $finalUserId;

        
        if (!$user) {
            return 0;
        }
        $month = Carbon::now()->month;
        $year  = Carbon::now()->year;

        # get all sold leads of this month
        $quantity = Lead::where('status', 'sold')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('assign_rep', $user->id)
            ->count();

        $solarCommision = Tier::where('category', 'solar')
        ->where('min_value', '<=', $quantity)
        ->where('max_value', '>=', $quantity)
        ->first();

        $batteryCommision = Tier::where('category', 'battery')
        ->where('min_value', '<=', $quantity)
        ->where('max_value', '>=', $quantity)
        ->first();

        return [
                'solarTier'=> @$solarCommision->commission,
                'batteryCommision'=>@$batteryCommision->commission
                ];
    }
}

if (! function_exists('sendGlobalEmail1')) {
    function sendGlobalEmail1($to, $subject, $body, $templateId = null, $category = null, $leadId = null,$type = null,$data=[])
    {
		//try {
            # replace placeholders
            foreach ($data as $key => $value) {
                $body = str_replace('{'.$key.'}', $value, $body);
                $subject = str_replace('{'.$key.'}', $value, $subject);
            }

            # render blade view into HTML
            $htmlBody = view('admin.emails.custom-email', [
                'subject' => $subject,
                'body'    => $body,
            ])->render();

            # send email
            Mail::html($htmlBody, function ($message) use ($to, $subject) {
                $message->to($to)
                        ->subject($subject);
            });

			 

            return true;
         
    }

    
}