@extends('layouts.admin')

@section('title', 'Connect Gmail')

@section('content')
@php
    $isConnected = $lead->is_email_connected && $lead->email_provider === 'gmail';
@endphp

<div class="gmail-connect-page">
    <div class="gmail-glow gmail-glow-one"></div>
    <div class="gmail-glow gmail-glow-two"></div>

    <div class="gmail-shell">
        <div class="gmail-hero">
            <div class="gmail-hero-copy">
                <span class="gmail-kicker">
                    <i class="ph-envelope-simple-open"></i>
                    Email workspace
                </span>
                <h1>Connect Gmail to Sunline CRM</h1>
                <p>
                    Bring customer conversations into one clean workflow, reply faster, and keep every lead's email history close to the work.
                </p>
            </div>

            <div class="gmail-live-panel {{ $isConnected ? 'is-connected' : 'is-locked' }}">
                <div class="gmail-mini-row gmail-mini-row-top">
                    <span class="{{ $isConnected ? 'gmail-spark' : 'gmail-lock-dot' }}">
                        @unless($isConnected)
                            <i class="ph-lock-key"></i>
                        @endunless
                    </span>
                    <div>
                        <strong>{{ $isConnected ? 'Gmail is connected' : 'Gmail is locked' }}</strong>
                        <small>{{ $isConnected ? $lead->connected_email : 'Connect securely with Google OAuth' }}</small>
                    </div>
                </div>

                <div class="gmail-orbit">
                    <span></span>
                    <span></span>
                    <span></span>
                    <div class="gmail-logo-wrap">
                        <img src="https://www.gstatic.com/images/branding/product/2x/gmail_48dp.png" alt="Gmail">
                    </div>
                </div>

                <div class="gmail-security-ring">
                    <span>{{ $isConnected ? 'Live sync ready' : 'Authorization required' }}</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="gmail-alert gmail-alert-success">
                <i class="ph-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="gmail-alert gmail-alert-danger">
                <i class="ph-warning-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="gmail-grid">
            <section class="gmail-card gmail-main-card">
                <div class="gmail-card-header">
                    <div>
                        <span class="gmail-label">Provider</span>
                        <h2>Gmail</h2>
                    </div>
                    <span class="gmail-status {{ $isConnected ? 'is-connected' : 'is-idle' }}">
                        <span></span>
                        {{ $isConnected ? 'Connected' : 'Not connected' }}
                    </span>
                </div>

                <div class="gmail-provider">
                    <div class="gmail-provider-logo">
                        <img src="https://www.gstatic.com/images/branding/product/2x/gmail_48dp.png" alt="Gmail">
                    </div>
                    <div>
                        <h3>{{ $isConnected ? $lead->connected_email : 'Connect your Gmail inbox' }}</h3>
                        <p>
                            {{ $isConnected
                                ? 'This account can send, receive, and sync Gmail messages with your CRM activity.'
                                : 'Authorize Gmail once and start syncing customer messages with your lead timeline.' }}
                        </p>
                    </div>
                </div>

                <div class="gmail-benefits">
                    <div>
                        <i class="ph-paper-plane-tilt"></i>
                        <span>Send replies</span>
                    </div>
                    <div>
                        <i class="ph-clock-counter-clockwise"></i>
                        <span>Sync history</span>
                    </div>
                    <div>
                        <i class="ph-shield-check"></i>
                        <span>Google OAuth</span>
                    </div>
                </div>

                <div class="gmail-actions">
                    @if($isConnected)
                        <a href="{{ route('admin.gmailDisconnect', $lead->id) }}"
                            class="gmail-btn gmail-btn-danger"
                            onclick="return confirm('Are you sure you want to disconnect this Gmail account?');">
                            <i class="ph-plugs-connected"></i>
                            Disconnect Gmail
                        </a>
                    @else
                        <a href="{{ route('admin.gmailConnect', [$lead->id]) }}" class="gmail-btn gmail-btn-primary">
                            <i class="ph-plugs"></i>
                            Connect Gmail
                        </a>
                    @endif
                </div>
            </section>

            <aside class="gmail-card gmail-side-card">
                <span class="gmail-label">What turns on</span>
                <div class="gmail-step is-active">
                    <span>1</span>
                    <div>
                        <strong>Authorize Gmail</strong>
                        <small>Use your Google account to grant secure mailbox access.</small>
                    </div>
                </div>
                <div class="gmail-step">
                    <span>2</span>
                    <div>
                        <strong>Sync messages</strong>
                        <small>Incoming and sent emails can appear in the CRM timeline.</small>
                    </div>
                </div>
                <div class="gmail-step">
                    <span>3</span>
                    <div>
                        <strong>Reply from leads</strong>
                        <small>Keep communication organized around the customer record.</small>
                    </div>
                </div>
            </aside>
        </div>

        <div class="gmail-info-strip">
            <div class="gmail-info-item">
                <i class="ph-arrows-clockwise"></i>
                <div>
                    <strong>Mailbox sync</strong>
                    <small>Keep incoming and sent Gmail messages aligned with CRM activity.</small>
                </div>
            </div>
            <div class="gmail-info-item">
                <i class="ph-lock-key"></i>
                <div>
                    <strong>Secure access</strong>
                    <small>Google OAuth keeps the connection controlled by the account owner.</small>
                </div>
            </div>
            <div class="gmail-info-item">
                <i class="ph-chart-line-up"></i>
                <div>
                    <strong>Lead visibility</strong>
                    <small>Give the team a clearer record of every customer conversation.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gmail-connect-page {
    position: relative;
    height: calc(100vh - 96px);
    min-height: 620px;
    overflow-x: hidden;
    overflow-y: auto;
    padding: 22px 18px 44px;
    background:
        linear-gradient(115deg, rgba(255, 255, 255, .42), rgba(255, 255, 255, 0) 32%),
        radial-gradient(circle at 15% 10%, rgba(66, 133, 244, .22), transparent 28%),
        radial-gradient(circle at 86% 18%, rgba(234, 67, 53, .18), transparent 25%),
        linear-gradient(135deg, #f7fbff 0%, #fff7f5 48%, #f8fff9 100%);
    scrollbar-color: rgba(66, 133, 244, .5) rgba(255, 255, 255, .45);
    scrollbar-width: thin;
}

.gmail-connect-page::-webkit-scrollbar {
    width: 10px;
}

.gmail-connect-page::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, .45);
    border-radius: 999px;
}

.gmail-connect-page::-webkit-scrollbar-thumb {
    border: 2px solid rgba(255, 255, 255, .65);
    border-radius: 999px;
    background: linear-gradient(180deg, #4285f4, #34a853);
}

.gmail-connect-page::before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background-image:
        linear-gradient(rgba(255, 255, 255, .32) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, .32) 1px, transparent 1px);
    background-size: 54px 54px;
    mask-image: linear-gradient(to bottom, rgba(0, 0, 0, .62), transparent 78%);
}

.gmail-shell {
    position: relative;
    z-index: 2;
    max-width: 1120px;
    margin: 0 auto;
}

.gmail-glow {
    position: absolute;
    width: 280px;
    height: 280px;
    border-radius: 999px;
    filter: blur(24px);
    opacity: .65;
    animation: gmailFloat 7s ease-in-out infinite;
}

.gmail-glow-one {
    top: 44px;
    left: -72px;
    background: rgba(251, 188, 5, .34);
}

.gmail-glow-two {
    right: -84px;
    bottom: 40px;
    background: rgba(52, 168, 83, .26);
    animation-delay: -2.5s;
}

.gmail-hero {
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) 360px;
    gap: 18px;
    align-items: stretch;
    margin-bottom: 18px;
}

.gmail-hero-copy,
.gmail-card,
.gmail-live-panel,
.gmail-alert {
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, .82);
    background:
        linear-gradient(145deg, rgba(255, 255, 255, .82), rgba(255, 255, 255, .5)),
        rgba(255, 255, 255, .58);
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .92),
        inset 0 -1px 0 rgba(255, 255, 255, .28),
        0 24px 70px rgba(31, 45, 61, .13);
    backdrop-filter: blur(22px) saturate(140%);
    -webkit-backdrop-filter: blur(22px) saturate(140%);
}

.gmail-hero-copy::before,
.gmail-card::before,
.gmail-live-panel::before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background:
        linear-gradient(115deg, rgba(255, 255, 255, .72), rgba(255, 255, 255, 0) 34%),
        radial-gradient(circle at 12% 0%, rgba(255, 255, 255, .72), transparent 34%);
}

.gmail-hero-copy > *,
.gmail-card > *,
.gmail-live-panel > * {
    position: relative;
    z-index: 1;
}

.gmail-hero-copy {
    background:
        linear-gradient(135deg, rgba(234, 67, 53, .18), rgba(251, 188, 5, .14) 34%, rgba(66, 133, 244, .14) 68%, rgba(52, 168, 83, .16)),
        rgba(255, 255, 255, .62);
    border-radius: 18px;
    padding: 28px;
}

.gmail-kicker,
.gmail-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #3867d6;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0;
    text-transform: uppercase;
}

.gmail-hero h1 {
    max-width: 660px;
    margin: 10px 0 10px;
    color: #172033;
    font-size: 36px;
    font-weight: 850;
    line-height: 1.08;
}

.gmail-hero p,
.gmail-provider p,
.gmail-step small,
.gmail-mini-row small {
    color: #667085;
}

.gmail-hero p {
    max-width: 650px;
    margin: 0;
    font-size: 15px;
    line-height: 1.58;
}

.gmail-live-panel {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 14px;
    min-height: 292px;
    border-radius: 18px;
    padding: 20px;
    background:
        radial-gradient(circle at 50% 18%, rgba(66, 133, 244, .2), transparent 36%),
        linear-gradient(145deg, rgba(232, 241, 255, .78), rgba(255, 255, 255, .52)),
        rgba(255, 255, 255, .58);
}

.gmail-live-panel.is-connected {
    background:
        radial-gradient(circle at 50% 34%, rgba(52, 168, 83, .28), transparent 32%),
        radial-gradient(circle at 16% 8%, rgba(66, 133, 244, .2), transparent 34%),
        linear-gradient(145deg, rgba(232, 255, 241, .82), rgba(255, 255, 255, .54));
}

.gmail-live-panel.is-locked {
    background:
        radial-gradient(circle at 50% 34%, rgba(251, 188, 5, .22), transparent 32%),
        radial-gradient(circle at 18% 10%, rgba(234, 67, 53, .14), transparent 34%),
        linear-gradient(145deg, rgba(255, 248, 229, .8), rgba(255, 255, 255, .54));
}

.gmail-live-panel::after,
.gmail-main-card::after {
    content: "";
    position: absolute;
    top: -60%;
    left: -35%;
    width: 40%;
    height: 220%;
    pointer-events: none;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .48), transparent);
    transform: rotate(18deg);
    animation: gmailSweep 6.5s ease-in-out infinite;
}

.gmail-orbit {
    position: relative;
    display: grid;
    place-items: center;
    width: 148px;
    height: 148px;
    margin: 0 auto;
}

.gmail-orbit span {
    position: absolute;
    inset: 8px;
    border: 1px solid rgba(66, 133, 244, .26);
    border-radius: 999px;
    animation: gmailSpin 8s linear infinite;
}

.gmail-live-panel.is-connected .gmail-orbit span {
    border-color: rgba(52, 168, 83, .34);
    box-shadow: 0 0 24px rgba(52, 168, 83, .12);
    animation-duration: 5.8s;
}

.gmail-live-panel.is-connected .gmail-orbit span:nth-child(2) {
    border-color: rgba(66, 133, 244, .3);
    animation-duration: 4.8s;
}

.gmail-live-panel.is-connected .gmail-orbit span:nth-child(3) {
    border-color: rgba(251, 188, 5, .32);
    animation-duration: 3.8s;
}

.gmail-live-panel.is-locked .gmail-orbit span {
    border-style: dashed;
    border-color: rgba(102, 112, 133, .24);
    animation-duration: 12s;
}

.gmail-orbit span:nth-child(2) {
    inset: 22px;
    border-color: rgba(234, 67, 53, .24);
    animation-duration: 6s;
    animation-direction: reverse;
}

.gmail-orbit span:nth-child(3) {
    inset: 36px;
    border-color: rgba(52, 168, 83, .28);
    animation-duration: 5s;
}

.gmail-logo-wrap,
.gmail-provider-logo {
    display: grid;
    place-items: center;
    background: rgba(255, 255, 255, .9);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .9), 0 18px 38px rgba(31, 45, 61, .14);
}

.gmail-logo-wrap {
    width: 76px;
    height: 76px;
    border-radius: 22px;
    animation: gmailBreathe 2.8s ease-in-out infinite;
}

.gmail-live-panel.is-connected .gmail-logo-wrap {
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .95),
        0 18px 38px rgba(52, 168, 83, .18),
        0 0 0 10px rgba(52, 168, 83, .08);
    animation: gmailConnectedLift 2.4s ease-in-out infinite;
}

.gmail-live-panel.is-locked .gmail-logo-wrap {
    position: relative;
    filter: saturate(.78);
}

.gmail-live-panel.is-locked .gmail-logo-wrap::after {
    content: "\f49e";
    position: absolute;
    right: -8px;
    bottom: -8px;
    display: grid;
    place-items: center;
    width: 34px;
    height: 34px;
    border: 2px solid rgba(255, 255, 255, .88);
    border-radius: 999px;
    color: #fff;
    background: linear-gradient(135deg, #fbbc05, #ea4335);
    box-shadow: 0 12px 24px rgba(234, 67, 53, .22);
    font-family: Phosphor;
    font-size: 16px;
}

.gmail-logo-wrap img,
.gmail-provider-logo img {
    width: 42px;
    height: 42px;
}

.gmail-mini-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, .72);
    background: rgba(255, 255, 255, .68);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .86);
}

.gmail-mini-row-top {
    order: -1;
    width: 100%;
    animation: gmailStatusSlide .65s ease both;
}

.gmail-live-panel.is-connected .gmail-mini-row-top {
    border-color: rgba(52, 168, 83, .18);
    background: linear-gradient(135deg, rgba(235, 250, 241, .9), rgba(255, 255, 255, .66));
}

.gmail-live-panel.is-locked .gmail-mini-row-top {
    border-color: rgba(251, 188, 5, .22);
    background: linear-gradient(135deg, rgba(255, 248, 229, .9), rgba(255, 255, 255, .66));
}

.gmail-mini-row strong,
.gmail-provider h3,
.gmail-step strong {
    display: block;
    color: #172033;
}

.gmail-spark,
.gmail-status span {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    background: #34a853;
    box-shadow: 0 0 0 7px rgba(52, 168, 83, .14);
    animation: gmailPulse 1.6s ease-in-out infinite;
}

.gmail-lock-dot {
    display: grid;
    place-items: center;
    width: 28px;
    height: 28px;
    flex: 0 0 28px;
    border-radius: 999px;
    color: #fff;
    background: linear-gradient(135deg, #fbbc05, #ea4335);
    box-shadow: 0 0 0 7px rgba(251, 188, 5, .16);
    animation: gmailLockPulse 1.9s ease-in-out infinite;
}

.gmail-lock-dot i {
    font-size: 14px;
}

.gmail-security-ring {
    display: flex;
    justify-content: center;
}

.gmail-security-ring span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 34px;
    border: 1px solid rgba(255, 255, 255, .7);
    border-radius: 999px;
    padding: 8px 14px;
    color: #344054;
    background: rgba(255, 255, 255, .58);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .86);
    font-size: 12px;
    font-weight: 850;
}

.gmail-live-panel.is-connected .gmail-security-ring span {
    color: #0f6848;
}

.gmail-live-panel.is-locked .gmail-security-ring span {
    color: #9a6700;
}

.gmail-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
    border-radius: 12px;
    padding: 12px 14px;
    font-weight: 700;
}

.gmail-alert-success {
    color: #0f6848;
}

.gmail-alert-danger {
    color: #b42318;
}

.gmail-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 18px;
}

.gmail-card {
    border-radius: 18px;
    padding: 22px;
    transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease;
}

.gmail-main-card {
    background:
        radial-gradient(circle at 0% 0%, rgba(66, 133, 244, .2), transparent 36%),
        linear-gradient(145deg, rgba(239, 247, 255, .84), rgba(255, 255, 255, .56)),
        rgba(255, 255, 255, .6);
}

.gmail-side-card {
    background:
        radial-gradient(circle at 100% 0%, rgba(251, 188, 5, .22), transparent 38%),
        linear-gradient(145deg, rgba(255, 249, 229, .84), rgba(255, 255, 255, .54)),
        rgba(255, 255, 255, .6);
}

.gmail-card:hover {
    transform: translateY(-3px);
    border-color: rgba(255, 255, 255, .95);
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .95),
        0 30px 80px rgba(31, 45, 61, .16);
}

.gmail-card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 18px;
}

.gmail-card-header h2 {
    margin: 4px 0 0;
    color: #172033;
    font-size: 24px;
    font-weight: 850;
}

.gmail-status {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    flex: 0 0 auto;
    border-radius: 999px;
    padding: 8px 11px;
    color: #172033;
    border: 1px solid rgba(255, 255, 255, .72);
    background: rgba(255, 255, 255, .74);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .9), 0 10px 24px rgba(31, 45, 61, .08);
    font-size: 13px;
    font-weight: 800;
}

.gmail-status.is-idle span {
    background: #fbbc05;
    box-shadow: 0 0 0 7px rgba(251, 188, 5, .16);
}

.gmail-provider {
    display: flex;
    gap: 14px;
    align-items: center;
    padding: 16px;
    border: 1px solid rgba(210, 221, 236, .82);
    border-radius: 14px;
    background:
        linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(235, 246, 255, .58)),
        radial-gradient(circle at 0% 0%, rgba(66, 133, 244, .18), transparent 36%),
        radial-gradient(circle at 100% 100%, rgba(52, 168, 83, .13), transparent 34%);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .92);
}

.gmail-provider-logo {
    width: 64px;
    height: 64px;
    flex: 0 0 64px;
    border-radius: 18px;
}

.gmail-provider h3 {
    margin: 0 0 4px;
    font-size: 18px;
    font-weight: 820;
}

.gmail-provider p {
    margin: 0;
    line-height: 1.48;
}

.gmail-benefits {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
    margin: 16px 0;
}

.gmail-benefits div {
    display: flex;
    align-items: center;
    gap: 10px;
    min-height: 46px;
    border: 1px solid rgba(210, 221, 236, .74);
    border-radius: 10px;
    padding: 10px;
    color: #344054;
    background: rgba(255, 255, 255, .64);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .82);
    font-weight: 750;
}

.gmail-benefits div:nth-child(1) {
    border-color: rgba(234, 67, 53, .18);
    background: linear-gradient(135deg, rgba(255, 239, 237, .82), rgba(255, 255, 255, .58));
}

.gmail-benefits div:nth-child(2) {
    border-color: rgba(66, 133, 244, .18);
    background: linear-gradient(135deg, rgba(235, 243, 255, .86), rgba(255, 255, 255, .58));
}

.gmail-benefits div:nth-child(3) {
    border-color: rgba(52, 168, 83, .18);
    background: linear-gradient(135deg, rgba(235, 250, 241, .86), rgba(255, 255, 255, .58));
}

.gmail-benefits i {
    color: #3867d6;
    font-size: 19px;
}

.gmail-actions {
    display: flex;
    justify-content: flex-end;
}

.gmail-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-height: 42px;
    border-radius: 10px;
    padding: 10px 16px;
    border: 0;
    color: #fff;
    font-weight: 850;
    text-decoration: none;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .26);
    transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
}

.gmail-btn:hover {
    color: #fff;
    text-decoration: none;
    transform: translateY(-2px);
    filter: saturate(1.08);
}

.gmail-btn-primary {
    background: linear-gradient(135deg, #4285f4, #34a853);
    box-shadow: 0 14px 28px rgba(66, 133, 244, .22);
}

.gmail-btn-danger {
    background: linear-gradient(135deg, #ea4335, #c5221f);
    box-shadow: 0 14px 28px rgba(234, 67, 53, .22);
}

.gmail-side-card {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.gmail-step {
    display: grid;
    grid-template-columns: 36px minmax(0, 1fr);
    gap: 10px;
    align-items: flex-start;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, .56);
    background: rgba(255, 255, 255, .62);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8);
}

.gmail-step:nth-of-type(2) {
    border-color: rgba(66, 133, 244, .2);
    background: linear-gradient(135deg, rgba(232, 241, 255, .82), rgba(255, 255, 255, .58));
}

.gmail-step:nth-of-type(3) {
    border-color: rgba(52, 168, 83, .2);
    background: linear-gradient(135deg, rgba(234, 250, 241, .82), rgba(255, 255, 255, .58));
}

.gmail-step:nth-of-type(4) {
    border-color: rgba(234, 67, 53, .18);
    background: linear-gradient(135deg, rgba(255, 239, 237, .82), rgba(255, 255, 255, .58));
}

.gmail-step > span {
    display: grid;
    place-items: center;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    color: #3867d6;
    background: rgba(66, 133, 244, .12);
    font-weight: 850;
}

.gmail-step.is-active > span {
    color: #fff;
    background: linear-gradient(135deg, #4285f4, #34a853);
}

.gmail-step small {
    display: block;
    margin-top: 3px;
    line-height: 1.45;
}

.gmail-info-strip {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-top: 18px;
    padding-bottom: 10px;
}

.gmail-info-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    min-height: 96px;
    border: 1px solid rgba(255, 255, 255, .78);
    border-radius: 14px;
    padding: 14px;
    background:
        linear-gradient(145deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .46)),
        rgba(255, 255, 255, .58);
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .92),
        0 18px 44px rgba(31, 45, 61, .1);
    backdrop-filter: blur(18px) saturate(135%);
    -webkit-backdrop-filter: blur(18px) saturate(135%);
}

.gmail-info-item:nth-child(1) {
    border-color: rgba(66, 133, 244, .2);
    background:
        radial-gradient(circle at 0% 0%, rgba(66, 133, 244, .2), transparent 42%),
        linear-gradient(145deg, rgba(234, 243, 255, .82), rgba(255, 255, 255, .5));
}

.gmail-info-item:nth-child(2) {
    border-color: rgba(52, 168, 83, .2);
    background:
        radial-gradient(circle at 0% 0%, rgba(52, 168, 83, .2), transparent 42%),
        linear-gradient(145deg, rgba(235, 250, 241, .82), rgba(255, 255, 255, .5));
}

.gmail-info-item:nth-child(3) {
    border-color: rgba(251, 188, 5, .28);
    background:
        radial-gradient(circle at 0% 0%, rgba(251, 188, 5, .24), transparent 42%),
        linear-gradient(145deg, rgba(255, 248, 226, .86), rgba(255, 255, 255, .5));
}

.gmail-info-item:nth-child(2) i {
    background: linear-gradient(135deg, #34a853, #4285f4);
}

.gmail-info-item:nth-child(3) i {
    background: linear-gradient(135deg, #fbbc05, #ea4335);
}

.gmail-info-item i {
    display: grid;
    place-items: center;
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    border-radius: 10px;
    color: #fff;
    background: linear-gradient(135deg, #4285f4, #34a853);
    box-shadow: 0 14px 26px rgba(66, 133, 244, .2);
    font-size: 18px;
}

.gmail-info-item strong {
    display: block;
    margin-bottom: 4px;
    color: #172033;
    font-weight: 850;
}

.gmail-info-item small {
    display: block;
    color: #667085;
    line-height: 1.5;
}

@keyframes gmailFloat {
    0%, 100% {
        transform: translate3d(0, 0, 0) scale(1);
    }
    50% {
        transform: translate3d(14px, -18px, 0) scale(1.04);
    }
}

@keyframes gmailSpin {
    to {
        transform: rotate(360deg);
    }
}

@keyframes gmailBreathe {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes gmailConnectedLift {
    0%, 100% {
        transform: translateY(0) scale(1);
    }
    50% {
        transform: translateY(-7px) scale(1.055);
    }
}

@keyframes gmailPulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: .55;
        transform: scale(.82);
    }
}

@keyframes gmailLockPulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 7px rgba(251, 188, 5, .16);
    }
    50% {
        transform: scale(.92);
        box-shadow: 0 0 0 11px rgba(234, 67, 53, .1);
    }
}

@keyframes gmailStatusSlide {
    from {
        opacity: 0;
        transform: translateY(-12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes gmailSweep {
    0%, 45% {
        transform: translateX(0) rotate(18deg);
        opacity: 0;
    }
    55% {
        opacity: .8;
    }
    100% {
        transform: translateX(420%) rotate(18deg);
        opacity: 0;
    }
}

@media (max-width: 991.98px) {
    .gmail-hero,
    .gmail-grid,
    .gmail-info-strip {
        grid-template-columns: 1fr;
    }

    .gmail-hero h1 {
        font-size: 32px;
    }
}

@media (max-width: 575.98px) {
    .gmail-connect-page {
        height: calc(100vh - 72px);
        min-height: 560px;
        padding: 14px 10px 28px;
    }

    .gmail-hero-copy,
    .gmail-card,
    .gmail-live-panel {
        padding: 16px;
        border-radius: 14px;
    }

    .gmail-hero h1 {
        font-size: 28px;
    }

    .gmail-card-header,
    .gmail-provider {
        align-items: flex-start;
        flex-direction: column;
    }

    .gmail-benefits {
        grid-template-columns: 1fr;
    }

    .gmail-actions,
    .gmail-btn {
        width: 100%;
    }
}
</style>
@endsection
