<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Power Dialer</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg:           #f4f4f0;
  --surface:      #ffffff;
  --surface2:     #f7f7f4;
  --border:       rgba(0,0,0,0.09);
  --border-md:    rgba(0,0,0,0.14);
  --text:         #141414;
  --text2:        #6b6b6b;
  --text3:        #aaaaaa;
  --blue:         #6366f1;
  --blue-dark:    #000075;
  --blue-bg:      #eef2ff;
  --blue-text:    #4338ca;
  --blue-grad:    linear-gradient(135deg, #6366f1, #000075);
  --green:        #16a34a;
  --green-bg:     #dcfce7;
  --amber:        #d97706;
  --amber-bg:     #fef3c7;
  --amber-text:   #92400e;
  --red:          #dc2626;
  --red-bg:       #fee2e2;
  --radius:       10px;
  --radius-lg:    14px;
  --radius-pill:  999px;
  --font:         'DM Sans', sans-serif;
  --mono:         'DM Mono', monospace;
}

body {
  font-family: var(--font);
  background: var(--bg);
  height: 100vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  font-size: 13px;
  color: var(--text);
}

/* ─── Incoming overlay ───────────────────────────────────── */
#incomingOverlay {
  position: fixed; top: 0; left: 0; right: 0; z-index: 200;
  background: var(--surface);
  border-bottom: 1px solid var(--border-md);
  padding: 12px 16px 14px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.12);
  display: none;
  animation: slideDown .22s ease;
}
@keyframes slideDown { from { transform:translateY(-100%); opacity:0; } to { transform:translateY(0); opacity:1; } }
.inc-row  { display:flex; align-items:center; gap:11px; margin-bottom:11px; }
.inc-av   {
  width:46px; height:46px; border-radius:50%; flex-shrink:0;
  background: var(--green-bg);
  display:flex; align-items:center; justify-content:center;
  font-size:17px; font-weight:700; color: var(--green);
  animation: incRing 1.1s ease-in-out infinite;
}
@keyframes incRing { 0%,100%{box-shadow:0 0 0 0 rgba(22,163,74,.3)} 50%{box-shadow:0 0 0 9px rgba(22,163,74,0)} }
.inc-lbl   { font-size:10px; color:var(--text3); text-transform:uppercase; letter-spacing:.06em; }
.inc-from  { font-size:16px; font-weight:700; color:var(--text); margin-top:2px; }
.inc-name  { font-size:12px; color:var(--text2); margin-top:1px; }
.inc-meta  { display:flex; align-items:center; gap:6px; margin-top:3px; }
.inc-group { font-size:10px; color:var(--text3); background:var(--surface2); border-radius:4px; padding:1px 6px; }
.inc-case  { font-size:10px; font-weight:600; color:var(--blue); cursor:pointer; }
.inc-case:hover { text-decoration:underline; }
.inc-btns  { display:grid; grid-template-columns:1fr 1fr; gap:8px; }

/* ─── Top bar ────────────────────────────────────────────── */
.top-bar {
  display:flex; align-items:center; justify-content:space-between;
  padding:11px 16px;
  background:var(--surface);
  border-bottom:.5px solid var(--border);
  flex-shrink:0;
}
.brand { display:flex; align-items:center; gap:9px; }
.brand-logo {
  width:30px; height:30px; border-radius:9px;
  background: var(--blue-grad);
  display:flex; align-items:center; justify-content:center;
  color:#fff; font-size:14px;
  box-shadow:0 3px 10px rgba(99,102,241,.35); flex-shrink:0;
}
.brand-name { font-size:13px; font-weight:700; color:var(--text); line-height:1.2; }
.brand-sub  { font-size:10px; color:var(--text3); }

.status-pill {
  display:flex; align-items:center; gap:6px;
  padding:5px 11px; border-radius:var(--radius-pill);
  border:.5px solid var(--border-md);
  font-size:12px; font-weight:600; color:var(--text);
  background:var(--surface2); white-space:nowrap;
}
.status-pill.oncall  { background:var(--blue-bg); border-color:#a5b4fc; color:var(--blue-text); }
.status-pill.wrapup  { background:var(--amber-bg); border-color:#fcd34d; color:var(--amber-text); }
.status-pill.offline { background:var(--surface2); color:var(--text3); }
.s-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }
.sd-available { background:#22c55e; box-shadow:0 0 0 2px rgba(34,197,94,.22); animation:sdPulse 2s infinite; }
.sd-on_call   { background:var(--blue); box-shadow:0 0 0 2px rgba(99,102,241,.22); }
.sd-wrap_up   { background:var(--amber); }
.sd-break     { background:#ec4899; }
.sd-offline   { background:#94a3b8; }
@keyframes sdPulse { 0%,100%{box-shadow:0 0 0 2px rgba(34,197,94,.22)} 50%{box-shadow:0 0 0 5px rgba(34,197,94,0)} }

/* ─── Controls strip ─────────────────────────────────────── */
.ctrl-strip {
  padding:7px 12px; background:var(--surface);
  border-bottom:.5px solid var(--border);
  display:flex; gap:7px; align-items:center; flex-shrink:0;
}
.ctrl-select {
  flex:1; background:var(--surface2); border:.5px solid var(--border-md);
  border-radius:8px; color:var(--text); font-size:11.5px; font-family:var(--font);
  font-weight:500; padding:5px 9px; outline:none; cursor:pointer;
}
.ctrl-select:focus { border-color:var(--blue); }
.ctrl-num-badge {
  background:var(--blue-bg); border:.5px solid #a5b4fc;
  color:var(--blue-text); font-size:10px; font-weight:700;
  padding:3px 9px; border-radius:6px; white-space:nowrap;
}
.ctrl-num-badge.empty { display:none; }

/* ─── Body ───────────────────────────────────────────────── */
.sp-body { flex:1; overflow-y:auto; display:flex; flex-direction:column; min-height:0; }
.sp-body::-webkit-scrollbar { width:3px; }
.sp-body::-webkit-scrollbar-thumb { background:rgba(0,0,0,.1); border-radius:3px; }

.screen { display:none; flex-direction:column; flex:1; }
.screen.active { display:flex; }

/* ─── Tab bar ────────────────────────────────────────────── */
.tab-bar {
  display:flex; background:var(--surface);
  border-bottom:.5px solid var(--border); flex-shrink:0;
}
.tab {
  flex:1; display:flex; align-items:center; justify-content:center;
  padding:9px 0; cursor:pointer; color:var(--text3);
  border-bottom:2px solid transparent; transition:all .15s;
  flex-direction:column; gap:2px;
}
.tab.active { color:var(--blue); border-bottom-color:var(--blue); }
.tab i      { font-size:16px; }
.tab-lbl    { font-size:8.5px; font-weight:600; letter-spacing:.04em; text-transform:uppercase; }

/* ─── Shared components ──────────────────────────────────── */
.avatar {
  width:40px; height:40px; border-radius:50%; flex-shrink:0;
  display:flex; align-items:center; justify-content:center;
  font-size:14px; font-weight:700; color:#fff;
}
.av-blue   { background:var(--blue-grad); }
.av-purple { background:linear-gradient(135deg,#818cf8,#6366f1); }
.av-teal   { background:linear-gradient(135deg,#34d399,#059669); }
.av-amber  { background:linear-gradient(135deg,#fbbf24,#d97706); }

.badge {
  display:inline-flex; align-items:center;
  padding:2px 8px; border-radius:var(--radius-pill);
  font-size:11px; font-weight:500;
}
.badge-blue  { background:var(--blue-bg);  color:var(--blue-text); }
.badge-green { background:var(--green-bg); color:#14532d; }
.badge-amber { background:var(--amber-bg); color:var(--amber-text); }
.badge-gray  { background:var(--surface2); color:var(--text2); border:.5px solid var(--border-md); }

.btn {
  display:flex; align-items:center; justify-content:center; gap:6px;
  border:none; border-radius:var(--radius); padding:10px 14px;
  font-family:var(--font); font-size:12px; font-weight:600;
  cursor:pointer; transition:all .15s;
}
.btn-primary { background:var(--blue-grad); color:#fff; box-shadow:0 3px 12px rgba(99,102,241,.3); }
.btn-primary:hover { opacity:.9; }
.btn-success { background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; box-shadow:0 3px 12px rgba(34,197,94,.3); }
.btn-success:hover { opacity:.9; }
.btn-danger  { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; box-shadow:0 3px 12px rgba(239,68,68,.3); }
.btn-danger:hover { opacity:.9; }
.btn-ghost   { background:var(--surface2); border:.5px solid var(--border-md); color:var(--text2); }
.btn-ghost:hover { background:#ececea; }
.btn:disabled { opacity:.4; cursor:not-allowed; }

.section-label  { font-size:11px; color:var(--text2); text-transform:uppercase; letter-spacing:.05em; }
.section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }

/* ═════════════════════════════════════════════════════════
   IDLE SCREEN
═════════════════════════════════════════════════════════ */
.avail-bar {
  display:flex; align-items:center; gap:8px;
  padding:7px 16px; background:var(--surface2);
  border-bottom:.5px solid var(--border); flex-shrink:0;
}
.avail-label   { font-size:12px; color:var(--text2); }
.avail-options { display:flex; gap:4px; margin-left:auto; }
.avail-btn {
  padding:3px 11px; border-radius:var(--radius-pill);
  font-family:var(--font); font-size:11px; font-weight:500;
  border:.5px solid var(--border-md); background:var(--surface);
  color:var(--text2); cursor:pointer; transition:all .15s;
}
.avail-btn.sel { background:var(--blue-grad); color:#fff; border-color:var(--blue); }

.queue-section { padding:12px 16px; border-bottom:.5px solid var(--border); flex-shrink:0; }
.queue-item {
  display:flex; align-items:center; gap:10px;
  padding:8px 0; border-bottom:.5px solid var(--border);
}
.queue-item:last-child { border-bottom:none; }
.q-item-info { flex:1; min-width:0; }
.q-name { font-size:13px; font-weight:600; color:var(--text); }
.q-meta { font-size:11px; color:var(--text2); margin-top:1px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.q-wait { font-size:11px; color:var(--text2); margin-left:auto; white-space:nowrap; font-family:var(--mono); flex-shrink:0; padding-right:8px; }
.q-wait.hot { color:var(--amber); font-weight:600; }
.q-empty { text-align:center; padding:16px 0; color:var(--text3); font-size:12px; }
.q-empty i { font-size:26px; display:block; margin-bottom:5px; opacity:.35; }

.queue-call-btn {
  padding:5px 11px; border-radius:var(--radius);
  background:var(--blue-grad); border:none; color:#fff;
  font-family:var(--font); font-size:11px; font-weight:600;
  cursor:pointer; white-space:nowrap; flex-shrink:0;
  box-shadow:0 2px 8px rgba(99,102,241,.25);
  display:flex; align-items:center; gap:4px;
}
.queue-skip-btn {
  padding:5px 9px; border-radius:var(--radius);
  background:var(--surface2); border:.5px solid var(--border-md); color:var(--text3);
  font-family:var(--font); font-size:11px; cursor:pointer; flex-shrink:0;
}

/* ── Outbound dial ── */
.dial-section { padding:12px 16px; border-bottom:.5px solid var(--border); flex-shrink:0; }
.dial-input-row {
  display:flex; align-items:center; gap:8px;
  background:var(--surface2); border-radius:var(--radius);
  border:.5px solid var(--border-md); padding:8px 12px; margin-bottom:10px;
}
.dial-input {
  flex:1; background:transparent; border:none; outline:none;
  font-size:20px; font-weight:500; color:var(--text);
  font-family:var(--mono); letter-spacing:.04em;
}
.dial-input::placeholder { color:var(--text3); font-size:13px; font-family:var(--font); font-weight:400; letter-spacing:0; }
.del-btn { background:none; border:none; cursor:pointer; color:var(--text2); padding:3px; display:flex; align-items:center; }

.keypad-grid {
  display:grid; grid-template-columns:repeat(3,1fr);
  gap:1px; background:var(--border);
  border-radius:var(--radius); overflow:hidden;
  border:.5px solid var(--border-md);
}
.key {
  background:var(--surface); padding:13px 0; text-align:center;
  cursor:pointer; user-select:none; transition:background .1s;
}
.key:hover  { background:var(--blue-bg); }
.key:active, .key.pressed { background:var(--blue-bg); }
.key-num     { font-size:20px; font-weight:400; color:var(--text); line-height:1; }
.key-letters { font-size:9px; letter-spacing:.1em; color:var(--text3); margin-top:3px; height:11px; }

.idle-call-btn {
  display:flex; align-items:center; justify-content:center; gap:7px;
  width:100%; padding:12px; background:var(--blue-grad); border:none;
  border-radius:var(--radius-lg); color:#fff; font-family:var(--font);
  font-size:14px; font-weight:600; cursor:pointer; margin-top:10px;
  box-shadow:0 4px 14px rgba(99,102,241,.3); transition:opacity .15s;
}
.idle-call-btn:hover { opacity:.9; }
.idle-call-btn:disabled { opacity:.4; cursor:not-allowed; }

/* ── Recent calls ── */
.recent-section { padding:12px 16px; flex:1; }
.recent-item {
  display:flex; align-items:center; gap:10px;
  padding:8px 0; border-bottom:.5px solid var(--border); cursor:pointer;
}
.recent-item:last-child { border-bottom:none; }
.recent-info { flex:1; }
.recent-name    { font-size:13px; font-weight:500; color:var(--text); }
.recent-meta    { display:flex; align-items:center; gap:6px; margin-top:2px; }
.recent-num     { font-size:11px; color:var(--text2); }
.recent-caseid  { font-size:11px; font-weight:600; color:var(--blue); }
.recent-actions { display:flex; flex-direction:column; align-items:flex-end; gap:4px; flex-shrink:0; }
.recent-time    { font-size:11px; color:var(--text3); white-space:nowrap; }
.recent-redial-btn { background:var(--blue-bg); color:var(--blue); border:none; border-radius:6px; width:26px; height:26px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px; }
.recent-redial-btn:hover { background:var(--blue); color:#fff; }
.icon-in   { color:var(--green); }
.icon-out  { color:var(--blue); }
.icon-miss { color:var(--red); }

/* ── Stats row ── */
.stats-row {
  display:grid; grid-template-columns:repeat(3,1fr);
  background:var(--surface); border-top:.5px solid var(--border); flex-shrink:0;
}
.stat-cell { padding:9px 0; text-align:center; }
.stat-cell + .stat-cell { border-left:.5px solid var(--border); }
.stat-label { font-size:10px; color:var(--text2); margin-bottom:2px; }
.stat-num   { font-size:17px; font-weight:600; color:var(--text); }

/* ═════════════════════════════════════════════════════════
   LIVE CALL SCREEN
═════════════════════════════════════════════════════════ */
.contact-row {
  padding:12px 16px 10px; background:var(--surface);
  border-bottom:.5px solid var(--border); flex-shrink:0;
}
.contact-header { display:flex; align-items:center; gap:10px; }
.contact-name-row { display:flex; align-items:center; justify-content:space-between; gap:8px; }
.contact-name { font-size:15px; font-weight:600; color:var(--text); }
.contact-sub  { font-size:11px; color:var(--text2); margin-top:2px; }
.case-id-link { font-size:11px; font-weight:600; color:#2563eb; background:rgba(37,99,235,.1); border-radius:4px; padding:2px 7px; white-space:nowrap; text-decoration:none; flex-shrink:0; }
.case-id-link:hover { background:rgba(37,99,235,.2); color:#1d4ed8; }

.meta-grid { display:grid; grid-template-columns:1fr 1fr; border-top:.5px solid var(--border); flex-shrink:0; }
.meta-cell { padding:8px 16px; background:var(--surface); }
.meta-cell + .meta-cell { border-left:.5px solid var(--border); }
.meta-label { font-size:10px; color:var(--text3); text-transform:uppercase; letter-spacing:.06em; margin-bottom:2px; }
.meta-value { font-size:12px; font-weight:500; color:var(--text); }

.live-keypad {
  display:grid; grid-template-columns:repeat(3,1fr);
  gap:1px; background:var(--border); flex-shrink:0;
}
.lk { background:var(--surface); padding:12px 0; text-align:center; cursor:pointer; user-select:none; transition:background .1s; }
.lk:hover  { background:var(--blue-bg); }
.lk:active { background:var(--blue-bg); }

.call-info-bar {
  display:flex; align-items:center; justify-content:space-between;
  padding:8px 16px; background:var(--surface2);
  border-top:.5px solid var(--border); border-bottom:.5px solid var(--border); flex-shrink:0;
}
.cib-txt      { font-size:11px; color:var(--text2); }
.live-ind     { display:flex; align-items:center; gap:5px; }
.pulse-dot    { width:7px; height:7px; border-radius:50%; background:#22c55e; animation:pdPulse 1.5s ease-in-out infinite; }
@keyframes pdPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.85)} }
.live-txt     { font-size:11px; font-weight:600; color:#15803d; }
.call-dur     { font-family:var(--mono); font-size:13px; font-weight:600; color:var(--text); }

.action-row {
  display:grid; grid-template-columns:1fr 1fr 1fr;
  gap:8px; padding:10px 16px;
  background:var(--surface); border-top:.5px solid var(--border); flex-shrink:0;
}
.btn-action {
  border-radius:var(--radius); padding:10px 0;
  font-family:var(--font); font-size:12px; font-weight:600;
  cursor:pointer; display:flex; align-items:center; justify-content:center; gap:5px;
  transition:all .15s;
}
.btn-neutral { background:var(--surface2); border:.5px solid var(--border-md); color:var(--text); }
.btn-neutral:hover { background:#ececea; }
.btn-neutral.active-state { background:var(--amber-bg); color:var(--amber-text); border-color:#fcd34d; }
.btn-mute-active { background:var(--red-bg); color:var(--red); border:.5px solid #fca5a5; }
.btn-end { background:linear-gradient(135deg,#ef4444,#dc2626); border:none; color:#fff; box-shadow:0 3px 10px rgba(220,38,38,.3); }
.btn-end:hover { opacity:.9; }

/* Secondary actions (transfer / 3-way) */
.secondary-actions {
  display:grid; grid-template-columns:1fr 1fr;
  gap:7px; padding:0 16px 10px;
  background:var(--surface); flex-shrink:0;
}
.sec-btn {
  display:flex; align-items:center; justify-content:center; gap:5px;
  padding:7px 0; border-radius:var(--radius);
  border:.5px solid var(--border-md); background:var(--surface2);
  color:var(--text2); font-family:var(--font); font-size:11px; font-weight:500; cursor:pointer;
  transition:all .15s;
}
.sec-btn:hover  { background:var(--blue-bg); color:var(--blue-text); border-color:#a5b4fc; }
.sec-btn.active { background:var(--blue-bg); color:var(--blue-text); border-color:#a5b4fc; }
.sec-btn i { font-size:13px; }

.sec-panel {
  display:none; background:var(--surface2);
  border-top:.5px solid var(--border); border-bottom:.5px solid var(--border);
  padding:10px 16px; flex-shrink:0;
}
.sec-panel-title {
  font-size:10px; font-weight:700; letter-spacing:.07em; text-transform:uppercase;
  color:var(--text3); margin-bottom:8px; display:flex; align-items:center; gap:5px;
}
.p-input {
  width:100%; background:var(--surface); border:.5px solid var(--border-md);
  border-radius:var(--radius); padding:7px 11px; font-size:12px; color:var(--text);
  outline:none; margin-bottom:8px; font-family:var(--font);
}
.p-input:focus { border-color:var(--blue); }
.p-row { display:flex; gap:6px; }
.p-btn {
  flex:1; padding:8px; border-radius:var(--radius); border:none;
  font-size:11px; font-weight:600; cursor:pointer; font-family:var(--font);
  display:flex; align-items:center; justify-content:center; gap:4px;
  color:#fff; transition:opacity .15s;
}
.p-btn:hover { opacity:.9; }
.p-btn:disabled { opacity:.4; cursor:not-allowed; }
.p-btn-indigo { background:var(--blue-grad); }
.p-btn-amber  { background:linear-gradient(135deg,#f59e0b,#d97706); }
.p-btn-full   { width:100%; }

/* ═════════════════════════════════════════════════════════
   WRAP-UP SCREEN
═════════════════════════════════════════════════════════ */
.call-summary {
  padding:12px 16px; background:var(--surface2);
  border-bottom:.5px solid var(--border); flex-shrink:0;
}
.summary-header { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
.chips { display:flex; gap:5px; flex-wrap:wrap; }
.chip {
  display:inline-flex; align-items:center;
  padding:3px 10px; border-radius:var(--radius-pill);
  font-size:11px; font-weight:500;
}

.timer-band {
  display:flex; align-items:center; justify-content:space-between;
  padding:9px 16px; background:var(--surface);
  border-bottom:.5px solid var(--border); flex-shrink:0;
}
.timer-left { display:flex; align-items:center; gap:8px; }
.timer-lbl  { font-size:10px; color:var(--text2); margin-bottom:2px; }
.timer-val  { font-size:19px; font-weight:600; font-family:var(--mono); color:var(--amber); }
.timer-val.urgent { color:var(--red); }
.extend-btn {
  padding:5px 11px; border-radius:var(--radius);
  border:.5px solid var(--border-md); background:var(--surface2);
  font-family:var(--font); font-size:11px; font-weight:500;
  color:var(--text2); cursor:pointer;
}
.extend-btn:hover { background:#ececea; }

.progress-wrap {
  padding:8px 16px 10px; background:var(--surface);
  border-bottom:.5px solid var(--border); flex-shrink:0;
}
.progress-meta  { display:flex; justify-content:space-between; font-size:11px; color:var(--text2); margin-bottom:5px; }
.progress-track { height:4px; border-radius:999px; background:var(--surface2); overflow:hidden; border:.5px solid var(--border); }
.progress-fill  { height:100%; border-radius:999px; background:var(--blue-grad); transition:width .4s; }

.form-section { padding:12px 16px; border-bottom:.5px solid var(--border); flex-shrink:0; }
.field-block  { margin-bottom:12px; }
.field-label  { font-size:11px; color:var(--text2); text-transform:uppercase; letter-spacing:.05em; margin-bottom:6px; }
.disp-grid    { display:grid; grid-template-columns:1fr 1fr; gap:6px; }
.disp-btn {
  padding:9px 0; border-radius:var(--radius);
  border:.5px solid var(--border-md); background:var(--surface);
  color:var(--text2); font-family:var(--font); font-size:12px; font-weight:500;
  cursor:pointer; text-align:center; transition:all .15s;
}
.disp-btn:hover { background:var(--surface2); }
.disp-btn.sel   { background:var(--blue-bg); color:var(--blue-text); border-color:#a5b4fc; }
.select-field {
  width:100%; padding:8px 11px; border-radius:var(--radius);
  border:.5px solid var(--border-md); background:var(--surface);
  color:var(--text); font-size:12px; font-family:var(--font); outline:none;
}
.select-field:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(99,102,241,.1); }
.notes-field {
  width:100%; padding:9px 12px; border-radius:var(--radius);
  border:.5px solid var(--border-md); background:var(--surface);
  color:var(--text); font-size:12px; font-family:var(--font);
  resize:none; outline:none; line-height:1.5;
}
.notes-field:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(99,102,241,.1); }
.char-count { font-size:10px; color:var(--text3); text-align:right; margin-top:3px; }

.followup-section { padding:12px 16px; border-bottom:.5px solid var(--border); flex-shrink:0; }
.followup-row     { display:flex; align-items:center; justify-content:space-between; }
.followup-main    { font-size:13px; font-weight:600; color:var(--text); }
.followup-sub     { font-size:11px; color:var(--text2); margin-top:2px; }
.toggle {
  width:36px; height:20px; border-radius:999px;
  background:var(--surface2); border:.5px solid var(--border-md);
  cursor:pointer; position:relative; transition:background .2s; flex-shrink:0;
}
.toggle.on { background:var(--blue-grad); border-color:var(--blue); }
.toggle-knob {
  width:14px; height:14px; border-radius:50%; background:#fff;
  position:absolute; top:2px; left:3px; transition:left .2s;
  box-shadow:0 1px 3px rgba(0,0,0,.2);
}
.toggle.on .toggle-knob { left:19px; }
.followup-options { display:none; margin-top:10px; }
.cb-row { display:flex; align-items:center; gap:8px; margin-top:7px; }
.cb-row input[type=checkbox] { width:14px; height:14px; accent-color:var(--blue); cursor:pointer; }
.cb-label { font-size:12px; color:var(--text2); cursor:pointer; }

.submit-row { display:grid; grid-template-columns:1fr 1fr; gap:8px; padding:12px 16px; flex-shrink:0; }
.btn-skip {
  padding:12px 0; border-radius:var(--radius-lg);
  border:.5px solid var(--border-md); background:var(--surface2);
  color:var(--text2); font-family:var(--font); font-size:13px; font-weight:500; cursor:pointer;
}
.btn-skip:hover { background:#ececea; }
.btn-submit {
  padding:12px 0; border-radius:var(--radius-lg); border:none;
  background:var(--blue-grad); color:#fff;
  font-family:var(--font); font-size:13px; font-weight:600; cursor:pointer;
  box-shadow:0 4px 14px rgba(99,102,241,.3); transition:opacity .15s;
}
.btn-submit:hover { opacity:.9; }
.btn-submit:disabled { opacity:.4; cursor:not-allowed; }

/* ─── Inbound queue banner ───────────────────────────── */
#inboundQueueBanner {
  display: none;
  align-items: center; gap: 10px;
  padding: 8px 14px;
  background: linear-gradient(135deg, rgba(34,197,94,.12), rgba(5,150,105,.10));
  border-bottom: 1px solid rgba(34,197,94,.3);
  flex-shrink: 0; animation: slideDown .22s ease;
}
.iq-pulse {
  width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
  background: var(--green-bg);
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; color: var(--green);
  animation: incRing 1.1s ease-in-out infinite;
}
.iq-label { font-size: 10px; color: var(--text3); text-transform: uppercase; letter-spacing: .06em; }
.iq-phone { font-size: 13px; font-weight: 600; color: var(--text); margin-top: 1px; }
.iq-count { font-size: 11px; color: var(--text2); }
.iq-answer-btn {
  margin-left: auto; flex-shrink: 0;
  padding: 6px 14px; border: none; border-radius: var(--radius);
  background: linear-gradient(135deg,#22c55e,#16a34a); color: #fff;
  font-family: var(--font); font-size: 12px; font-weight: 600;
  cursor: pointer; display: flex; align-items: center; gap: 5px;
  box-shadow: 0 2px 8px rgba(34,197,94,.3); transition: opacity .15s;
}
.iq-answer-btn:hover  { opacity: .9; }
.iq-answer-btn:disabled { opacity: .4; cursor: not-allowed; }

/* ─── VoIP offline banner ─────────────────────────────── */
.voip-banner {
  background:var(--amber-bg); border:.5px solid #fcd34d;
  border-radius:var(--radius); padding:10px 12px;
  font-size:11px; color:var(--amber-text); line-height:1.5;
  display:flex; align-items:flex-start; gap:8px; margin:12px 16px; flex-shrink:0;
}
.voip-banner i { font-size:15px; flex-shrink:0; margin-top:1px; }

/* ─── Toast ──────────────────────────────────────────── */
#sp-toast {
  position:fixed; bottom:16px; left:50%; transform:translateX(-50%);
  background:rgba(20,20,20,.92); color:#fff;
  font-size:12px; font-weight:500; padding:8px 18px;
  border-radius:99px; display:none; z-index:999; white-space:nowrap;
  box-shadow:0 4px 16px rgba(0,0,0,.2);
}
</style>
</head>
<body>

<!-- ── Incoming call overlay ─────────────────────────────── -->
<div id="incomingOverlay">
    <div class="inc-row">
        <div class="inc-av" id="incAvatar">?</div>
        <div style="flex:1;min-width:0;">
            <div class="inc-lbl">Incoming Call</div>
            <div class="inc-from" id="incomingFrom">Unknown</div>
            <div class="inc-name" id="incomingName" style="display:none;"></div>
            <div class="inc-meta">
                <span class="inc-group" id="incomingGroup" style="display:none;"></span>
                <span class="inc-case"  id="incomingCase"  style="display:none;"></span>
            </div>
        </div>
    </div>
    <div class="inc-btns">
        <button class="btn btn-success" id="answerBtn"><i class="ti ti-phone"></i> Answer</button>
        <button class="btn btn-danger"  id="rejectBtn"><i class="ti ti-phone-off"></i> Reject</button>
    </div>
</div>

<!-- ── Top bar ───────────────────────────────────────────── -->
<div class="top-bar">
    <div class="brand">
        <div class="brand-logo"><i class="ti ti-headset"></i></div>
        <div>
            <div class="brand-name">Power Dialer</div>
            <div class="brand-sub">NCMS · Agent Console</div>
        </div>
    </div>
    <div id="statusPill" class="status-pill">
        <span class="s-dot sd-{{ $agentStatus->status }}" id="statusDot"></span>
        <span id="statusPillText">{{ ucfirst(str_replace('_',' ',$agentStatus->status)) }}</span>
    </div>
</div>

<!-- ── Controls strip ───────────────────────────────────── -->
<div class="ctrl-strip">
    <select id="agentStatusSelect" class="ctrl-select" style="max-width:140px;">
        <option value="available" {{ $agentStatus->status==='available' ? 'selected' : '' }}>🟢 Available</option>
        <option value="break"     {{ $agentStatus->status==='break'     ? 'selected' : '' }}>🩷 Break</option>
        <option value="offline"   {{ $agentStatus->status==='offline'   ? 'selected' : '' }}>⚫ Offline</option>
    </select>
    @if($agentGroups->count() > 0)
    <select id="agentGroupSelect" class="ctrl-select">
        <option value="">— Select group —</option>
        @foreach($agentGroups as $m)
        <option value="{{ $m->group->id }}" {{ $agentStatus->active_group_id == $m->group->id ? 'selected' : '' }}>
            {{ $m->group->name }}
        </option>
        @endforeach
    </select>
    @endif
    <span id="activeNumber" class="ctrl-num-badge {{ $agentStatus->active_group_id ? '' : 'empty' }}">
        @if($agentStatus->active_group_id)
            @php $ag = $agentGroups->first(fn($m) => $m->group->id == $agentStatus->active_group_id); @endphp
            @if($ag)<i class="ti ti-phone" style="font-size:9px;margin-right:2px;"></i>{{ $ag->group->twilio_number }}@endif
        @endif
    </span>
</div>

<!-- ── Body ─────────────────────────────────────────────── -->
<div class="sp-body">

<!-- ════════════════════════════════════════════════════
     IDLE SCREEN
════════════════════════════════════════════════════ -->
<div id="screen-idle" class="screen active">

    <div class="avail-bar">
        <span class="avail-label">Receiving calls</span>
        <div class="avail-options">
            <button class="avail-btn {{ $agentStatus->status==='available' ? 'sel' : '' }}" id="recvOn">On</button>
            <button class="avail-btn {{ $agentStatus->status!=='available' ? 'sel' : '' }}" id="recvOff">Off</button>
        </div>
    </div>

    <!-- Inbound queue banner (callers holding in conference) -->
    <div id="inboundQueueBanner" style="display:none;align-items:center;gap:10px;padding:8px 14px;background:linear-gradient(135deg,rgba(34,197,94,.12),rgba(5,150,105,.10));border-bottom:1px solid rgba(34,197,94,.3);flex-shrink:0;animation:slideDown .22s ease;">
        <div class="iq-pulse"><i class="ti ti-phone-incoming"></i></div>
        <div style="flex:1;min-width:0;">
            <div class="iq-label">Caller Holding</div>
            <div class="iq-phone" id="iqPhone">Unknown</div>
            <div class="iq-count" id="iqCount"></div>
        </div>
        <button class="iq-answer-btn" id="iqAnswerBtn">
            <i class="ti ti-phone"></i> Answer
        </button>
    </div>

    <!-- Queue -->
    <div class="queue-section">
        <div class="section-header">
            <span class="section-label">Next in queue</span>
            <span class="badge badge-blue" id="queueBadge" style="display:none;">Waiting</span>
        </div>
        <div id="queueEmpty" class="q-empty">
            <i class="ti ti-inbox"></i>Queue is empty
        </div>
        <div id="queueItem" class="queue-item" style="display:none;">
            <div class="avatar av-blue" id="queueAvatar">—</div>
            <div class="q-item-info">
                <div class="q-name"  id="queueName">—</div>
                <div class="q-meta" id="queuePhone">—</div>
            </div>
            <button class="queue-call-btn" id="acceptBtn"><i class="ti ti-phone"></i> Call Now</button>
            <button class="queue-skip-btn" id="skipBtn">Skip</button>
        </div>
    </div>

    <!-- Outbound dial -->
    <div class="dial-section">
        <div class="section-label" style="margin-bottom:8px;">New outbound call</div>
        <div class="dial-input-row">
            <input class="dial-input" id="dialDisplay" placeholder="Tap keys or type…" autocomplete="off">
            <button class="del-btn" id="clearBtn">
                <i class="ti ti-backspace" style="font-size:18px;"></i>
            </button>
        </div>
        <div class="keypad-grid" id="idleKeypad">
            <div class="key" data-key="1"><div class="key-num">1</div><div class="key-letters">&nbsp;</div></div>
            <div class="key" data-key="2"><div class="key-num">2</div><div class="key-letters">ABC</div></div>
            <div class="key" data-key="3"><div class="key-num">3</div><div class="key-letters">DEF</div></div>
            <div class="key" data-key="4"><div class="key-num">4</div><div class="key-letters">GHI</div></div>
            <div class="key" data-key="5"><div class="key-num">5</div><div class="key-letters">JKL</div></div>
            <div class="key" data-key="6"><div class="key-num">6</div><div class="key-letters">MNO</div></div>
            <div class="key" data-key="7"><div class="key-num">7</div><div class="key-letters">PQRS</div></div>
            <div class="key" data-key="8"><div class="key-num">8</div><div class="key-letters">TUV</div></div>
            <div class="key" data-key="9"><div class="key-num">9</div><div class="key-letters">WXYZ</div></div>
            <div class="key" data-key="*"><div class="key-num" style="font-size:24px;line-height:1;margin-top:-3px;">*</div><div class="key-letters">&nbsp;</div></div>
            <div class="key" data-key="0"><div class="key-num">0</div><div class="key-letters">+</div></div>
            <div class="key" data-key="#"><div class="key-num" style="font-size:17px;">#</div><div class="key-letters">&nbsp;</div></div>
        </div>
        <button class="idle-call-btn" id="manualCallBtn" disabled>
            <i class="ti ti-phone" style="font-size:16px;"></i> Call
        </button>
    </div>

    <!-- Recent calls (placeholder — wire up later) -->
    <div class="recent-section">
        <div class="section-label" style="margin-bottom:8px;">Recent calls</div>
        <div id="recentList">
            <div style="text-align:center;padding:18px 0;color:var(--text3);font-size:12px;">
                <i class="ti ti-clock" style="font-size:24px;display:block;margin-bottom:5px;opacity:.35;"></i>
                No recent calls
            </div>
        </div>
    </div>

    <div class="stats-row" style="margin-top:auto;">
        <div class="stat-cell"><div class="stat-label">Agents</div><div class="stat-num" id="statAgents">—</div></div>
        <div class="stat-cell"><div class="stat-label">Inbound</div><div class="stat-num" id="statInbound">—</div></div>
        <div class="stat-cell"><div class="stat-label">Outbound</div><div class="stat-num" id="statOutbound">—</div></div>
    </div>
</div><!-- /screen-idle -->


<!-- ════════════════════════════════════════════════════
     LIVE CALL SCREEN
════════════════════════════════════════════════════ -->
<div id="screen-live" class="screen">

    <div class="tab-bar">
        <div class="tab active"><i class="ti ti-phone"></i><span class="tab-lbl">Call</span></div>
        <div class="tab"><i class="ti ti-message"></i><span class="tab-lbl">Chat</span></div>
        <div class="tab"><i class="ti ti-clock"></i><span class="tab-lbl">History</span></div>
        <div class="tab"><i class="ti ti-mail"></i><span class="tab-lbl">Email</span></div>
        <div class="tab"><i class="ti ti-switch-horizontal"></i><span class="tab-lbl">Transfer</span></div>
    </div>

    <div class="contact-row">
        <div class="contact-header">
            <div class="avatar av-blue" id="liveAvatar">?</div>
            <div class="contact-name-row">
                <div class="contact-name" id="liveName">—</div>
                <a class="case-id-link" id="liveCaseLink" href="#" target="_blank" style="display:none;"></a>
            </div>
        </div>
    </div>

    <div class="meta-grid">
        <div class="meta-cell">
            <div class="meta-label">Case Type</div>
            <div class="meta-value" id="liveCaseType">—</div>
        </div>
        <div class="meta-cell">
            <div class="meta-label">Status</div>
            <div class="meta-value" id="liveCaseStatus"><span class="badge badge-gray" id="callStatusBadge">Connecting</span></div>
        </div>
    </div>

    <!-- Always-visible DTMF keypad -->
    <div class="live-keypad" id="liveKeypad">
        <div class="lk" data-key="1"><div class="key-num">1</div><div class="key-letters">&nbsp;</div></div>
        <div class="lk" data-key="2"><div class="key-num">2</div><div class="key-letters">ABC</div></div>
        <div class="lk" data-key="3"><div class="key-num">3</div><div class="key-letters">DEF</div></div>
        <div class="lk" data-key="4"><div class="key-num">4</div><div class="key-letters">GHI</div></div>
        <div class="lk" data-key="5"><div class="key-num">5</div><div class="key-letters">JKL</div></div>
        <div class="lk" data-key="6"><div class="key-num">6</div><div class="key-letters">MNO</div></div>
        <div class="lk" data-key="7"><div class="key-num">7</div><div class="key-letters">PQRS</div></div>
        <div class="lk" data-key="8"><div class="key-num">8</div><div class="key-letters">TUV</div></div>
        <div class="lk" data-key="9"><div class="key-num">9</div><div class="key-letters">WXYZ</div></div>
        <div class="lk" data-key="*"><div class="key-num" style="font-size:24px;line-height:1;margin-top:-3px;">*</div><div class="key-letters">&nbsp;</div></div>
        <div class="lk" data-key="0"><div class="key-num">0</div><div class="key-letters">+</div></div>
        <div class="lk" data-key="#"><div class="key-num" style="font-size:17px;">#</div><div class="key-letters">&nbsp;</div></div>
    </div>

    <div class="call-info-bar">
        <span class="cib-txt" id="liveNumber">—</span>
        <div class="live-ind"><span class="pulse-dot"></span><span class="live-txt">Live</span></div>
        <span class="call-dur" id="callTimer">00:00</span>
    </div>

    <div class="action-row">
        <button class="btn-action btn-neutral" id="holdBtn">
            <i class="ti ti-player-pause"></i> Hold
        </button>
        <button class="btn-action btn-neutral" id="muteBtn">
            <i class="ti ti-microphone"></i> Mute
        </button>
        <button class="btn-action btn-end" id="hangupBtn">
            <i class="ti ti-phone-off"></i> End
        </button>
    </div>

    <div class="secondary-actions">
        <button class="sec-btn" id="transferToggleBtn"><i class="ti ti-phone-forward"></i> Transfer</button>
        <button class="sec-btn" id="confToggleBtn"><i class="ti ti-user-plus"></i> Add Caller</button>
    </div>

    <!-- Transfer panel -->
    <div id="transferPanel" class="sec-panel">
        <div class="sec-panel-title"><i class="ti ti-phone-forward"></i> Transfer Call</div>
        <input type="tel" class="p-input" id="transferPhone" placeholder="+1 (555) 000-0000">
        <div class="p-row">
            <button class="p-btn p-btn-indigo" id="coldTransferBtn"><i class="ti ti-phone-off"></i> Cold</button>
            <button class="p-btn p-btn-amber"  id="warmTransferBtn"><i class="ti ti-phone-plus"></i> Warm</button>
        </div>
    </div>

    <!-- 3-Way panel -->
    <div id="confPanel" class="sec-panel">
        <div class="sec-panel-title"><i class="ti ti-users"></i> Add to Call</div>
        <input type="tel" class="p-input" id="confPhone" placeholder="+1 (555) 000-0000">
        <button class="p-btn p-btn-indigo p-btn-full" id="addConfBtn"><i class="ti ti-user-plus"></i> Dial In</button>
    </div>

    <div class="stats-row" style="margin-top:auto;">
        <div class="stat-cell"><div class="stat-label">Agents</div><div class="stat-num" id="liveStatAgents">—</div></div>
        <div class="stat-cell"><div class="stat-label">Inbound</div><div class="stat-num" id="liveStatInbound">—</div></div>
        <div class="stat-cell"><div class="stat-label">Outbound</div><div class="stat-num" id="liveStatOutbound">—</div></div>
    </div>
</div><!-- /screen-live -->


<!-- ════════════════════════════════════════════════════
     WRAP-UP SCREEN
════════════════════════════════════════════════════ -->
<div id="screen-wrapup" class="screen">

    <div class="call-summary">
        <div class="summary-header">
            <div class="avatar av-blue" id="wrapAvatar">?</div>
            <div class="contact-name-row">
                <div class="contact-name" id="wrapName">—</div>
                <a class="case-id-link" id="wrapCaseLink" href="#" target="_blank" style="display:none;"></a>
            </div>
            <div class="contact-sub" id="wrapSub">—</div>
        </div>
        <div class="chips" id="wrapChips"></div>
    </div>

    <div class="timer-band">
        <div class="timer-left">
            <i class="ti ti-clock" style="color:var(--amber);font-size:16px;flex-shrink:0;"></i>
            <div>
                <div class="timer-lbl">Wrap-up time remaining</div>
                <div class="timer-val" id="wrapTimer">01:30</div>
            </div>
        </div>
        <button class="extend-btn" id="wrapExtend">+ 1 min</button>
    </div>

    <div class="progress-wrap">
        <div class="progress-meta">
            <span>Form completion</span>
            <span id="wrapProgPct">0%</span>
        </div>
        <div class="progress-track">
            <div class="progress-fill" id="wrapProgFill" style="width:0%"></div>
        </div>
    </div>

    <div class="form-section">
        <!-- Hidden input read by save handler -->
        <input type="hidden" id="dispSelect">

        <div class="field-block">
            <div class="field-label">Call Outcome</div>
            <div class="disp-grid">
                <button class="disp-btn" data-val="contacted">Contacted</button>
                <button class="disp-btn" data-val="voicemail">Left Voicemail</button>
                <button class="disp-btn" data-val="no_answer">No Answer</button>
                <button class="disp-btn" data-val="callback_requested">Callback Needed</button>
                <button class="disp-btn" data-val="retained" style="grid-column:span 2;">Retained — Signed</button>
                <button class="disp-btn" data-val="not_interested">Not Interested</button>
                <button class="disp-btn" data-val="wrong_number">Wrong Number</button>
            </div>
        </div>

        <div class="field-block">
            <div class="field-label">Case Status Update</div>
            <select class="select-field" id="wrapCaseStatus">
                <option value="">No change</option>
                <option value="intake_under_review">Intake Under Review</option>
                <option value="pending_documents">Pending Documents</option>
                <option value="retainer_signed">Retainer Signed</option>
                <option value="referred_out">Referred Out</option>
                <option value="closed_no_case">Closed — No Case</option>
            </select>
        </div>

        <div class="field-block" style="margin-bottom:0;">
            <div class="field-label">Call Notes</div>
            <textarea class="notes-field" id="dispNotes" rows="3" placeholder="Summarize the call — key facts, next steps, concerns…"></textarea>
            <div class="char-count" id="wrapCharCount">0 / 500</div>
        </div>
    </div>

    <div class="followup-section">
        <div class="followup-row">
            <div>
                <div class="followup-main">Schedule follow-up</div>
                <div class="followup-sub">Add a callback task to this case</div>
            </div>
            <div class="toggle" id="followupToggle"><div class="toggle-knob"></div></div>
        </div>
        <div class="followup-options" id="followupOpts">
            <select class="select-field" id="followupWhen" style="margin-bottom:8px;">
                <option>Tomorrow morning</option>
                <option>In 2 days</option>
                <option>In 1 week</option>
            </select>
            <div class="cb-row">
                <input type="checkbox" id="cbAssign" checked>
                <label class="cb-label" for="cbAssign">Assign to me</label>
            </div>
            <div class="cb-row">
                <input type="checkbox" id="cbRemind">
                <label class="cb-label" for="cbRemind">Send reminder to client</label>
            </div>
        </div>
    </div>

    <div class="submit-row">
        <button class="btn-skip"   id="skipDispBtn">Skip wrap-up</button>
        <button class="btn-submit" id="saveDispBtn"><i class="ti ti-check"></i> Save &amp; Next</button>
    </div>

</div><!-- /screen-wrapup -->

</div><!-- /sp-body -->

<div id="sp-toast"></div>

<div style="position:fixed;bottom:14px;right:14px;z-index:9999;">
    <button id="btn-test-ring" style="background:#f59e0b;color:#fff;border:none;border-radius:8px;padding:7px 14px;font-size:12px;font-weight:600;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,.15);">🔔 Test Ring</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@twilio/voice-sdk@2.11.0/dist/twilio.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

/* ── State ───────────────────────────────────────────────── */
var device           = null;
var activeConnection = null;
var activeCallId     = null;
var activeConference = null;
var currentQueueId     = null;
var currentQueueCaseId = null;
var timerInterval    = null;
var callSeconds      = 0;
var statusSaving     = false;
var isMuted          = false;
var isOnHold         = false;
var callConnected    = false;
var pendingInbound   = null;
var inboundTimeout   = null;
var wrapInterval     = null;
var wrapSecsLeft     = 90;
var twilioReady      = false;

var currentContact    = { name: '—', phone: '—', initials: '?', caseType: '', caseStatus: '', duration: '—', caseId: null };
var currentInboundId  = null;
var caseBaseUrl    = '{{ config('dialer.contact_edit_url') ?: '' }}';
var dialerBaseUrl  = '{{ rtrim(url(config('dialer.route_prefix') ? config('dialer.route_prefix').'/dialer' : 'dialer'), '/') }}';
var wrapFields = { disp: false, notes: false };

/* ── Toast ───────────────────────────────────────────────── */
function toast(msg, ms) {
    ms = ms || 2500;
    $('#sp-toast').text(msg).fadeIn(180);
    setTimeout(function () { $('#sp-toast').fadeOut(300); }, ms);
}

/* ── Avatar initials ─────────────────────────────────────── */
function initial(str) {
    if (!str) return '?';
    var parts = String(str).trim().split(' ');
    if (parts.length >= 2) return (parts[0][0] + parts[parts.length-1][0]).toUpperCase();
    var c = parts[0].charAt(0).toUpperCase();
    return /[A-Z0-9]/.test(c) ? c : '#';
}

/* ── Status pill ─────────────────────────────────────────── */
var statusLabels = { offline:'Offline', available:'Available', on_call:'On Call', wrap_up:'Wrap Up', break:'Break' };

function setStatus(status) {
    var pill = $('#statusPill');
    var dotClass = 'sd-' + status;
    pill.removeClass('oncall wrapup offline');
    if (status === 'on_call')  pill.addClass('oncall');
    if (status === 'wrap_up')  pill.addClass('wrapup');
    if (status === 'offline')  pill.addClass('offline');
    $('#statusDot').attr('class', 's-dot ' + dotClass);
    $('#statusPillText').text(statusLabels[status] || status);
    // sync receiving-calls toggle
    if (status === 'available') {
        $('#recvOn').addClass('sel'); $('#recvOff').removeClass('sel');
    } else if (status !== 'on_call' && status !== 'wrap_up') {
        $('#recvOff').addClass('sel'); $('#recvOn').removeClass('sel');
    }
}

/* ── Call status badge ───────────────────────────────────── */
function setCallStatus(label) {
    $('#callStatusBadge').text(label);
}

/* ── Agent Status select ─────────────────────────────────── */
$('#agentStatusSelect').on('change', function () {
    var newStatus = $(this).val();
    statusSaving = true;
    setStatus(newStatus);
    $.post('{{ dialer_route('status') }}', { status: newStatus })
     .done(function () { statusSaving = false; })
     .fail(function (xhr) {
        statusSaving = false;
        var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'HTTP ' + xhr.status;
        toast('Status not saved: ' + msg, 4000);
     });
});

/* ── Receiving calls toggle ──────────────────────────────── */
$('#recvOn').on('click', function () {
    $('#agentStatusSelect').val('available').trigger('change');
});
$('#recvOff').on('click', function () {
    $('#agentStatusSelect').val('offline').trigger('change');
});

/* ── Agent Group ─────────────────────────────────────────── */
$('#agentGroupSelect').on('change', function () {
    var groupId = $(this).val();
    $.post('{{ dialer_route('group') }}', { group_id: groupId || '' })
     .done(function (res) {
        if (res.twilio_number) {
            $('#activeNumber').html('<i class="ti ti-phone" style="font-size:9px;margin-right:2px;"></i>' + res.twilio_number)
                              .removeClass('empty');
            toast('Dialing as ' + res.twilio_number);
        } else {
            $('#activeNumber').text('').addClass('empty');
            toast('No number on this group — using default');
        }
     });
});

/* ── Twilio Device ───────────────────────────────────────── */
var warmupCall = null; // track warmup so we can abort it if a real call arrives

function initTwilioDevice(token) {
    var TwilioDevice = (typeof Twilio !== 'undefined' && Twilio.Device) ? Twilio.Device : Device;

    if (device) {
        try { device.destroy(); } catch(e) {}
    }

    device = new TwilioDevice(token, {
        codecPreferences: ['opus', 'pcmu'],
        edge: ['ashburn', 'umatilla', 'dublin', 'roaming'],
        maxAverageBitrate: 16000,
        enableIceRestart: true,
        closeProtection: false,
        logLevel: 'error',
    });

    device.on('registered', function () {
        twilioReady = true;
        // Pre-warm ICE — abort immediately if a real call arrives
        setTimeout(function () {
            if (activeCallId || pendingInbound) return; // don't warmup if already on a call
            device.connect({ params: { Warmup: '1' } }).then(function (c) {
                warmupCall = c;
                setTimeout(function () {
                    warmupCall = null;
                    try { c.disconnect(); } catch(e) {}
                }, 1500);
            }).catch(function(){});
        }, 500);
    });

    // Token will expire in ~10 min — fetch a fresh one and update device
    device.on('tokenWillExpire', function () {
        $.get('{{ dialer_route('token') }}', function (data) {
            device.updateToken(data.token);
        });
    });

    // Device unregistered (WebSocket dropped, token expired, etc.) — re-register
    device.on('unregistered', function () {
        twilioReady = false;
        setTimeout(function () {
            $.get('{{ dialer_route('token') }}', function (data) {
                device.updateToken(data.token);
                device.register();
            });
        }, 3000); // wait 3s before retrying
    });

    device.on('error', function (e) {
        console.error('Twilio error:', e.message);
        // 31205 = token expired; 31204 = token invalid — reinitialise fully
        if (e.code === 31205 || e.code === 31204) {
            $.get('{{ dialer_route('token') }}?force=1', function (data) {
                initTwilioDevice(data.token);
            });
        } else {
            toast(e.message, 4000);
        }
    });

    device.on('incoming', function (call) {
        // Abort any warmup connection immediately so it doesn't block the real call
        if (warmupCall) {
            try { warmupCall.disconnect(); } catch(e) {}
            warmupCall = null;
        }

        if (activeCallId) { call.reject(); return; }
        pendingInbound = call;

        var from       = call.parameters.From || 'Unknown';
        var callerName = call.customParameters && call.customParameters.get('CallerName');
        var caseId     = call.customParameters && call.customParameters.get('CaseId');
        var groupName  = call.customParameters && call.customParameters.get('GroupName');

        $('#incomingFrom').text(from);
        $('#incAvatar').text(initial(callerName || from));

        if (callerName) {
            $('#incomingName').text(callerName).show();
        } else {
            $('#incomingName').hide();
        }
        if (groupName) {
            $('#incomingGroup').text(groupName).show();
        } else {
            $('#incomingGroup').hide();
        }
        if (caseId) {
            $('#incomingCase').text('#' + caseId).data('case-id', caseId).show();
        } else {
            $('#incomingCase').hide();
        }

        $('#incomingOverlay').show();
        inboundTimeout = setTimeout(function () {
            if (pendingInbound) { pendingInbound.reject(); pendingInbound = null; }
            $('#incomingOverlay').hide();
        }, 30000);
    });

    device.register();
}

$.get('{{ dialer_route('token') }}', function (data) {
    initTwilioDevice(data.token);
}).fail(function (xhr) {
    var msg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Could not load Twilio token';
    $('<div class="voip-banner"><i class="ti ti-alert-triangle"></i><span><b>VoIP Offline:</b> ' + msg + '<br>Queue management still works.</span></div>')
        .prependTo('.sp-body');
});

loadRecentCalls();

/* ── Queue status poller ─────────────────────────────────── */
function pollQueueStatus() {
    $.get('{{ dialer_route('queue.status') }}').done(function (data) {
        window.dispatchEvent(new CustomEvent('dialer:update', { detail: data }));
    });
}
pollQueueStatus();
setInterval(pollQueueStatus, 5000);

/* ── Queue / dialer update ───────────────────────────────── */
window.addEventListener('dialer:update', function (e) {
    var data = e.detail;
    if (!data) return;

    if (!statusSaving) setStatus(data.agent_status);

    if (data.stats) {
        var a = data.stats.agents   !== undefined ? data.stats.agents   : '—';
        var i = data.stats.inbound  !== undefined ? data.stats.inbound  : '—';
        var o = data.stats.outbound !== undefined ? data.stats.outbound : '—';
        $('#statAgents,#liveStatAgents').text(a);
        $('#statInbound,#liveStatInbound').text(i);
        $('#statOutbound,#liveStatOutbound').text(o);
    }

    if (data.next_call && !activeCallId) {
        currentQueueId     = data.next_call.queue_id;
        currentQueueCaseId = data.next_call.case_id || null;
        var name  = data.next_call.case_name || data.next_call.contact_name || '—';
        var phone = data.next_call.phone || '—';
        $('#queueAvatar').text(initial(name));
        $('#queueName').text(name);
        $('#queuePhone').text(phone + (data.next_call.notes ? ' · ' + data.next_call.notes : ''));
        $('#queueItem').show();
        $('#queueEmpty').hide();
        $('#queueBadge').show();
    } else if (!data.next_call) {
        currentQueueId = null;
        $('#queueItem').hide();
        $('#queueEmpty').show();
        $('#queueBadge').hide();
    }

    // Inbound hold queue banner
    var iq = data.next_inbound;
    if (iq && !activeCallId) {
        currentInboundId = iq.call_id;
        $('#iqPhone').text(iq.caller_name || iq.phone || 'Unknown');
        var cnt = (data.inbound_queued || 1);
        $('#iqCount').text(cnt > 1 ? (cnt - 1) + ' more caller(s) waiting' : 'Holding for agent');
        $('#inboundQueueBanner').css('display', 'flex');
    } else {
        currentInboundId = null;
        $('#inboundQueueBanner').hide();
    }
});

/* ── Accept queue call ───────────────────────────────────── */
$('#acceptBtn').on('click', function () {
    if (!currentQueueId) return;
    var $btn = $(this).prop('disabled', true).html('<i class="ti ti-loader-2"></i> Connecting…');
    $.post('{{ dialer_route('call') }}', { queue_id: currentQueueId })
     .done(function (res) {
        activeCallId     = res.call_id;
        activeConference = res.conference;
        var name = $('#queueName').text();
        showLiveScreen(res.phone, name, '', '', currentQueueCaseId);
        joinConference(res.conference, true);
     })
     .fail(function (xhr) {
        toast(xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Failed to initiate call');
        $btn.prop('disabled', false).html('<i class="ti ti-phone"></i> Call Now');
     });
});

$('#skipBtn').on('click', function () {
    currentQueueId = null;
    $('#queueItem').hide();
    $('#queueEmpty').show();
    $('#queueBadge').hide();
});

/* ── Pick up queued inbound caller ───────────────────── */
$('#iqAnswerBtn').on('click', function () {
    if (!currentInboundId) return;
    var $btn = $(this).prop('disabled', true).html('<i class="ti ti-loader-2"></i> Connecting…');
    var callId = currentInboundId;
    $.post('{{ dialer_route('inbound-pickup', ':id') }}'.replace(':id', callId))
     .done(function (res) {
        activeCallId     = res.call_id;
        activeConference = res.conference;
        currentInboundId = null;
        $('#inboundQueueBanner').hide();
        showLiveScreen(res.phone, res.caller_name || res.phone, res.case_type || 'Inbound', res.case_status || '', res.case_id || null);
        joinConference(res.conference, false);
     })
     .fail(function (xhr) {
        var msg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Could not pick up call';
        if (xhr.status === 409) {
            toast('Caller already picked up or hung up', 3000);
            currentInboundId = null;
            $('#inboundQueueBanner').hide();
        } else {
            toast(msg);
            $btn.prop('disabled', false).html('<i class="ti ti-phone"></i> Answer');
        }
     });
});

/* ── Answer inbound ──────────────────────────────────────── */
$('#incomingCase').on('click', function (e) {
    e.stopPropagation();
    var id = $(this).data('case-id');
    if (id) window.open(caseBaseUrl + '/' + id + '/edit', '_blank');
});

$('#answerBtn').on('click', function () {
    if (!pendingInbound) return;
    clearTimeout(inboundTimeout);
    var call = pendingInbound;
    pendingInbound = null;
    $('#incomingOverlay').hide();
    var from       = call.parameters.From || '';
    var sid        = call.parameters.CallSid || '';
    var callerName = (call.customParameters && call.customParameters.get('CallerName')) || from;
    var caseId     = call.customParameters && call.customParameters.get('CaseId');
    call.accept();
    activeConnection = call;
    callConnected    = false;
    showLiveScreen(from, callerName, 'Inbound', '', caseId ? parseInt(caseId) : null);
    wireCallEvents(call);
    $.post('{{ dialer_route('inbound-accept') }}', { from: from, twilio_call_sid: sid })
     .done(function (res) { activeCallId = res.call_id; });
});

$('#rejectBtn').on('click', function () {
    clearTimeout(inboundTimeout);
    if (pendingInbound) { pendingInbound.reject(); pendingInbound = null; }
    $('#incomingOverlay').hide();
});

/* ── Idle keypad ─────────────────────────────────────────── */
$('#idleKeypad').on('mousedown touchstart', '.key', function (e) {
    var key = $(this).data('key');
    // Tapping the '+' sub-label on the 0 key appends '+' (international prefix)
    if (key === '0' && $(e.target).hasClass('key-letters')) key = '+';
    var inp = document.getElementById('dialDisplay');
    inp.value += key;
    $('#manualCallBtn').prop('disabled', !inp.value.length);
    $(this).addClass('pressed');
    setTimeout(function () { $('#idleKeypad .pressed').removeClass('pressed'); }, 120);
});
$('#clearBtn').on('click', function () {
    var inp = document.getElementById('dialDisplay');
    inp.value = inp.value.slice(0, -1);
    $('#manualCallBtn').prop('disabled', !inp.value.length);
});
$('#dialDisplay').on('input', function () {
    $('#manualCallBtn').prop('disabled', !$(this).val().length);
});

/* ── Manual dial ─────────────────────────────────────────── */
$('#manualCallBtn').on('click', function () {
    var phone = $('#dialDisplay').val().trim();
    if (!phone) { toast('Enter a phone number first'); return; }
    var $btn = $(this).prop('disabled', true).html('<i class="ti ti-loader-2"></i> Connecting…');
    $.post('{{ dialer_route('manual-dial') }}', { phone: phone, dial_mode: 'human_agent' })
     .done(function (res) {
        activeCallId     = res.call_id;
        activeConference = res.conference;
        showLiveScreen(res.phone, res.contact_name || res.phone, res.case_type || '', res.case_status || '', res.case_id || null);
        joinConference(res.conference, true);
     })
     .fail(function (xhr) {
        toast(xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Failed to place call');
        $btn.prop('disabled', false).html('<i class="ti ti-phone" style="font-size:16px;"></i> Call');
     });
});

/* ── Join conference ─────────────────────────────────────── */
// dialAfterConnect: if true, POST dial-customer once agent WebRTC fires 'accept'
function joinConference(confName, dialAfterConnect) {
    if (!device || !twilioReady) {
        setCallStatus('VoIP offline');
        toast('Twilio not configured. Call logged but no audio.', 5000);
        return;
    }
    $('#holdBtn,#muteBtn').prop('disabled', true);
    setCallStatus('Connecting…');
    device.connect({ params: { Conference: confName } }).then(function (call) {
        activeConnection = call;
        wireCallEvents(call, dialAfterConnect);
    }).catch(function (e) {
        toast('Could not connect: ' + e.message, 4000);
        setCallStatus('Failed');
    });
}

/* ── Wire call events ────────────────────────────────────── */
function wireCallEvents(call, dialAfterConnect) {
    call.on('accept', function () {
        callConnected = true;
        $('#holdBtn,#muteBtn').prop('disabled', false);
        startTimer();

        if (dialAfterConnect && activeCallId) {
            // Agent is now live in conference — ring the customer
            setCallStatus('Ringing…');
            $.post('{{ dialer_route('dial-customer', ':id') }}'.replace(':id', activeCallId))
             .done(function ()  { setCallStatus('Connected'); })
             .fail(function ()  { setCallStatus('Connected'); }); // still connected even if dial fails
        } else {
            setCallStatus('Connected');
        }
    });
    call.on('disconnect', function () {
        activeConnection = null;
        stopTimer();
        resetCallControls();
        if (callConnected) { showWrapupScreen(); }
        else               { showIdleScreen(); }
        callConnected = false;
    });
    call.on('error', function (e) {
        console.error('Call error:', e.message);
        toast(e.message, 4000);
    });
}

/* ── Live DTMF keypad ────────────────────────────────────── */
$('#liveKeypad').on('mousedown touchstart', '.lk', function (e) {
    var digit = $(this).data('key');
    if (digit === '0' && $(e.target).hasClass('key-letters')) digit = '+';
    if (activeConnection) activeConnection.sendDigits(digit);
    $(this).addClass('pressed');
    setTimeout(function () { $('#liveKeypad .pressed').removeClass('pressed'); }, 120);
});

/* ── Show live screen ────────────────────────────────────── */
function showLiveScreen(phone, name, caseType, caseStatus, caseId) {
    currentContact.phone      = phone || '—';
    currentContact.name       = name  || phone || '—';
    currentContact.initials   = initial(currentContact.name);
    currentContact.caseType   = caseType   || '—';
    currentContact.caseStatus = caseStatus || '—';
    currentContact.caseId     = caseId     || null;

    $('#liveAvatar').text(currentContact.initials);
    $('#liveName').text(currentContact.name);
    if (currentContact.caseId) {
        $('#liveCaseLink').attr('href', caseBaseUrl + '/' + currentContact.caseId + '/edit').text('#' + currentContact.caseId).show();
    } else {
        $('#liveCaseLink').hide();
    }
    var activeNum = $('#activeNumber').text().trim();
    $('#liveNumber').text(activeNum || currentContact.phone);
    $('#liveCaseType').text(currentContact.caseType);
    $('#liveCaseStatus').html('<span class="badge badge-gray" id="callStatusBadge">Connecting</span>');

    $('#dialDisplay').val('');
    $('#manualCallBtn').prop('disabled', true).html('<i class="ti ti-phone" style="font-size:16px;"></i> Call');
    $('#inboundQueueBanner').hide();
    currentInboundId = null;

    isMuted = false; isOnHold = false;
    updateMuteBtn(); updateHoldBtn();

    switchScreen('live');
    setStatus('on_call');
}

/* ── Hang up ─────────────────────────────────────────────── */
$('#hangupBtn').on('click', function () {
    // Explicitly terminate the customer's Twilio call leg first,
    // then disconnect the agent's WebRTC leg. This ensures the customer
    // is always hung up even if the WebRTC BYE signal is lost.
    if (activeCallId) {
        $.post('{{ dialer_route('hangup-call', ':id') }}'.replace(':id', activeCallId))
         .always(function () {
             if (activeConnection) { activeConnection.disconnect(); }
             else { stopTimer(); showWrapupScreen(); resetCallControls(); }
         });
    } else {
        if (activeConnection) { activeConnection.disconnect(); }
        else { stopTimer(); showWrapupScreen(); resetCallControls(); }
    }
});

/* ── Wrap-up screen ──────────────────────────────────────── */
function showWrapupScreen() {
    var m = String(Math.floor(callSeconds / 60)).padStart(2, '0');
    var s = String(callSeconds % 60).padStart(2, '0');
    currentContact.duration = m + ':' + s;

    $('#wrapAvatar').text(currentContact.initials);
    $('#wrapName').text(currentContact.name);
    if (currentContact.caseId) {
        $('#wrapCaseLink').attr('href', caseBaseUrl + '/' + currentContact.caseId + '/edit').text('#' + currentContact.caseId).show();
    } else {
        $('#wrapCaseLink').hide();
    }
    $('#wrapSub').text(currentContact.phone + ' · ' + currentContact.duration);

    var chips = '';
    if (currentContact.caseType && currentContact.caseType !== '—') chips += '<span class="chip badge-blue">' + currentContact.caseType + '</span>';
    chips += '<span class="chip badge-gray">Outbound</span>';
    $('#wrapChips').html(chips);

    wrapFields = { disp: false, notes: false };
    updateWrapProgress();
    $('.disp-btn').removeClass('sel');
    $('#dispSelect').val('');
    $('#wrapCaseStatus').val('');
    $('#dispNotes').val('');
    $('#wrapCharCount').text('0 / 500');
    $('#followupToggle').removeClass('on');
    $('#followupOpts').hide();

    startWrapTimer();
    switchScreen('wrapup');
    setStatus('wrap_up');
}

/* ── Idle screen ─────────────────────────────────────────── */
function showIdleScreen() {
    stopWrapTimer();
    clearTimeout(inboundTimeout);
    pendingInbound = null;
    activeCallId = null; activeConference = null;
    currentContact.caseId = null;
    $('#liveCaseLink,#wrapCaseLink').hide();
    $('#incomingOverlay').hide();
    switchScreen('idle');
    setStatus('available');
    $('#agentStatusSelect').val('available');
    // Always sync status to backend
    $.post('{{ dialer_route('status') }}', { status: 'available' });
    loadRecentCalls();
}

/* ── Recent calls ─────────────────────────────────────────── */
function loadRecentCalls() {
    $.get('{{ dialer_route('recent-calls') }}').done(function (calls) {
        var $list = $('#recentList');
        if (!calls.length) {
            $list.html('<div style="text-align:center;padding:18px 0;color:var(--text3);font-size:12px;"><i class="ti ti-clock" style="font-size:24px;display:block;margin-bottom:5px;opacity:.35;"></i>No recent calls</div>');
            return;
        }
        var statusLabels = { initiated:'Initiated', 'in-progress':'In Progress', completed:'Completed', busy:'Busy', 'no-answer':'No Answer', failed:'Failed', canceled:'Canceled' };
        var html = '';
        calls.forEach(function (c) {
            var iconClass = c.direction === 'inbound' ? 'icon-in ti-phone-incoming' : 'icon-out ti-phone-outgoing';
            if (c.status === 'no-answer' || c.status === 'busy' || c.status === 'failed') iconClass = 'icon-miss ti-phone-x';
            var statusText = c.status ? (statusLabels[c.status] || c.status) : '—';
            var caseAttr = c.case_id ? ' data-case-id="' + c.case_id + '"' : '';
            html += '<div class="recent-item" data-phone="' + c.phone + '"' + caseAttr + '>'
                  + '<i class="ti ' + iconClass + '" style="font-size:18px;flex-shrink:0;"></i>'
                  + '<div class="recent-info">'
                  + '<div class="recent-name">' + $('<span>').text(c.name).html() + '</div>'
                  + '<div class="recent-meta">'
                  + '<span class="recent-num">' + statusText + '</span>'
                  + (c.case_id ? '<span class="recent-caseid">#' + c.case_id + '</span>' : '')
                  + '</div>'
                  + '</div>'
                  + '<div class="recent-actions">'
                  + '<div class="recent-time">' + (c.ended_at || '') + '</div>'
                  + '<button class="recent-redial-btn" data-phone="' + c.phone + '" title="Redial"><i class="ti ti-phone"></i></button>'
                  + '</div>'
                  + '</div>';
        });
        $list.html(html);
    });
}

$(document).on('click', '.recent-item', function (e) {
    if ($(e.target).closest('.recent-redial-btn').length) return;
    var caseId = $(this).data('case-id');
    if (caseId) window.open(caseBaseUrl + '/' + caseId + '/edit', '_blank');
});

$(document).on('click', '.recent-redial-btn', function (e) {
    e.stopPropagation();
    var phone = $(this).data('phone');
    if (!phone) return;
    $('#dialDisplay').val(phone);
    $('#manualCallBtn').trigger('click');
});

/* ── Screen switcher ─────────────────────────────────────── */
function switchScreen(name) {
    $('.screen').removeClass('active');
    $('#screen-' + name).addClass('active');
}

/* ── Wrap-up timer ───────────────────────────────────────── */
function startWrapTimer() {
    wrapSecsLeft = 90;
    updateWrapTimerDisplay();
    wrapInterval = setInterval(function () {
        if (wrapSecsLeft > 0) { wrapSecsLeft--; updateWrapTimerDisplay(); }
    }, 1000);
}
function stopWrapTimer() { clearInterval(wrapInterval); }
function updateWrapTimerDisplay() {
    var total = Math.max(wrapSecsLeft, 0);
    var mm = String(Math.floor(total / 60)).padStart(2, '0');
    var ss = String(total % 60).padStart(2, '0');
    var $el = $('#wrapTimer');
    $el.text(mm + ':' + ss);
    $el.toggleClass('urgent', total <= 30);
}
$('#wrapExtend').on('click', function () { wrapSecsLeft += 60; updateWrapTimerDisplay(); });

/* ── Wrap-up progress ────────────────────────────────────── */
function updateWrapProgress() {
    var n   = Object.values(wrapFields).filter(Boolean).length;
    var pct = Math.round((n / Object.keys(wrapFields).length) * 100);
    $('#wrapProgFill').css('width', pct + '%');
    $('#wrapProgPct').text(pct + '%');
}

/* ── Disposition buttons ─────────────────────────────────── */
$(document).on('click', '.disp-btn', function () {
    $('.disp-btn').removeClass('sel');
    $(this).addClass('sel');
    $('#dispSelect').val($(this).data('val'));
    wrapFields.disp = true;
    updateWrapProgress();
});

/* ── Notes char count ────────────────────────────────────── */
$('#dispNotes').on('input', function () {
    var len = Math.min($(this).val().length, 500);
    if ($(this).val().length > 500) $(this).val($(this).val().slice(0, 500));
    $('#wrapCharCount').text(len + ' / 500');
    wrapFields.notes = len > 5;
    updateWrapProgress();
});

/* ── Follow-up toggle ────────────────────────────────────── */
$('#followupToggle').on('click', function () {
    $(this).toggleClass('on');
    $('#followupOpts').toggle($(this).hasClass('on'));
});

/* ── Save disposition ────────────────────────────────────── */
$('#saveDispBtn').on('click', function () {
    var disp = $('#dispSelect').val();
    if (!disp) { toast('Please select a call outcome'); return; }
    var $btn = $(this).prop('disabled', true).html('<i class="ti ti-loader-2"></i> Saving…');
    var notes = $('#dispNotes').val();
    if ($('#followupToggle').hasClass('on')) {
        var when = $('#followupWhen').val();
        notes = notes ? notes + '\n[Follow-up: ' + when + ']' : '[Follow-up: ' + when + ']';
    }
    $.post(dialerBaseUrl + '/disposition/' + activeCallId, {
        disposition:  disp,
        notes:        notes,
        case_status:  $('#wrapCaseStatus').val(),
    }).done(function () {
        stopWrapTimer();
        showIdleScreen();
    }).always(function () {
        $btn.prop('disabled', false).html('<i class="ti ti-check"></i> Save &amp; Next');
    });
});

$('#skipDispBtn').on('click', function () {
    showIdleScreen();
});

/* ── Call timer ──────────────────────────────────────────── */
function startTimer() {
    callSeconds = 0;
    timerInterval = setInterval(function () {
        callSeconds++;
        var m = String(Math.floor(callSeconds / 60)).padStart(2, '0');
        var s = String(callSeconds % 60).padStart(2, '0');
        $('#callTimer').text(m + ':' + s);
    }, 1000);
}
function stopTimer() { clearInterval(timerInterval); $('#callTimer').text('00:00'); }

/* ── Hold ────────────────────────────────────────────────── */
$('#holdBtn').on('click', function () {
    if (!activeCallId) return;
    var action = isOnHold ? 'resume' : 'hold';
    $(this).prop('disabled', true);
    $.post(dialerBaseUrl + '/hold/' + activeCallId, { action: action })
     .done(function (res) {
        isOnHold = res.held;
        updateHoldBtn();
        toast(isOnHold ? 'Customer on hold' : 'Call resumed');
     })
     .fail(function () { toast('Hold action failed'); })
     .always(function () { $('#holdBtn').prop('disabled', false); });
});
function updateHoldBtn() {
    var $b = $('#holdBtn');
    if (isOnHold) {
        $b.addClass('active-state').html('<i class="ti ti-player-play"></i> Resume');
    } else {
        $b.removeClass('active-state').html('<i class="ti ti-player-pause"></i> Hold');
    }
}

/* ── Mute ────────────────────────────────────────────────── */
$('#muteBtn').on('click', function () {
    if (!activeConnection) return;
    isMuted = !isMuted;
    activeConnection.mute(isMuted);
    updateMuteBtn();
    toast(isMuted ? 'Muted' : 'Unmuted');
});
function updateMuteBtn() {
    var $b = $('#muteBtn');
    if (isMuted) {
        $b.addClass('btn-mute-active').removeClass('btn-neutral').html('<i class="ti ti-microphone-off"></i> Unmute');
    } else {
        $b.removeClass('btn-mute-active').addClass('btn-neutral').html('<i class="ti ti-microphone"></i> Mute');
    }
}

/* ── Reset call controls ─────────────────────────────────── */
function resetCallControls() {
    isMuted = false; isOnHold = false;
    updateMuteBtn(); updateHoldBtn();
    $('#holdBtn,#muteBtn').prop('disabled', false);
    $('#transferPanel,#confPanel').hide();
    $('#transferToggleBtn,#confToggleBtn').removeClass('active');
}

/* ── Transfer ────────────────────────────────────────────── */
$('#transferToggleBtn').on('click', function () {
    var open = $('#transferPanel').is(':visible');
    $('#transferPanel,#confPanel').hide();
    $('#transferToggleBtn,#confToggleBtn').removeClass('active');
    if (!open) { $('#transferPanel').show(); $(this).addClass('active'); $('#transferPhone').val('').focus(); }
});
$('#coldTransferBtn').on('click', function () {
    var phone = $('#transferPhone').val().replace(/[^0-9+]/g, '');
    if (!phone) { toast('Enter a phone number first'); return; }
    if (!confirm('Cold transfer to ' + phone + '? You will be disconnected.')) return;
    var $b = $(this).prop('disabled', true).html('<i class="ti ti-loader-2"></i>…');
    $.post(dialerBaseUrl + '/transfer/' + activeCallId, { phone: phone, type: 'cold' })
     .done(function () { toast('Transferred to ' + phone); if (activeConnection) activeConnection.disconnect(); })
     .fail(function () { toast('Transfer failed'); })
     .always(function () { $b.prop('disabled', false).html('<i class="ti ti-phone-off"></i> Cold'); });
});
$('#warmTransferBtn').on('click', function () {
    var phone = $('#transferPhone').val().replace(/[^0-9+]/g, '');
    if (!phone) { toast('Enter a phone number first'); return; }
    var $b = $(this).prop('disabled', true).html('<i class="ti ti-loader-2"></i>…');
    $.post(dialerBaseUrl + '/transfer/' + activeCallId, { phone: phone, type: 'warm' })
     .done(function () { toast('Warm transfer — announce then drop when ready'); $('#transferPanel').hide(); $('#transferToggleBtn').removeClass('active'); })
     .fail(function () { toast('Transfer failed'); })
     .always(function () { $b.prop('disabled', false).html('<i class="ti ti-phone-plus"></i> Warm'); });
});

/* ── 3-Way ───────────────────────────────────────────────── */
$('#confToggleBtn').on('click', function () {
    var open = $('#confPanel').is(':visible');
    $('#transferPanel,#confPanel').hide();
    $('#transferToggleBtn,#confToggleBtn').removeClass('active');
    if (!open) { $('#confPanel').show(); $(this).addClass('active'); $('#confPhone').val('').focus(); }
});
$('#addConfBtn').on('click', function () {
    var phone = $('#confPhone').val().replace(/[^0-9+]/g, '');
    if (!phone) { toast('Enter a phone number first'); return; }
    var $b = $(this).prop('disabled', true).html('<i class="ti ti-loader-2"></i> Dialing…');
    $.post(dialerBaseUrl + '/conference/' + activeCallId + '/add', { phone: phone })
     .done(function () { toast('Dialing ' + phone + ' into call…'); $('#confPhone').val(''); })
     .fail(function () { toast('Failed to add participant'); })
     .always(function () { $b.prop('disabled', false).html('<i class="ti ti-user-plus"></i> Dial In'); });
});

/* ── Notify parent on close ──────────────────────────────── */
window.addEventListener('beforeunload', function () {
    if (window.opener) window.opener.postMessage('softphone:closed', '*');
});

/* ── Listen for answer_inbound from parent window ────────── */
window.addEventListener('message', function (e) {
    if (!e.data || e.data.type !== 'dialer:answer_inbound') return;
    // Fetch latest inbound queued call and auto-accept
    $.getJSON(dialerBaseUrl + '/queue/status', function (d) {
        if (d.next_inbound && d.next_inbound.call_id) {
            $.post(dialerBaseUrl + '/inbound-pickup/' + d.next_inbound.call_id)
             .done(function (r) {
                 if (r.call_id) {
                     toast('Inbound call accepted — connecting…');
                     window.focus();
                 }
             })
             .fail(function () { toast('Could not accept inbound call'); });
        } else {
            toast('Softphone ready — waiting for call…');
            window.focus();
        }
    });
});

/* ── Test Ring ───────────────────────────────────────────── */
document.getElementById('btn-test-ring')?.addEventListener('click', function () {
    var btn = this;
    btn.disabled = true;
    btn.textContent = 'Ringing…';
    fetch(dialerBaseUrl + '/test-ring', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
        if (d.ok) toast('Test call sent — your browser should ring now!');
        else toast('Error: ' + (d.error || 'unknown'));
    })
    .catch(function () { toast('Failed to send test ring'); })
    .finally(function () { btn.disabled = false; btn.textContent = '🔔 Test Ring'; });
});
</script>
</body>
</html>
