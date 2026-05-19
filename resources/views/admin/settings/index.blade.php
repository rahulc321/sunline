@extends('layouts.admin')
@section('title', 'Settings')

@section('styles')
@parent
<style>
    .settings-page {
        --set-ink: #111827;
        --set-muted: #667085;
        --set-blue: #2563eb;
        --set-teal: #0f766e;
        position: relative;
        padding: 18px !important;
        border-radius: 18px;
        color: var(--set-ink);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .94), rgba(239, 248, 255, .78)),
            radial-gradient(circle at 10% 5%, rgba(56, 189, 248, .20), transparent 32%),
            radial-gradient(circle at 92% 8%, rgba(129, 140, 248, .16), transparent 30%),
            #f7fbff;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .94);
    }

    .settings-shell {
        display: grid;
        gap: 16px;
    }

    .settings-toolbar,
    .settings-panel {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 18px;
        background: linear-gradient(145deg, rgba(255, 255, 255, .95), rgba(246, 250, 255, .86));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .96),
            0 18px 38px rgba(21, 32, 51, .10);
        backdrop-filter: blur(12px);
    }

    .settings-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .36)),
            linear-gradient(135deg, rgba(37, 99, 235, .10), rgba(20, 184, 166, .10));
    }

    .settings-title {
        margin: 0;
        color: var(--set-ink);
        font-size: 22px;
        font-weight: 850;
        letter-spacing: 0;
    }

    .settings-subtitle {
        margin-top: 3px;
        color: var(--set-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .settings-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 38px;
        padding: 8px 12px;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 999px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .78), rgba(255, 255, 255, .24)),
            rgba(37, 99, 235, .10);
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .88),
            0 10px 22px rgba(21, 32, 51, .05);
    }

    .settings-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .settings-stat {
        position: relative;
        overflow: hidden;
        min-height: 122px;
        padding: 15px 16px;
        border: 1px solid rgba(255, 255, 255, .34);
        border-radius: 13px;
        color: #ffffff;
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #0c6ca8 0%, #0583c2 54%, #25b7ee 100%);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .34),
            inset 0 -28px 42px rgba(255, 255, 255, .08),
            0 14px 24px rgba(15, 23, 42, .12);
        isolation: isolate;
    }

    .settings-stat:before {
        content: "";
        position: absolute;
        right: -38px;
        bottom: -58px;
        width: 138px;
        height: 138px;
        border-radius: 50%;
        background:
            radial-gradient(circle at 34% 34%, rgba(255, 255, 255, .36), rgba(255, 255, 255, .05) 58%, transparent 60%),
            repeating-linear-gradient(90deg, rgba(255, 255, 255, .14) 0 1px, transparent 1px 6px);
        opacity: .55;
        z-index: -1;
    }

    .settings-stat.stat-green {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #158b4b 0%, #20b35f 56%, #58d887 100%);
    }

    .settings-stat.stat-indigo {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #4853bb 0%, #5b6bd8 56%, #8094ff 100%);
    }

    .stat-top {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 11px;
        background: rgba(255, 255, 255, .18);
        color: #ffffff;
        font-size: 18px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 8px 14px rgba(15, 23, 42, .10);
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .16);
        color: rgba(255, 255, 255, .94);
        font-size: 10px;
        font-weight: 850;
    }

    .stat-value {
        position: relative;
        z-index: 1;
        margin: 18px 0 3px;
        color: #ffffff;
        font-size: 30px;
        line-height: 1;
        font-weight: 850;
    }

    .stat-label {
        position: relative;
        z-index: 1;
        color: rgba(255, 255, 255, .88);
        font-size: 12px;
        font-weight: 800;
    }

    .settings-panel-head {
        padding: 16px 18px;
        border-bottom: 1px solid rgba(219, 227, 239, .78);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .82), rgba(255, 255, 255, .34)),
            linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(20, 184, 166, .08));
    }

    .settings-panel-title {
        margin: 0;
        font-size: 18px;
        font-weight: 850;
        color: var(--set-ink);
    }

    .settings-panel-subtitle {
        margin-top: 3px;
        color: var(--set-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .settings-form {
        padding: 18px;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .setting-field {
        min-height: 128px;
        padding: 14px;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 15px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .42)),
            rgba(37, 99, 235, .04);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .94),
            0 10px 22px rgba(21, 32, 51, .05);
    }

    .setting-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: #334155;
        font-size: 13px;
        font-weight: 850;
    }

    .setting-label i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--set-blue), var(--set-teal));
        color: #ffffff;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .26),
            0 8px 16px rgba(37, 99, 235, .16);
    }

    .setting-field .form-control {
        min-height: 42px;
        border: 1px solid #d7dfec;
        border-radius: 12px;
        background: rgba(255, 255, 255, .82);
        color: #1f2937;
        font-weight: 750;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .90);
    }

    .setting-field .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .settings-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    .settings-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        min-width: 150px;
        padding: 10px 16px;
        border: 0;
        border-radius: 12px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, 0) 36%),
            linear-gradient(135deg, var(--set-blue), var(--set-teal));
        color: #ffffff;
        font-size: 13px;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .30),
            0 10px 20px rgba(37, 99, 235, .20);
    }

    @media (max-width: 991.98px) {
        .settings-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .settings-stats,
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
        .settings-page {
            padding: 12px !important;
        }

        .settings-actions,
        .settings-submit {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="content settings-page pt-0">
    <div class="settings-shell">
        <div class="settings-toolbar">
            <div>
                <h1 class="settings-title">Settings</h1>
                <div class="settings-subtitle">Update commission and office access configuration.</div>
            </div>
            <span class="settings-badge">
                <i class="ph-gear"></i> System Settings
            </span>
        </div>

        <section class="settings-stats">
            <div class="settings-stat">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-fire"></i></span>
                    <span class="stat-pill">Heatpump</span>
                </div>
                <div class="stat-value">₹{{ number_format((float) $settings['heatpump_commission'], 2) }}</div>
                <div class="stat-label">Commission</div>
            </div>
            <div class="settings-stat stat-green">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-wind"></i></span>
                    <span class="stat-pill">Aircon</span>
                </div>
                <div class="stat-value">₹{{ number_format((float) $settings['aircon_commission'], 2) }}</div>
                <div class="stat-label">Commission</div>
            </div>
            <div class="settings-stat stat-indigo">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-wifi-high"></i></span>
                    <span class="stat-pill">Office IP</span>
                </div>
                <div class="stat-value">{{ @$settings['office_ip_address'] ?: '-' }}</div>
                <div class="stat-label">Allowed Network</div>
            </div>
        </section>

        <div class="settings-panel">
            <div class="settings-panel-head">
                <h2 class="settings-panel-title">Configuration</h2>
                <div class="settings-panel-subtitle">These values are saved to the existing settings table.</div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="settings-form">
                @csrf
                <div class="settings-grid">
                    <div class="setting-field">
                        <label class="setting-label">
                            <i class="ph-fire"></i>
                            Heatpump Commission (₹)
                        </label>
                        <input type="number" step="0.01" name="heatpump_commission"
                            class="form-control" value="{{ $settings['heatpump_commission'] }}" required>
                    </div>

                    <div class="setting-field">
                        <label class="setting-label">
                            <i class="ph-wind"></i>
                            Aircon Commission (₹)
                        </label>
                        <input type="number" step="0.01" name="aircon_commission"
                            class="form-control" value="{{ $settings['aircon_commission'] }}" required>
                    </div>

                    <div class="setting-field">
                        <label class="setting-label">
                            <i class="ph-wifi-high"></i>
                            Office IP Address
                        </label>
                        <input type="text" name="office_ip_address"
                            class="form-control" value="{{ @$settings['office_ip_address'] }}">
                    </div>
                </div>

                <div class="settings-actions">
                    <button type="submit" class="settings-submit">
                        <i class="ph-check"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
