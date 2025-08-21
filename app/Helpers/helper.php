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

            return true;
        // } catch (\Exception $e) {
        //     \Log::error('Email send failed: '.$e->getMessage());
        //     return false;
        // }
    }
}