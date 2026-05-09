<?php

use PowerDialer\Dialer\Http\Controllers\TwilioWebhookController;

Route::post('call-status',         [TwilioWebhookController::class, 'callStatus'])->name('call-status');
Route::post('recording',           [TwilioWebhookController::class, 'recording'])->name('recording');
Route::post('sms-inbound',         [TwilioWebhookController::class, 'smsInbound'])->name('sms-inbound');
Route::post('voice',               [TwilioWebhookController::class, 'voice'])->name('voice');
Route::post('inbound-fallback',    [TwilioWebhookController::class, 'inboundFallback'])->name('inbound-fallback');
Route::post('voicemail-complete',  [TwilioWebhookController::class, 'voicemailComplete'])->name('voicemail-complete');
Route::get('conference-join',      [TwilioWebhookController::class, 'conferenceJoin'])->name('conference-join')->withoutMiddleware(['twilio.verify']);
Route::get('hold-music',           [TwilioWebhookController::class, 'holdMusic'])->name('hold-music')->withoutMiddleware(['twilio.verify']);
Route::post('voicemail-action',    [TwilioWebhookController::class, 'voicemailAction'])->name('voicemail-action');
