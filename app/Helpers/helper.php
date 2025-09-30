<?php
use Illuminate\Support\Facades\Mail;
use App\Models\Email;


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