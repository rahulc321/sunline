<?php

namespace PowerDialer\Dialer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Twilio\Security\RequestValidator;

class ValidateTwilioSignature
{
    public function handle(Request $request, Closure $next)
    {
        $authToken = config('dialer.twilio.auth_token');

        // No auth token configured — skip (e.g. local dev without Twilio creds)
        if (empty($authToken)) {
            return $next($request);
        }

        $signature = $request->header('X-Twilio-Signature', '');
        $url       = $request->fullUrl();
        $params    = $request->isMethod('POST') ? $request->post() : [];

        $validator = new RequestValidator($authToken);

        if (! $validator->validate($signature, $url, $params)) {
            abort(403, 'Invalid Twilio signature');
        }

        return $next($request);
    }
}
