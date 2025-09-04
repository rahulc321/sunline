<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Webhook,ApiLog, Lead};

class ApiTesterController extends Controller
{
    # for get webhook
    public function webhook(){
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



}