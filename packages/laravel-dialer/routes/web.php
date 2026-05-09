<?php

use PowerDialer\Dialer\Http\Controllers\DialerController;

Route::get('dialer',                              [DialerController::class, 'index'])->name('dialer.index');
Route::get('dialer/softphone',                    [DialerController::class, 'softphone'])->name('dialer.softphone');
Route::get('dialer/token',                        [DialerController::class, 'token'])->name('dialer.token');
Route::post('dialer/status',                      [DialerController::class, 'setStatus'])->name('dialer.status');
Route::post('dialer/group',                       [DialerController::class, 'setGroup'])->name('dialer.group');
Route::get('dialer/queue/status',                 [DialerController::class, 'queueStatus'])->name('dialer.queue.status');
Route::post('dialer/call',                        [DialerController::class, 'call'])->name('dialer.call');
Route::post('dialer/manual-dial',                 [DialerController::class, 'manualDial'])->name('dialer.manual-dial');
Route::post('dialer/inbound-accept',              [DialerController::class, 'inboundAccept'])->name('dialer.inbound-accept');
Route::post('dialer/inbound-pickup/{callId}',     [DialerController::class, 'inboundPickup'])->name('dialer.inbound-pickup');
Route::post('dialer/dial-customer/{callId}',      [DialerController::class, 'dialCustomer'])->name('dialer.dial-customer');
Route::post('dialer/hangup-call/{callId}',        [DialerController::class, 'hangupCall'])->name('dialer.hangup-call');
Route::post('dialer/disposition/{callId}',        [DialerController::class, 'disposition'])->name('dialer.disposition');
Route::post('dialer/hold/{callId}',               [DialerController::class, 'hold'])->name('dialer.hold');
Route::post('dialer/transfer/{callId}',           [DialerController::class, 'transfer'])->name('dialer.transfer');
Route::post('dialer/conference/{callId}/add',     [DialerController::class, 'conferenceAdd'])->name('dialer.conference.add');
Route::get('dialer/call-log',                     [DialerController::class, 'callLog'])->name('dialer.call-log');
Route::get('dialer/recent-calls',                 [DialerController::class, 'recentCalls'])->name('dialer.recent-calls');
Route::post('dialer/test-ring',                   [DialerController::class, 'testRing'])->name('dialer.test-ring');
