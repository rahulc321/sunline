<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Webhook,ApiLog, Lead, LeadProject};
use App\User;
use Auth;

class ApiTesterController extends Controller
{   

    protected $token;

    // public function __construct(Request $request)
    // {
    //     # get token when controller is created
    //     //$this->token = $this->generateToken($request);
    //     $this->token = "s_RZLJ47XCC3UDXUPGCPXTA7OPT2YCEPBO";
    // }

    public function __construct(Request $request)
    {
        # wrap in middleware to access authenticated user
        $this->middleware(function ($request, $next) {
            $user = auth()->user();  // now this will not be null
           // dd($user); // check user here
    
            if ($user && $this->isTokenValid($user)) {
                # use existing token
                $this->token = $user->opensolar_token;
            } else {
                # generate new token
                $newToken = $this->generateTokenNew($request);
                //$newToken =  "s_SZUTWSHUVB24XSXKDV2WS7MHWJDEAZ6I";
               // dd($newToken); // this will now print user ID properly
    
                if ($newToken) {
                    # save to database
                    $userModel = User::find($user->id);
                    $userModel->opensolar_token = $newToken;
                    $userModel->opensolar_token_expires_at = now()->addDays(7);
                    $userModel->save();

                   // echo '<pre>';print_r($userModel);die;
    
                    $this->token = $newToken;
                } else {
                    //throw new \Exception('Unable to generate OpenSolar token.');
                }
            }
    
            return $next($request);
        });
    }
    

    protected function isTokenValid($user)
    {
        return $user->opensolar_token 
            && $user->opensolar_token_expires_at 
            && now()->lt($user->opensolar_token_expires_at);
    }


    protected function generateTokenNew(Request $request)
    {
        # get the currently logged-in user
        $user = auth()->user();

        # if user not logged in or credentials missing, skip API call
        if (!$user || empty($user->email) || empty($user->open_solar_password)) {
            return null;
        }

        # prepare request for OpenSolar token
        $request['method'] = 'POST';
        $request['url'] = 'https://api.opensolar.com/api-token-auth/';
        $request['bearer_token'] = '';

        $data = [
            'username' => $user->email,
            'password' => $user->open_solar_password,
        ];

        $request['body'] = json_encode($data);
        $response = $this->send($request);

        # decode API response
        $decoded = json_decode($response->getContent(), true);

        # return token if exists
        return $decoded['token'] ?? null;
    }




    # for generate token over open solar plateform
    public function generateToken(Request $request){

        $request['method'] = 'POST';
        $request['url'] = 'https://api.opensolar.com/api-token-auth/';
        $request['bearer_token'] = '';

        $data = [
            'username' => 'makeitbetter@sunlineenergy.com.au',
            'password' => 'Shivam@482',
        ];

        $request['body'] = json_encode($data);

        $response = $this->send($request);

        # if send() returns a JsonResponse, convert it
        $decoded = json_decode($response->getContent(), true);
    
        return $decoded['token'] ?? null;
    }

    # for get webhook
    public function webhook(Request $request){
        //return $this->createProject($request);
        $this->data['webhooks'] = Webhook::get();
        return view('admin.webhook.index',$this->data);
     
    }

    # create webhook
    public function createWebhook(){
        return view('admin.webhook.create');
    }

    # store webhook
    public function storeWebhook(Request $request){

        Webhook::create($request->all());
        return redirect()->route('admin.webhook')->with('success', 'You have successfully added!');
    }

    # edit webhook
    public function editWebhook($id){

        $this->data['webhook'] = Webhook::find($id);
        return view('admin.webhook.edit',$this->data);
    }

    # update webhook
    public function updateWebhook(Request $request, $id){

        $webhook = Webhook::find($id);
        $webhook->update($request->all());
        return redirect()->route('admin.webhook')->with('success', 'You have successfully updated!');
    }

    # delete webhook
    public function deleteWebhook($id){

        $webhook = Webhook::findOrFail($id);
        $webhook->delete(); // ✅ correct
        return redirect()->route('admin.webhook')->with('danger', 'You have successfully deleted!');
    }

    # for send request over webhook
    public function send(Request $request)
    {      
        
        
        $method = strtoupper($request->input('method', 'GET'));
        $url = $request->input('url');
        $body = $request->input('body');
        $bearerToken = $request->input('bearer_token');

        $ch = curl_init();

        // Base headers
        $headers = [
            "accept: application/json",
            "Content-Type: application/json",
            "User-Agent: Laravel-API-Tester"
        ];
        
        // Add Authorization header if bearer token is provided
        if (!empty($bearerToken)) {
            $headers[] = "Authorization: Bearer " . $bearerToken;
        }

        //dd($request->webhook_id);

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => true,   // include headers to extract status code
        ]);

        // If method is POST/PUT/PATCH send body
        if (in_array($method, ['POST', 'PUT', 'PATCH']) && !empty($body)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $rawResponse = curl_exec($ch);

        $error = null;
        if (curl_errno($ch)) {
            $error = curl_error($ch);
        }

        // Separate headers and body
        $headerSize   = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $statusCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseBody = substr($rawResponse, $headerSize);

        curl_close($ch);

        // Try to decode JSON
        $decoded = json_decode($responseBody, true);

        // Extract token if present
        $token = null;
        if (is_array($decoded)) {
            if (isset($decoded['token'])) {
                $token = $decoded['token'];
            } elseif (isset($decoded['access_token'])) {
                $token = $decoded['access_token'];
            }
        }

        // Save API log
        ApiLog::create([
            'webhook_id'         => @$request->webhook_id,
            'method'        => $method,
            'url'           => $url,
            'request_body'  => $body,
            'response_body' => $responseBody,
            'status_code'   => $statusCode,
        ]);

        return response()->json([
            'success'  => $error ? false : true,
            'error'    => $error,
            'response' => $decoded ?: $responseBody,
            'token'    => $token,  // return token separately
            'status'   => $statusCode,
        ]);
    }


    public function triggerwebhook(Request $request)
    {
        $webhook = Webhook::find($request->webhook_id);

        # mapping saved in webhook body (db column => payload key)
        $mapping = json_decode($webhook->body, true);

        # get existing lead
        $lead = Lead::find($request->lead_id);

        if (!$lead) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Lead not found'
            ], 404);
        }

        $leadData = [];

        foreach ($mapping as $dbColumn => $payloadKey) {
            if (!empty($lead->{$dbColumn})) {
                # map DB column value into payload key
                $leadData[$payloadKey] = $lead->{$dbColumn};
            }
        }

        $request['method'] = $webhook->method;
        $request['url'] = $webhook->url;
        $request['bearer_token'] = $webhook->bearer_token;
        $request['body'] = json_encode($leadData);

        $this->send($request);
        return redirect()->back()->with('success', 'You have successfully sync lead!');
    }


    # for api logs
    public function apiLog($webhook_id){
        $this->data['logs'] = ApiLog::where('webhook_id', $webhook_id)->orderBy('id','DESC')->get();
        return view('admin.webhook.logs',$this->data);

    }

    # create project over open solar
    public function createProject(Request $request, $id){
        $lead = Lead::with('leadSource')->find($id);
        //dd($this->token);
        // echo '<pre>';print_r($lead);die;
        $data = [
            "identifier" => rand(1111,9999),
            "is_residential" => "1",
            "lead_source" => @$lead->leadSource->source,
            "notes" => "New.",
             "lat" => "35.12364",
             "lon" => "128.23216",
            "address" => @$lead->address,
            //  "locality" => "Fakesville",
            // "state" => "NSW",
            //  "country_iso2" => "AU",
            // "zip" => "2020",
            "number_of_phases" => "1",
            // "roof_type" => "https://api.opensolar.com/api/roof_types/6/",
            // "assigned_role" => "https://api.opensolar.com/api/orgs/1/roles/123/",
            # assigned_installer_role and assigned_site_inspector_role also available
            "contacts_new" => [
                [
                    "first_name" => @$lead->first_name,
                    "family_name" => @$lead->last_name,
                    "email" =>  @$lead->email,
                    "phone" =>  @$lead->phone,
                    //"date_of_birth" => "1990-01-01",
                    "gender" => "2" # 0 = unset, 1 = female, 2 = male
                ]
            ]
        ];

        $request['method'] = 'POST';
        $request['url'] = 'https://api.opensolar.com/api/orgs/421/projects/';
        $request['bearer_token'] = $this->token;
        $request['body'] = json_encode($data);

       $response =   $this->send($request);

       $decoded = json_decode($response->getContent(), true);
        //dd($decoded['response']['id']);
        if (isset($decoded['response']['contacts_new'][0]['email'][0])) {
            # error from API
            $error = $decoded['response']['contacts_new'][0]['email'][0];
            return redirect()->back()->with('error', $error);
        } else {
            # no error → save into lead_project
            LeadProject::create([
                'lead_id'    => 4,           // comes from your form/request
                'data'       => json_encode($decoded),       // store whole response as JSON
                'status'     => 'New',                   // you can change to whatever logic
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $lead->project_id = @$decoded['response']['id'];
            $lead->save();

            return redirect()->back()->with('success', 'You have  successfully generate quote!');
        }
    }

   
}