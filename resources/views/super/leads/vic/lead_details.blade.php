@section('styles')
@parent
<style>
.rk-notes-list {
    height: 250px;
    overflow-y: auto;
}

/* ===== base stage ===== */
.rk-stage {
    cursor: pointer;
    transition: background .25s ease, color .25s ease;

}

/* ===== active stage premium ===== */


/* ✨ premium shine effect */
.rk-stage.active::before {
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 60%;
    height: 100%;
    background: linear-gradient(120deg,
            transparent,
            rgba(255, 255, 255, 0.45),
            transparent);
    animation: rkShine 2.5s infinite;
}

/* smooth shine animation */
@keyframes rkShine {
    0% {
        left: -120%;
    }

    100% {
        left: 130%;
    }
}

.rk-stage {
    cursor: pointer;
}

/* wrapper */
.rk-overview-wrapper {
    font-family: Inter, sans-serif;
    background: #f6f8fb;
    padding: 20px;
}

/* header */
.rk-overview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.rk-overview-title {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.rk-overview-customize {
    background: #eef2f7;
    border: 1px solid #d0d7e2;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

/* lifecycle */
.rk-lifecycle-box {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

/* ================= HUBSPOT PIPELINE ================= */

.rk-pipeline {
    display: flex;
    overflow-x: auto;
    background: #e9f5f2;
    padding: 8px;
    border-radius: 8px;
}

.rk-stage {
    position: relative;
    padding: 10px 28px 10px 22px;
    background: #bfe8df;
    color: #2d3748;
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
}

.rk-stage::after {
    content: "";
    position: absolute;
    top: 0;
    right: -18px;
    width: 0;
    height: 0;
    border-top: 19px solid transparent;
    border-bottom: 19px solid transparent;
    border-left: 18px solid #bfe8df;
    z-index: 2;
}

.rk-stage:not(:first-child) {
    margin-left: 18px;
}

.rk-stage.active {
    background: #2ec4b6;
    color: #fff;
    font-weight: 600;
}

.rk-stage.active::after {
    border-left-color: #2ec4b6;
}

.rk-stage:last-child::after {
    display: none;
}

/* body layout */
.rk-overview-body {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 15px;
}

.rk-column-stack {
    display: grid;
    gap: 15px;
    align-content: start;
}

/* summary */
.rk-summary-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
}

.rk-summary-header {
    background: #eaf0f7;
    padding: 12px 15px;
}

.rk-summary-content {
    padding: 15px;
}

.rk-summary-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 15px;
}

.rk-summary-row label {
    font-size: 12px;
    color: #6b7280;
}

.rk-summary-row p {
    margin: 3px 0 0;
    font-weight: 500;
}

.rk-link {
    color: #3b82f6;
    cursor: pointer;
}

/* notes */
.rk-notes-card {
    background: #fff;
    border-radius: 10px;
    padding: 15px;
}

.rk-note-input {
    width: 100%;
    height: 80px;
    border: 1px solid #e1e5eb;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 15px;
}

.rk-note-item {
    border-bottom: 1px solid #eef2f7;
    padding: 8px 0;
}

.rk-note-item span {
    font-size: 11px;
    color: #6b7280;
}

.rk-view-all {
    text-align: right;
    color: #3b82f6;
    font-size: 13px;
    cursor: pointer;
    margin-top: 10px;
}

/* mobile */
@media (max-width: 768px) {
    .rk-overview-body {
        grid-template-columns: 1fr;
    }

    .rk-summary-row {
        grid-template-columns: 1fr;
    }
}

/* ===== added action tabs (non-breaking) ===== */
.rk-action-tabs {
    display: flex;
    gap: 8px;
    margin: 10px 0 14px;
    flex-wrap: wrap;
}

.rk-action-tab {
    padding: 6px 14px;
    background: #fff;
    border: 1px solid #d0d7e2;
    border-radius: 20px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    transition: all .2s ease;
}

.rk-action-tab:hover {
    background: #f3f6fa;
}

.rk-action-tab.active {
    background: #2ec4b6;
    color: #fff;
    border-color: #2ec4b6;
    font-weight: 600;
}

.rk-note-empty {
    text-align: center;
    padding: 20px 10px;
    color: #6b7280;
    font-size: 13px;
}

/* card */
.rk-files-card {
    margin-top: 16px;
    padding: 14px;
    border: 1px solid #e6eceb;
    border-radius: 10px;
    background: #fff;
}

.rk-column-stack > .rk-files-card {
    margin-top: 0;
}

.rk-attachments-card {
    margin-top: 0;
}

/* list */
.rk-attach-list {
    list-style: none;
    padding-left: 0;
    margin: 0;
    max-height: 220px;
    overflow-y: auto;
}

/* item */
.rk-attach-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    border-bottom: 1px dashed #eee;
    font-size: 13px;
}

/* link */
.rk-attach-link {
    text-decoration: none;
    color: #2c3e50;
}

.rk-attach-link:hover {
    text-decoration: underline;
}

/* empty */
.rk-attach-empty {
    font-size: 12px;
    color: #999;
    padding: 8px 0;
}
.rk-files-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.rk-vic-modal {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
}

.rk-vic-modal-header {
    padding: 24px 28px 10px;
    border-bottom: 0;
    align-items: flex-start;
}

.rk-vic-modal-header h4 {
    margin: 0 0 4px;
    font-size: 19px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-modal-header p {
    margin: 0;
    font-size: 14px;
    color: #64748b;
}

.rk-vic-modal-body {
    padding: 10px 28px 24px;
}

.rk-vic-modal-top {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
    align-items: end;
    margin-bottom: 22px;
}

.rk-vic-steps {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 4px;
    padding: 4px;
    border-radius: 12px;
    background: #eef2f7;
}

.rk-vic-step {
    border: 0;
    background: transparent;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 15px;
    font-weight: 700;
    color: #64748b;
}

.rk-vic-step.active {
    background: #fff;
    color: #1f2937;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
}

.rk-vic-pane {
    display: none;
}

.rk-vic-pane.active {
    display: block;
}

.rk-vic-info-card {
    margin-bottom: 18px;
    padding: 18px;
    border-radius: 14px;
    background: #f8fbff;
    border: 1px solid #dbeafe;
    display: flex;
    gap: 14px;
    align-items: flex-start;
}

.rk-vic-info-card h5 {
    margin: 0 0 8px;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-info-card p {
    margin: 0;
    color: #64748b;
}

.rk-vic-info-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid #1d4ed8;
    color: #1d4ed8;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
}

.rk-vic-field-group {
    margin-bottom: 20px;
}

.rk-vic-field-group label {
    display: block;
    margin-bottom: 10px;
    font-size: 15px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-field-group small {
    display: block;
    margin-top: 8px;
    color: #64748b;
    font-size: 13px;
}

.rk-vic-select-focus {
    border-color: #1d4ed8;
    box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.08);
}

.rk-vic-divider {
    height: 1px;
    background: #dbe4f0;
    margin: 20px 0;
}

.rk-vic-portal-card {
    padding: 16px;
    border: 1px solid #bfd3ff;
    border-radius: 12px;
    background: #eef4ff;
}

.rk-vic-portal-card h5,
.rk-vic-followup h5 {
    margin: 0 0 8px;
    font-size: 15px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-portal-card p,
.rk-vic-followup p {
    margin: 0 0 14px;
    color: #64748b;
}

.rk-vic-secondary-btn,
.rk-vic-primary-btn {
    width: 100%;
    border-radius: 8px;
    padding: 12px 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 700;
    border: 1px solid #d7e0ef;
    margin-bottom: 12px;
    background: #fff;
    color: #1f2937;
}

.rk-vic-primary-btn {
    background: #143f78;
    border-color: #143f78;
    color: #fff;
    margin-bottom: 0;
}

.rk-vic-followup {
    margin-bottom: 20px;
}

.rk-vic-quick-bar {
    display: flex;
    justify-content: flex-end;
}

.rk-vic-action-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 18px;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    background: #fff;
}

.rk-vic-action-card strong {
    display: block;
    margin-bottom: 6px;
    font-size: 15px;
    color: #1f2937;
}

.rk-vic-action-card p {
    margin: 0;
    color: #64748b;
}

.rk-vic-modal-footer {
    border-top: 0;
    padding: 0 28px 24px;
}

@media (max-width: 767.98px) {
    .rk-vic-steps {
        grid-template-columns: 1fr;
    }

    .rk-vic-action-card {
        flex-direction: column;
        align-items: flex-start;
    }
}

/* ===== common glossy detail layout ===== */
.content-inner {
    background:
        radial-gradient(circle at 10% 0%, rgba(81, 183, 216, 0.18), transparent 28%),
        radial-gradient(circle at 92% 10%, rgba(54, 179, 126, 0.16), transparent 24%),
        linear-gradient(180deg, rgba(23, 105, 170, 0.05), transparent 260px),
        #f4f8fb;
    padding: 12px !important;
    max-height: calc(100vh - 3.75rem);
    overflow-x: hidden;
    overflow-y: auto !important;
    scroll-behavior: smooth;
}

.content-wrapper {
    min-height: 0;
    overflow: hidden;
}

.rk-overview-wrapper {
    position: relative;
    overflow: visible;
    padding: 0 0 18px;
    background: transparent;
    color: #102033;
}

.rk-overview-wrapper::before {
    content: "";
    position: absolute;
    top: -80px;
    right: 5%;
    width: 300px;
    height: 160px;
    background: url("{{ asset('logo.png') }}") center/contain no-repeat;
    opacity: 0.055;
    filter: drop-shadow(0 0 34px rgba(23, 105, 170, 0.42));
    pointer-events: none;
}

.rk-overview-header,
.rk-lifecycle-box,
.rk-summary-card,
.rk-notes-card,
.rk-files-card {
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(23, 105, 170, 0.14);
    border-radius: 8px;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 252, 255, 0.98)),
        radial-gradient(circle at 0% 0%, rgba(81, 183, 216, 0.18), transparent 30%),
        radial-gradient(circle at 100% 8%, rgba(246, 180, 69, 0.12), transparent 24%);
    box-shadow: 0 18px 44px rgba(16, 32, 51, 0.09), inset 0 1px 0 rgba(255, 255, 255, 0.95);
}

.rk-overview-header::before,
.rk-lifecycle-box::before,
.rk-summary-card::before,
.rk-notes-card::before,
.rk-files-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto;
    height: 3px;
    background: linear-gradient(90deg, #1769aa, #36b37e, #f6b445, #db2777);
    z-index: 1;
}

.rk-overview-header {
    min-height: 96px;
    gap: 16px;
    margin-bottom: 12px;
    padding: 18px;
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(16, 32, 51, 0.97), rgba(23, 105, 170, 0.92) 48%, rgba(54, 179, 126, 0.9)),
        url("{{ asset('vendor/images/demo/cover3.jpg') }}") center/cover no-repeat;
    color: #ffffff;
}

.rk-overview-header::after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 78% 48%, rgba(255, 255, 255, 0.34), transparent 24%),
        linear-gradient(90deg, rgba(255,255,255,0.08), transparent 44%, rgba(255,255,255,0.16));
    pointer-events: none;
}

.rk-overview-header > * {
    position: relative;
    z-index: 2;
}

.rk-overview-title-wrap {
    display: flex;
    align-items: center;
    gap: 13px;
    min-width: 0;
}

.rk-lead-avatar {
    display: inline-flex;
    width: 52px;
    height: 52px;
    min-width: 52px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #ffffff;
    background: linear-gradient(135deg, #36b37e, #51b7d8);
    border: 2px solid rgba(255, 255, 255, 0.55);
    font-size: 20px;
    font-weight: 900;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.38), 0 16px 30px rgba(4, 18, 32, 0.28);
}

.rk-overview-kicker,
.rk-overview-subtitle,
.rk-overview-title {
    color: #fff;
}

.rk-overview-kicker {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 3px;
    color: rgba(255, 255, 255, 0.78);
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.rk-overview-kicker i {
    color: #f6b445;
}

.rk-overview-title {
    font-size: 26px;
    font-weight: 900;
    letter-spacing: 0;
}

.rk-overview-subtitle {
    margin: 4px 0 0;
    color: rgba(255, 255, 255, 0.76);
    font-size: 13px;
    font-weight: 650;
}

.rk-action-tabs {
    justify-content: flex-end;
    margin: 0;
}

.rk-action-tabs .btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    min-height: 36px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.28) !important;
    background: rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
    font-size: 12px;
    font-weight: 850;
    backdrop-filter: blur(8px);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.26), 0 10px 22px rgba(4, 18, 32, 0.16);
}

.rk-action-tabs .btn svg {
    width: 16px;
    height: 16px;
    margin-right: 0 !important;
}

.rk-action-tabs .btn:hover {
    transform: translateY(-1px);
    background: rgba(255, 255, 255, 0.2) !important;
}

.rk-lifecycle-box {
    margin-bottom: 12px;
    padding: 14px;
}

.rk-lifecycle-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 11px;
}

.rk-lifecycle-label,
.rk-lifecycle-value {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-weight: 850;
}

.rk-lifecycle-label {
    color: #52667c;
    font-size: 12px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.rk-lifecycle-label i {
    color: #1769aa;
    font-size: 17px;
}

.rk-lifecycle-value {
    min-height: 30px;
    padding: 5px 10px;
    border-radius: 999px;
    border: 1px solid rgba(54, 179, 126, 0.22);
    background: linear-gradient(180deg, #ffffff, #f1fbf7);
    color: #268765;
    font-size: 12px;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.92), 0 9px 20px rgba(54, 179, 126, 0.12);
}

.rk-pipeline {
    gap: 7px;
    padding: 7px;
    background: rgba(232, 242, 249, 0.76);
    border: 1px solid rgba(23, 105, 170, 0.1);
}

.rk-stage {
    border-radius: 8px;
    padding: 9px 13px;
    background: linear-gradient(180deg, #ffffff, #edf7fa);
    color: #52667c;
    border: 1px solid rgba(23, 105, 170, 0.12);
    font-weight: 800;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.92), 0 8px 18px rgba(16, 32, 51, 0.05);
}

.rk-stage::after {
    display: none;
}

.rk-stage:not(:first-child) {
    margin-left: 0;
}

.rk-stage.active {
    background: linear-gradient(135deg, #1769aa, #36b37e);
    border-color: transparent;
    color: #fff;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.34), 0 12px 26px rgba(23, 105, 170, 0.2);
}

.rk-overview-body {
    grid-template-columns: minmax(0, 2fr) minmax(310px, 1fr);
    gap: 12px;
    align-items: start;
}

.rk-column-stack {
    display: grid;
    gap: 12px;
}

.rk-summary-header,
.rk-notes-header,
.rk-files-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    min-height: 46px;
    padding: 12px 14px;
    border-bottom: 1px solid rgba(23, 105, 170, 0.1);
    background: linear-gradient(135deg, rgba(232, 246, 255, 0.78), rgba(232, 250, 246, 0.76));
}

.rk-summary-header strong,
.rk-notes-header strong,
.rk-files-header strong {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #102033;
    font-size: 13px;
    font-weight: 900;
}

.rk-summary-row {
    gap: 12px;
    margin-bottom: 12px;
}

.rk-summary-row > div {
    min-height: 74px;
    padding: 12px;
    border: 1px solid rgba(23, 105, 170, 0.1);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.72);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.84);
}

.rk-summary-row label {
    display: block;
    margin-bottom: 5px;
    color: #7a8ea3;
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.rk-summary-row p {
    margin: 0;
    color: #102033;
    font-size: 13px;
    font-weight: 850;
}

.rk-notes-card {
    padding: 0;
}

.rk-notes-card form {
    padding: 14px;
}

.rk-note-input {
    min-height: 86px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.76);
}

.rk-notes-list {
    height: 260px;
    padding: 0 14px 14px;
}

.rk-note-item {
    margin-bottom: 8px;
    padding: 12px;
    border: 1px solid rgba(23, 105, 170, 0.1);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.72);
}

.rk-files-card {
    margin-top: 0;
}

.rk-attachments-card {
    padding: 0;
}

.rk-attach-list {
    max-height: 280px;
    padding: 12px 14px;
}

.rk-attach-item {
    padding: 10px 0;
    border-bottom: 1px dashed rgba(23, 105, 170, 0.16);
}

.rk-attach-link {
    color: #102033;
    font-weight: 750;
}

.rk-vic-modal {
    width: min(760px, 100vw) !important;
    border: 0;
    border-radius: 0;
    color: #102033;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(247, 252, 255, 0.96)),
        radial-gradient(circle at 12% 0%, rgba(45, 133, 255, 0.18), transparent 28%);
    box-shadow: -24px 0 70px rgba(13, 44, 82, 0.24);
}

.rk-vic-modal:before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background:
        radial-gradient(circle at 12% 4%, rgba(255, 255, 255, 0.92), transparent 16%),
        radial-gradient(circle at 90% 12%, rgba(43, 130, 255, 0.2), transparent 24%),
        linear-gradient(135deg, rgba(22, 105, 170, 0.08), rgba(54, 179, 126, 0.08));
}

.rk-vic-modal-header {
    position: relative;
    padding: 28px 30px 24px;
    color: #fff;
    background: linear-gradient(135deg, #0b376d 0%, #1769aa 48%, #16a085 100%);
    box-shadow: 0 16px 34px rgba(23, 105, 170, 0.22);
}

.rk-vic-modal-header:after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(120deg, rgba(255, 255, 255, 0.22), transparent 34%),
        radial-gradient(circle at 88% 18%, rgba(255, 214, 102, 0.28), transparent 24%);
    pointer-events: none;
}

.rk-vic-modal-header > *,
.rk-vic-modal-body,
.rk-vic-modal-footer {
    position: relative;
    z-index: 1;
}

.rk-vic-offcanvas-kicker {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 10px;
    color: rgba(255, 255, 255, 0.78);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.rk-vic-modal-header h4 {
    color: #fff;
    font-size: 24px;
    font-weight: 800;
}

.rk-vic-modal-header p {
    color: rgba(255, 255, 255, 0.76);
}

.rk-vic-offcanvas-close {
    filter: invert(1) grayscale(1) brightness(2);
    opacity: 0.9;
}

.rk-vic-modal-body {
    padding: 24px 30px;
}

.rk-vic-steps,
.rk-vic-info-card,
.rk-vic-portal-card,
.rk-vic-followup {
    border: 1px solid rgba(23, 105, 170, 0.12);
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.88), rgba(248, 252, 255, 0.92));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9), 0 12px 26px rgba(16, 32, 51, 0.06);
}

.rk-vic-step.active,
.rk-vic-primary-btn,
.rk-vic-modal-footer .btn-primary {
    background: linear-gradient(135deg, #1769aa, #36b37e);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 12px 24px rgba(23, 105, 170, 0.18);
}

.rk-vic-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 30px 24px;
    border-top: 1px solid rgba(23, 105, 170, 0.12);
    background: rgba(255, 255, 255, 0.82);
    backdrop-filter: blur(12px);
}

@media (max-width: 768px) {
    .rk-overview-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .rk-action-tabs {
        justify-content: flex-start;
        width: 100%;
    }

    .rk-overview-body {
        grid-template-columns: 1fr;
    }
}

</style>
@endsection

@extends('layouts.super')

@section('title', 'Leads')

@section('content')

@php


$lead->status = $lead->status == 'Sold' ? 'Not Applied' : $lead->status;

// example — replace with your real status
$currentStatus = $lead->status ?? 'New';
$leadName = trim(($lead->first_name ?? '').' '.($lead->last_name ?? '')) ?: 'Lead';
$leadInitial = strtoupper(substr(trim($lead->first_name ?: $lead->last_name ?: $leadName), 0, 1));
$approvalRequiredValue = $leadMeta['distributor_approval_required'] ?? 'Yes';
$distributorNameValue = $leadMeta['distributor_name'] ?? '';
$existingSystemValue = $leadMeta['existing_system'] ?? '';
$meterNumberValue = $leadMeta['meter_number'] ?? '';
$nmiNumberValue = $leadMeta['nmi_number'] ?? '';
$photosRequiredValue = $leadMeta['photos_required'] ?? '';
$approvalFileUrl = $leadMeta['distributor_approval_file'] ?? '';
$approvalFileName = $approvalFileUrl ? basename(parse_url($approvalFileUrl, PHP_URL_PATH)) : 'No file selected';
$hasPreviousDistributorData = $approvalRequiredValue !== '' || $distributorNameValue !== '' || $existingSystemValue !== '' || $meterNumberValue !== '' || $nmiNumberValue !== '' || $photosRequiredValue !== '' || $approvalFileUrl !== '';
$vicCustomerApplyingValue = $leadMeta['vic_customer_applying'] ?? 'Yes';
$vicInsNumberValue = $leadMeta['vic_ins_number'] ?? '';
$vicRebateStatusValue = $leadMeta['vic_rebate_status'] ?? 'Quote Submitted';
$vicWorkflowStatuses = [
    'VIC REBATE NOT APPLIED' => 'Not Applied',
    'VIC REBATE AWAITING APPROVAL' => 'Awaiting Approval',
    'COMPLIANCE NOT APPLIED' => 'Compliance Not Applied',
];
$currentVicWorkflowStatus = array_key_exists($lead->status ?? '', $vicWorkflowStatuses)
    ? $lead->status
    : 'VIC REBATE NOT APPLIED';
$activeVicPane = $currentVicWorkflowStatus === 'VIC REBATE AWAITING APPROVAL' ? 'awaiting' : 'apply';
@endphp

@php
$stages = $vicWorkflowStatuses;
@endphp

<div class="rk-overview-wrapper">

    <!-- header -->
    <div class="rk-overview-header">
        <div class="rk-overview-title-wrap">
            <span class="rk-lead-avatar">{{ $leadInitial }}</span>
            <div>
                <span class="rk-overview-kicker"><i class="ph ph-sparkle"></i> VIC Rebate</span>
                <h3 class="rk-overview-title">Overview #{{$lead->id}}</h3>
                <p class="rk-overview-subtitle">{{ $leadName }} · {{ $lead->leadSource->source ?? 'Direct lead' }}</p>
            </div>
        </div>
        <div class="rk-action-tabs">

            @can('lead_email_access')
            <button class="btn btn-outline-primary send_email_inner" data-bs-toggle="offcanvas"
                data-bs-target="#emailModel" aria-controls="emailModel"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-mail h-4 w-4 mr-2"
                    data-lov-id="src/components/leads/LeadDetailModal.tsx:226:14" data-lov-name="Mail"
                    data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="226"
                    data-component-file="LeadDetailModal.tsx" data-component-name="Mail"
                    data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg> Send Email</button>

            @endcan

            @can('lead_call_log')
            <button class="btn btn-outline-warning view-lead" data-bs-toggle="offcanvas" data-bs-target="#leadDetailsModal" aria-controls="leadDetailsModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-phone h-4 w-4 mr-2"
                    data-lov-id="src/components/leads/LeadDetailModal.tsx:238:14" data-lov-name="Phone"
                    data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="238"
                    data-component-file="LeadDetailModal.tsx" data-component-name="Phone"
                    data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                    </path>
                </svg> Log Call</button>
            @endcan
            @can('lead_generate_quote')
            @if(!$lead->project_id)
            <button class="btn btn-outline-success generateQuote"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-4 w-4 mr-2"
                    data-lov-id="src/components/leads/LeadDetailModal.tsx:245:14" data-lov-name="FileText"
                    data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="245"
                    data-component-file="LeadDetailModal.tsx" data-component-name="FileText"
                    data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                    <path d="M10 9H8"></path>
                    <path d="M16 13H8"></path>
                    <path d="M16 17H8"></path>
                </svg> Generate Quote</button>
            @endif
            @endcan
            <button data-lead='@json($lead)' class="btn btn-outline-danger edit_lead"
                data-bs-toggle="offcanvas" data-bs-target="#editlead" aria-controls="editlead">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-file-text h-4 w-4 mr-2"
                    data-lov-id="src/components/leads/LeadDetailModal.tsx:245:14" data-lov-name="FileText"
                    data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="245"
                    data-component-file="LeadDetailModal.tsx" data-component-name="FileText"
                    data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                    <path d="M10 9H8"></path>
                    <path d="M16 13H8"></path>
                    <path d="M16 17H8"></path>
                </svg>Edit Lead</button>

            <button type="button" class="btn btn-outline-primary vic-workflow-trigger"
                data-bs-toggle="offcanvas" data-bs-target="#vicWorkflowModal" aria-controls="vicWorkflowModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-git-branch h-4 w-4 mr-2">
                    <path d="M6 3v12"></path>
                    <path d="M18 9a3 3 0 1 0-3-3"></path>
                    <path d="M6 15a3 3 0 1 0 3 3"></path>
                    <path d="M18 6V5"></path>
                    <path d="M6 15c0-3 2-5 5-5h7"></path>
                </svg>VIC Rebate</button>

            <!-- <div class="rk-action-tab">
                <a href="javascript:;" class="edit_lead" data-lead='@json($lead)' data-bs-toggle="offcanvas"
                    data-bs-target="#editlead">Edit Lead</a>
            </div> -->

            <!-- <div class="rk-action-tab">
                <a href="javascript:;" class="edit_lead" data-lead='@json($lead)' data-bs-toggle="offcanvas"
                    data-bs-target="#editlead">Generate Quote</a>
            </div> -->
        </div>
    </div>

    <!-- lifecycle -->
    <div class="rk-lifecycle-box">
        <div class="rk-lifecycle-top">
            <span class="rk-lifecycle-label"><i class="ph ph-chart-line-up"></i> Life-cycle stage</span>
            <span class="rk-lifecycle-value"><i class="ph ph-circle-wavy-check"></i> {{ $vicWorkflowStatuses[$currentVicWorkflowStatus] ?? $currentStatus }}</span>
        </div>

        <!-- ✅ HUBSPOT PIPELINE -->
        <div class="rk-pipeline">
            @foreach($stages as $stageValue => $stageLabel)
            <div class="rk-stage {{ $currentVicWorkflowStatus == $stageValue ? 'active' : '' }}"
                onclick="changeLeadStatus('{{ $stageValue }}')">
                {{ $stageLabel }}
            </div>
            @endforeach
            <form id="statusForm" method="POST" action="{{ route('superadmin.updateLeadStatusNew') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $lead->id }}">
                <input type="hidden" name="status" id="statusInput">
            </form>
        </div>
    </div>

    <!-- body -->
    <div class="rk-overview-body">

        <div class="rk-column-stack">
            <!-- left -->
            <div class="rk-summary-card">
                <div class="rk-summary-header">
                    <strong><i class="ph ph-user-circle"></i> Summary</strong>

                </div>

                <div class="rk-summary-content">
                    <div class="rk-summary-row">
                        <div>
                            <label>Name</label>
                            <p>{{ $lead->first_name.' '.$lead->last_name}}</p>
                        </div>


                        <div>
                            <label>Email</label>
                            <p>{{ $lead->email ?? '—' }}</p>
                        </div>

                        <div>
                            <label>Mobile</label>
                            <p>{{ $lead->phone ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Address</label>
                            <p>{{ trim(implode(', ', array_filter([
    					$lead->address,
    					$lead->suburb,
    					$lead->state ? $lead->state . ' ' . $lead->postcode : $lead->postcode,
    				]))); }}</p>
                        </div>


                        <div>
                            <label>Roof Type</label>
                            <p>{{ $lead->roof_type ?? '-' }}</p>
                            <!-- <p class="rk-link">Click to add</p> -->
                        </div>

                        <div>
                            <label>Eligible for Rebate</label>
                            <p>{{ $lead->elogible_for_rebate ?? '-' }}</p>
                            <!-- <p class="rk-link">Click to add</p> -->
                        </div>

                        <div>
                            <label>Source</label>
                            <p>{{ $lead->leadSource->source ?? '-' }}</p>
                        </div>

                        <div>
                            <label>Category</label>
                            <?php
                            $html = '<strong class="text-dark">'.($lead->category ?? '').'</strong>';
    			
                            // Solar KW condition
                            if (
                                in_array($lead->category, ['Solar', 'Solar+Battery']) &&
                                !empty($lead->solar_kw)
                            ) {
                                $html .= ' &nbsp;|&nbsp; Solar KW: 
                                    <strong class="text-dark">'.$lead->solar_kw.'</strong>';
                            }
                        
                            // Battery KW condition
                            if (
                                in_array($lead->category, ['Battery', 'Solar+Battery']) &&
                                !empty($lead->battery_kw)
                            ) {
                                $html .= ' &nbsp;|&nbsp; Battery KW: 
                                    <strong class="text-dark">'.$lead->battery_kw.'</strong>';
                            }

                            ?>
                            <p>{!! $html ?? '-' !!}</p>
                        </div>


                        <div>
                            <label>Rejection Url</label>

                            @if(!empty($lead->rejection_url))
                            <a href="{{ $lead->rejection_url }}" target="_blank" onclick="return confirm('Are you sure?');">
                                <p class="rk-link" style="color:red">Rejection Url</p>
                            </a>
                            @else
                            <p class="text-muted">—</p>
                            @endif
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Sales owner</label>
                            <p>{{ $lead->getAssignUserName->name ?? 'Not Assign Yet' }}</p>
                        </div>

                        <div>
                            <label>Created At</label>
                            <p>{{ $lead->created_at}}</p>
                        </div>
                    </div>


                </div>
            </div>

            @if($hasPreviousDistributorData)
            <div class="rk-summary-card">
                <div class="rk-summary-header">
                    <strong>Distributor Details</strong>
                </div>

                <div class="rk-summary-content">
                    <div class="rk-summary-row">
                        <div>
                            <label>Approval Required</label>
                            <p>{{ $approvalRequiredValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Distributor</label>
                            <p>{{ $distributorNameValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Existing System</label>
                            <p>{{ $existingSystemValue ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Meter Number</label>
                            <p>{{ $meterNumberValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>NMI Number</label>
                            <p>{{ $nmiNumberValue ?: '-' }}</p>
                        </div>

                        <!-- <div>
                            <label>Photos Required</label>
                            <p>{{ $photosRequiredValue ?: '-' }}</p>
                        </div> -->
                    </div>

                    <div class="rk-summary-row">
                        <!-- <div>
                            <label>Distributor Step</label>
                            <p>Applied</p>
                        </div> -->

                        <div>
                            <label>Approval File</label>
                            @if($approvalFileUrl)
                            <a href="{{ $approvalFileUrl }}" target="_blank" class="rk-link">{{ $approvalFileName }}</a>
                            @else
                            <p>—</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- right -->
        <div class="rk-column-stack">
            <div class="rk-notes-card">
            <div class="rk-notes-header">
                <strong><i class="ph ph-note-pencil"></i> Notes</strong>
                <span>{{ $lead->leadNotes->count() }} entries</span>
            </div>

            <form method="POST" action="{{ route('admin.noteStore') }}">
                @csrf
                <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                <textarea name="note" class="rk-note-input" placeholder="Add a note..." required></textarea>
                <button type="submit" class="badge bg-success me-1">Save</button>
            </form>

            <div class="rk-notes-list">


                @forelse($lead->leadNotes as $note)
                <div class="rk-note-item">
                    <p>{{ $note->note }}</p>
                    <span>
                        {{ @$note->creator->name ?? 'System' }} ·
                        {{ optional($note->created_at)->format('D d M, Y') }}
                    </span>
                </div>
                @empty
                <div class="rk-note-empty">
                    <p>No notes found</p>
                </div>
                @endforelse





            </div>
            </div>
            {{-- ================= ATTACHMENTS ================= --}}
            <div class="rk-files-card card rk-attachments-card">
            <div class="rk-files-header">
                <h6 class="mb-0"><strong><i class="ph ph-paperclip"></i> Attachments ({{$lead->images->count()}})</strong></h6>

                <button id="addFileBtn" class="btn btn-sm btn-outline-primary">
                    <i class="ph ph-upload-simple"></i> Add Files
                </button>

                <input type="file" id="fileInput" hidden>
            </div>

            <ul class="rk-attach-list">

                @forelse($lead->images as $file)

                @php
                // remove admin/ from path if exists
                $fileUrl = preg_replace('/^admin\//', '', $file->image_path);

                // final URL (adjust if using storage)
                $fullUrl = asset($fileUrl);
                @endphp

                <li class="rk-attach-item">

                    {{-- file link --}}
                    <a href="{{ $fullUrl }}" target="_blank" class="rk-attach-link">
                        <i class="ph ph-file"></i> {{ basename($file->image_path) }}
                    </a>

                    {{-- delete button --}}
                    <a href="javascript:void(0)" class="text-danger delete-lead-image" data-id="{{ $file->id }}"
                        data-tble="lead_images" title="Delete">
                        <i class="fa fa-trash"></i> Delete
                    </a>

                </li>

                @empty

                <li class="rk-attach-empty">
                    No attachments found
                </li>

                @endforelse

            </ul>
            </div>
        </div>
    </div>


</div>
<div class="offcanvas offcanvas-end rk-vic-modal" id="vicWorkflowModal" tabindex="-1" aria-labelledby="vicWorkflowModalLabel">
            <div class="offcanvas-header rk-vic-modal-header">
                <div>
                    <span class="rk-vic-offcanvas-kicker"><i class="ph ph-sun"></i> Workflow</span>
                    <h4 class="offcanvas-title" id="vicWorkflowModalLabel">Solar VIC Rebate - Job #{{ $lead->id }}</h4>
                    <p>{{ trim(($lead->first_name ?? '').' '.($lead->last_name ?? '')) ?: 'Customer' }}</p>
                </div>
                <button type="button" class="btn-close rk-vic-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body rk-vic-modal-body">
                <div class="rk-vic-modal-top">
                    <div class="rk-vic-steps">
                        <button type="button" class="rk-vic-step {{ $activeVicPane === 'apply' ? 'active' : '' }}" data-step="apply">Apply Rebate</button>
                        <button type="button" class="rk-vic-step {{ $activeVicPane === 'awaiting' ? 'active' : '' }}" data-step="awaiting">Awaiting Approval</button>
                    </div>
                </div>

                <div class="rk-vic-pane {{ $activeVicPane === 'apply' ? 'active' : '' }}" data-pane="apply">
                    <div class="rk-vic-field-group">
                        <label for="vicCustomerApplying">Is Customer Applying for Solar VIC Rebate?</label>
                        <select id="vicCustomerApplying" class="form-select rk-vic-select-focus">
                            <option value="Yes" {{ $vicCustomerApplyingValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $vicCustomerApplyingValue === 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="rk-vic-divider"></div>

                    <div class="rk-vic-portal-card">
                        <h5>Solar VIC Portal Access</h5>
                        <p>Login credentials are attached to this job for portal access.</p>

                        <button type="button" class="rk-vic-secondary-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m22 8-6 4 6 4V8Z"></path>
                                <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                            </svg>
                            Watch Application Guide
                        </button>

                        <button type="button" class="rk-vic-primary-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h6v6"></path>
                                <path d="M10 14 21 3"></path>
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            </svg>
                            Open Solar VIC Portal
                        </button>
                    </div>

                    <div class="rk-vic-divider"></div>

                    <div class="rk-vic-field-group">
                        <label for="vicInsNumber">INS Number (Installation Number)</label>
                        <input type="text" id="vicInsNumber" class="form-control" placeholder="Enter INS number from Solar VIC portal" value="{{ $vicInsNumberValue }}">
                    </div>
                </div>

                <div class="rk-vic-pane {{ $activeVicPane === 'awaiting' ? 'active' : '' }}" data-pane="awaiting">
                    <div class="rk-vic-info-card">
                        <div class="rk-vic-info-icon">!</div>
                        <div>
                            <h5>Awaiting Solar VIC Approval</h5>
                            <p>Sales representative is responsible. Admin uploads daily CSV via the main page to bulk update statuses.</p>
                        </div>
                    </div>

                    <div class="rk-vic-field-group">
                        <label for="vicAwaitingStatus">Status of Solar VIC Rebate</label>
                        <select id="vicAwaitingStatus" class="form-select rk-vic-select-focus">
                            <option value="Quote Submitted" {{ $vicRebateStatusValue === 'Quote Submitted' ? 'selected' : '' }}>Quote Submitted</option>
                            <option value="Documents Pending" {{ $vicRebateStatusValue === 'Documents Pending' ? 'selected' : '' }}>Documents Pending</option>
                            <option value="Under Review" {{ $vicRebateStatusValue === 'Under Review' ? 'selected' : '' }}>Under Review</option>
                            <option value="Awaiting Customer Action" {{ $vicRebateStatusValue === 'Awaiting Customer Action' ? 'selected' : '' }}>Awaiting Customer Action</option>
                        </select>
                        <small>Current Status: <strong id="vicAwaitingStatusText">{{ $vicRebateStatusValue }}</strong></small>
                    </div>

                    <div class="rk-vic-divider"></div>

                    <div class="rk-vic-followup">
                        <h5>Follow-up with Customer</h5>
                        <p>Send reminder emails to customer to complete their application</p>
                        <button type="button" class="rk-vic-secondary-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            Send Email 1: Solar VIC Rebate - Action Required
                        </button>
                        <button type="button" class="rk-vic-secondary-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            Send Email 2: Solar VIC Rebate - Second Reminder
                        </button>
                    </div>
                </div>

            </div>

            <div class="rk-vic-modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Close</button>
                <button type="button" class="btn btn-primary" id="saveVicWorkflowBtn">Save Step</button>
            </div>
</div>
@include('admin.leads._email_modal',['emailTemplates'=>$emailTemplates])
@include('super.leads._edit_modal')
@include('admin.leads.call_logs')


@endsection

@section('scripts')
@parent
<script>
const leadId = '{{ $lead->id }}';

function submitLeadStatus(status, withConfirmation = true) {
    if (withConfirmation && !confirm('Are you sure you want to change the status?')) {
        return;
    }

    document.getElementById('statusInput').value = status;
    document.getElementById('statusForm').submit();
}

function changeLeadStatus(status) {
    submitLeadStatus(status, true);
}

$(document).on('click', '.generateQuote', function() {
    if (confirm("Are you sure you want to generate this quote?")) {
        let url = "{{ route('admin.generateQuote', ':id') }}";
        url = url.replace(':id', leadId);

        window.location.href = url;
    }
});

$(function() {
    function activateVicPane(targetStep) {
        $('.rk-vic-step').removeClass('active');
        $('.rk-vic-step[data-step="' + targetStep + '"]').addClass('active');
        $('.rk-vic-pane').removeClass('active');
        $('.rk-vic-pane[data-pane="' + targetStep + '"]').addClass('active');
    }

    function syncVicWorkflowStep(status) {
        const targetStep = status === 'VIC REBATE AWAITING APPROVAL' ? 'awaiting' : 'apply';
        activateVicPane(targetStep);
    }

    syncVicWorkflowStep('{{ $currentVicWorkflowStatus }}');

    $('.rk-vic-step').on('click', function() {
        const step = $(this).data('step');
        activateVicPane(step);
    });

    $('#vicAwaitingStatus').on('change', function() {
        $('#vicAwaitingStatusText').text($(this).val());
    });

    $('#saveVicWorkflowBtn').on('click', function() {
        const activePane = $('.rk-vic-pane.active').data('pane');
        const customerApplying = $('#vicCustomerApplying').length
            ? $('#vicCustomerApplying').val()
            : '{{ $vicCustomerApplyingValue }}';
        const status = activePane === 'awaiting'
            ? 'COMPLIANCE NOT APPLIED'
            : (customerApplying === 'Yes' ? 'VIC REBATE AWAITING APPROVAL' : 'COMPLIANCE NOT APPLIED');
        const $btn = $(this);

        $btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: '{{ route("superadmin.saveVicRebateMeta") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                lead_id: leadId,
                status: status,
                customer_applying: $('#vicCustomerApplying').val(),
                ins_number: $('#vicInsNumber').val(),
                rebate_status: $('#vicAwaitingStatus').val()
            },
            success: function() {
                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to save Solar VIC step.');
                $btn.prop('disabled', false).text('Save Step');
            }
        });
    });
});


$(function() {
    $('#addFileBtn').on('click', function() {
        $('#fileInput').click();
    });

    $('#fileInput').on('change', function() {
        let file = this.files[0];
        let formData = new FormData();
        formData.append('file', file);
        formData.append('lead_id', leadId);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("superadmin.leadImages") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                location.reload();
            },
            error: function(err) {
                alert('Upload failed!');
            }
        });
    });
});
</script>
@endsection
