<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use App\Models\Activity;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class SmsController extends Controller
{		
	private $authKey;
    private $senderId;
    private $route;
    private $send_url;
    private $otp_url;

    public function __construct()
    {
        $this->authKey = env('MSG91_AUTH_KEY');
        $this->senderId = env('MSG91_SENDER_ID', 'MSGIND');
        $this->route = env('MSG91_ROUTE', '4'); // 4 for transactional
        $this->send_url = 'https://api.msg91.com/api/sendhttp.php';
        $this->otp_url = 'https://api.msg91.com/api/v5/otp';
    }
	
	/*
	*
	* Function to Send Text Message.
	*
	*/	
	public function sendSms(Request $request)
    {
		abort_if(Gate::denies('intake_communications_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
        $request->validate([
            'mobile' => 'required|digits:10',
            'message' => 'required|max:160'
        ]);

        $mobile = $request->mobile;
        $message = $request->message;

        try {
            $response = Http::post($this->send_url, [
                'authkey' => $this->authKey,
                'mobiles' => $mobile,
                'message' => $message,
                'sender' => $this->senderId,
                'route' => $this->route,
                'country' => ($request->country_code) ? $request->country_code : '91'
            ]);
			
			/*
			Activity::log(
				'sms_api_response', 
				'create',   
				'Text Message Api has been initiated with response ' . json_encode($response),
				[
					'details' => $response,
					'intake_id' => null
				]           
			); 
			*/

            if ($response->successful()) {
				$return_response = [
					'status' => 'success',
					'message' => 'SMS sent successfully!'
				];
            } else {
				$return_response = [
					'status' => 'error',
					'message' => 'Failed to send SMS. Please try again.'
				];
            }
        } catch (\Exception $e) {
			$return_response = [
					'status' => 'error',
					'message' => 'Error: ' . $e->getMessage()
				];
        }
		
		return $return_response; 
    }

    /*
	*
	* Function to Send Text Message using OTP API.
	*
	*/
    public function sendOtp(Request $request)
    {
		abort_if(Gate::denies('intake_communications_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $mobile = $request->mobile;
        $otp = rand(1000, 9999); // Generate 4-digit OTP

        try {
            $response = Http::post($this->otp_url, [
                'template_id' => env('MSG91_TEMPLATE_ID'),
                'mobile' => $mobile,
                'authkey' => $this->authKey,
                'otp' => $otp
            ]);

            if ($response->successful()) {
                // Store OTP in session for verification
                session(['otp' => $otp, 'otp_mobile' => $mobile]);
                $return_response = [
					'status' => 'success',
					'message' => 'OTP sent successfully!'
				];
            } else {
				$return_response = [
					'status' => 'error',
					'message' => 'Failed to send OTP.'
				];
            }
        } catch (\Exception $e) {
            $return_response = [
					'status' => 'error',
					'message' => 'Error: ' . $e->getMessage()
				];
        }
		return $return_response; 
    }
	
}