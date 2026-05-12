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
    min-height: calc(100vh - 70px);
    background:
        radial-gradient(circle at 8% 0%, rgba(47, 128, 237, .12), transparent 28%),
        linear-gradient(180deg, #f7fbff 0%, #eef5f8 100%);
    padding: 20px;
}

/* header */
.rk-overview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 18px;
    padding: 18px;
    border: 1px solid rgba(23, 105, 170, .14);
    border-radius: 16px;
    background:
        linear-gradient(135deg, rgba(255, 255, 255, .96), rgba(241, 248, 255, .88));
    box-shadow: 0 18px 45px rgba(15, 50, 85, .1);
}

.rk-overview-title-wrap {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
}

.rk-lead-avatar {
    display: inline-flex;
    width: 54px;
    height: 54px;
    flex: 0 0 54px;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    color: #fff;
    background: linear-gradient(135deg, #1769aa, #16a085);
    box-shadow: 0 14px 28px rgba(23, 105, 170, .24);
    font-size: 22px;
    font-weight: 800;
}

.rk-overview-kicker {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 4px;
    color: #1769aa;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-overview-title {
    margin: 0;
    color: #102033;
    font-size: 23px;
    font-weight: 800;
}

.rk-overview-subtitle {
    margin: 4px 0 0;
    color: #64748b;
    font-size: 13px;
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
    border: 1px solid rgba(23, 105, 170, .12);
    background: rgba(255, 255, 255, .92);
    padding: 15px;
    border-radius: 14px;
    margin-bottom: 15px;
    box-shadow: 0 12px 30px rgba(15, 50, 85, .07);
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
    border: 1px solid rgba(23, 105, 170, .1);
    background: rgba(255, 255, 255, .94);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(15, 50, 85, .07);
}

.rk-summary-header {
    background: linear-gradient(135deg, #eef7ff, #eafaf6);
    padding: 12px 15px;
    color: #102033;
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
    border: 1px solid rgba(23, 105, 170, .1);
    background: rgba(255, 255, 255, .94);
    border-radius: 14px;
    padding: 15px;
    box-shadow: 0 12px 30px rgba(15, 50, 85, .07);
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

    .rk-summary-row {
        grid-template-columns: 1fr;
    }

    .rk-dist-approval-header {
        flex-direction: column;
    }

    .rk-dist-approval-steps {
        grid-template-columns: 1fr 1fr;
    }
}

/* ===== added action tabs (non-breaking) ===== */
.rk-action-tabs {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    margin: 0;
    flex-wrap: wrap;
}

.rk-action-tabs .btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .78);
    box-shadow: 0 8px 20px rgba(15, 50, 85, .06);
    font-weight: 700;
}

.rk-action-tabs svg {
    width: 16px;
    height: 16px;
    margin-right: 0 !important;
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
    border: 1px solid rgba(23, 105, 170, .1);
    border-radius: 14px;
    background: rgba(255, 255, 255, .94);
    box-shadow: 0 12px 30px rgba(15, 50, 85, .07);
}

.rk-column-stack > .rk-files-card {
    margin-top: 0;
}

.rk-attachments-card {
    margin-top: 0;
}

.rk-dist-approval-card {
    border: 1px solid rgba(23, 105, 170, .12);
    border-radius: 16px;
    padding: 18px;
    background:
        radial-gradient(circle at 100% 0%, rgba(22, 160, 133, .12), transparent 28%),
        linear-gradient(180deg, rgba(255, 255, 255, .98), rgba(247, 252, 255, .94));
    margin-bottom: 18px;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .9);
}

.rk-dist-approval-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 16px;
}

.rk-dist-approval-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 4px;
    color: #1f2937;
}

.rk-dist-approval-subtitle {
    margin: 0;
    color: #64748b;
    font-size: 15px;
}

.rk-dist-field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}

.rk-dist-approval-steps {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    background: #e9eef6;
    border-radius: 10px;
    padding: 4px;
    margin-bottom: 16px;
}

.rk-dist-step {
    border: 0;
    background: transparent;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
}

.rk-dist-step.active {
    background: #fff;
    color: #1f2937;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
}

.rk-dist-step.disabled {
    opacity: .55;
    cursor: not-allowed;
}

.rk-dist-pane {
    display: none;
}

.rk-dist-pane.active {
    display: block;
}

.rk-dist-approval-info {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #f6f9ff;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 22px;
}

.rk-dist-approval-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid #1d4ed8;
    color: #1d4ed8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    flex-shrink: 0;
}

.rk-dist-approval-info h5 {
    margin: 0 0 4px;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}

.rk-dist-approval-info p {
    margin: 0;
    color: #64748b;
}

.rk-dist-approval-form {
    display: grid;
    gap: 22px;
}

.rk-dist-form-grid {
    display: grid;
    gap: 18px;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    width: 100%;
}

.rk-dist-form-grid > * {
    min-width: 0;
}

.rk-dist-field {
    padding-bottom: 22px;
    border-bottom: 1px solid #e2e8f0;
}

.rk-dist-field-compact {
    padding: 0;
    border-bottom: 0;
}

.rk-dist-detail-panel {
    border: 1px solid #dbe4f0;
    border-radius: 18px;
    padding: 22px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    box-shadow: 0 16px 38px rgba(15, 23, 42, 0.06);
    width: 100%;
    overflow: hidden;
}

.rk-dist-detail-grid {
    display: grid;
    gap: 16px;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    align-items: stretch;
    width: 100%;
}

.rk-dist-detail-grid > * {
    min-width: 0;
}

.rk-dist-detail-header {
    margin-bottom: 16px;
}

.rk-dist-detail-header h6 {
    margin: 0 0 6px;
    font-size: 19px;
    font-weight: 700;
    color: #1f2937;
}

.rk-dist-detail-header p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

.rk-dist-field-card {
    height: 100%;
    padding: 16px;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
    min-width: 0;
}

.rk-dist-field-card label {
    margin-bottom: 10px;
}

.rk-dist-field .form-control,
.rk-dist-field .form-select,
.rk-dist-field-card .form-control,
.rk-dist-field-card .form-select {
    width: 100%;
    min-width: 0;
}

.rk-dist-field:last-child {
    padding-bottom: 0;
    border-bottom: 0;
}

@media (max-width: 991.98px) {
    .rk-dist-form-grid {
        grid-template-columns: 1fr;
    }

    .rk-dist-detail-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 575.98px) {
    .rk-dist-detail-panel {
        padding: 18px;
    }

    .rk-dist-field-card {
        padding: 14px;
    }
}

.rk-dist-upload-box {
    display: grid;
    gap: 16px;
}

.rk-dist-upload-dropzone {
    border: 2px dashed #d9e3f0;
    border-radius: 14px;
    padding: 34px 20px 28px;
    text-align: center;
    background: #fff;
}

.rk-dist-upload-graphic {
    color: #64748b;
    margin-bottom: 14px;
}

.rk-dist-upload-dropzone h6 {
    font-size: 17px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 6px;
}

.rk-dist-upload-dropzone p {
    font-size: 14px;
    color: #64748b;
    margin: 0 0 18px;
}

.rk-dist-upload-trigger,
.rk-dist-approve-btn {
    border: 0;
    border-radius: 8px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: opacity .2s ease;
}

.rk-dist-upload-trigger {
    background: #143f78;
    color: #fff;
    padding: 11px 20px;
}

.rk-dist-upload-name {
    font-size: 13px;
    color: #64748b;
    margin-top: 14px;
    word-break: break-word;
}

.rk-approval-file-link {
    display: inline-block;
    margin-top: 8px;
    font-size: 13px;
    color: #143f78;
    text-decoration: none;
}

.rk-approval-file-link:hover {
    text-decoration: underline;
}

.rk-dist-approve-btn {
    width: 100%;
    background: #143f78;
    color: #fff;
    padding: 14px 18px;
}

.rk-dist-approve-btn:disabled {
    opacity: .6;
    cursor: not-allowed;
}

.rk-dist-upload-trigger:hover,
.rk-dist-approve-btn:hover {
    opacity: .92;
}

.rk-dist-upload-trigger:disabled,
.rk-dist-approve-btn:disabled {
    opacity: .6;
    cursor: not-allowed;
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

.rk-lead-avatar {
    width: 52px;
    height: 52px;
    min-width: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #36b37e, #51b7d8);
    border: 2px solid rgba(255, 255, 255, 0.55);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.38), 0 16px 30px rgba(4, 18, 32, 0.28);
}

.rk-overview-kicker,
.rk-overview-subtitle,
.rk-overview-title {
    color: #fff;
}

.rk-overview-kicker {
    color: rgba(255, 255, 255, 0.78);
    font-size: 11px;
    font-weight: 850;
}

.rk-overview-kicker i {
    color: #f6b445;
}

.rk-overview-title {
    font-size: 26px;
    font-weight: 900;
}

.rk-overview-subtitle {
    color: rgba(255, 255, 255, 0.76);
    font-weight: 650;
}

.rk-action-tabs .btn {
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
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.34), 0 12px 26px rgba(23, 105, 170, 0.2);
}

.rk-overview-body {
    grid-template-columns: minmax(0, 2fr) minmax(310px, 1fr);
    gap: 12px;
    align-items: start;
}

.rk-summary-card {
    grid-column: 1;
    grid-row: 1;
}

.rk-notes-card {
    grid-column: 2;
    grid-row: 1;
}

.rk-dist-workflow-card {
    grid-column: 1;
    grid-row: 2;
}

.rk-attachments-card {
    grid-column: 1 / -1;
    grid-row: 2;
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

.rk-notes-header span {
    color: #7a8ea3;
    font-size: 12px;
    font-weight: 800;
}

.rk-summary-content,
.rk-notes-card form,
.rk-notes-list,
.rk-attach-list {
    position: relative;
    z-index: 2;
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

.rk-dist-workflow-card {
    padding: 0;
}

.rk-dist-approval-offcanvas {
    width: min(760px, 100vw) !important;
    border: 0;
    color: #102033;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(247, 252, 255, 0.96)),
        radial-gradient(circle at 12% 0%, rgba(45, 133, 255, 0.18), transparent 28%);
    box-shadow: -24px 0 70px rgba(13, 44, 82, 0.24);
}

.rk-dist-offcanvas-gloss {
    position: absolute;
    inset: 0;
    pointer-events: none;
    background:
        radial-gradient(circle at 12% 4%, rgba(255, 255, 255, 0.92), transparent 16%),
        radial-gradient(circle at 90% 12%, rgba(43, 130, 255, 0.2), transparent 24%),
        linear-gradient(135deg, rgba(22, 105, 170, 0.08), rgba(54, 179, 126, 0.08));
}

.rk-dist-offcanvas-header {
    position: relative;
    align-items: flex-start;
    padding: 28px 30px 24px;
    color: #fff;
    background: linear-gradient(135deg, #0b376d 0%, #1769aa 48%, #16a085 100%);
    box-shadow: 0 16px 34px rgba(23, 105, 170, 0.22);
}

.rk-dist-offcanvas-header:after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(120deg, rgba(255, 255, 255, 0.22), transparent 34%),
        radial-gradient(circle at 88% 18%, rgba(255, 214, 102, 0.28), transparent 24%);
    pointer-events: none;
}

.rk-dist-offcanvas-header > *,
.rk-dist-offcanvas-body {
    position: relative;
    z-index: 1;
}

.rk-dist-offcanvas-kicker {
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

.rk-dist-offcanvas-header h5 {
    margin: 0;
    color: #fff;
    font-size: 24px;
    font-weight: 800;
}

.rk-dist-offcanvas-header p {
    margin: 7px 0 0;
    max-width: 490px;
    color: rgba(255, 255, 255, 0.76);
    font-size: 13px;
}

.rk-dist-offcanvas-close {
    filter: invert(1) grayscale(1) brightness(2);
    opacity: 0.9;
}

.rk-dist-offcanvas-body {
    padding: 24px 30px;
}

.rk-dist-approval-card {
    margin: 0;
    border: 0;
    background: transparent;
    box-shadow: none;
}

.rk-dist-approval-header {
    margin: -18px -18px 16px;
    padding: 18px;
    background: linear-gradient(135deg, rgba(23, 105, 170, 0.12), rgba(54, 179, 126, 0.1));
}

.rk-dist-approval-title {
    color: #102033;
}

.rk-dist-approval-steps,
.rk-dist-approval-info,
.rk-dist-detail-panel,
.rk-dist-upload-dropzone {
    border: 1px solid rgba(23, 105, 170, 0.12);
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.88), rgba(248, 252, 255, 0.92));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9), 0 12px 26px rgba(16, 32, 51, 0.06);
}

.rk-dist-step.active,
.rk-dist-approve-btn,
.rk-dist-upload-trigger {
    background: linear-gradient(135deg, #1769aa, #36b37e);
    color: #fff;
    box-shadow: 0 12px 24px rgba(23, 105, 170, 0.18);
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
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #102033;
    font-weight: 750;
}

@media (max-width: 768px) {
    .rk-overview-body,
    .rk-summary-card,
    .rk-notes-card,
    .rk-dist-workflow-card,
    .rk-attachments-card {
        grid-column: 1;
        grid-row: auto;
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
$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
$leadName = trim(($lead->first_name ?? '').' '.($lead->last_name ?? '')) ?: 'Lead';
$leadInitial = strtoupper(substr(trim($lead->first_name ?: $lead->last_name ?: $leadName), 0, 1));
$canApplyApproval = $currentStatus === 'Not Applied';
$canUploadApproval = $currentStatus === 'Awaiting Approval';
$defaultApprovalPane = $canUploadApproval ? 'upload' : 'apply';
$approvalRequiredValue = $leadMeta['distributor_approval_required'] ?? 'Yes';
$distributorNameValue = $leadMeta['distributor_name'] ?? '';
$existingSystemValue = $leadMeta['existing_system'] ?? '';
$meterNumberValue = $leadMeta['meter_number'] ?? '';
$nmiNumberValue = $leadMeta['nmi_number'] ?? '';
$photosRequiredValue = $leadMeta['photos_required'] ?? '';
$approvalFileUrl = $leadMeta['distributor_approval_file'] ?? '';
$approvalFileName = $approvalFileUrl ? basename(parse_url($approvalFileUrl, PHP_URL_PATH)) : 'No file selected';
@endphp

@php
$stages = array_values(array_unique([
    'Not Applied',
    'Awaiting Approval',
    $currentStatus
]));
@endphp

<div class="rk-overview-wrapper">

    <!-- header -->
    <div class="rk-overview-header">
        <div class="rk-overview-title-wrap">
            <span class="rk-lead-avatar">{{ $leadInitial }}</span>
            <div>
                <span class="rk-overview-kicker"><i class="ph ph-plugs-connected"></i> Distributor approval</span>
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


            <button data-lead='@json($lead)' class="btn btn-outline-danger edit_lead" data-lead='@json($lead)'
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

            <button type="button" class="btn btn-outline-info" data-bs-toggle="offcanvas"
                data-bs-target="#distributorApprovalOffcanvas" aria-controls="distributorApprovalOffcanvas">
                <i class="ph ph-plugs-connected"></i> Distributor Approval
            </button>

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
            <span class="rk-lifecycle-value"><i class="ph ph-circle-wavy-check"></i> {{ $currentStatus }}</span>
        </div>

        <!-- ✅ HUBSPOT PIPELINE -->
        <div class="rk-pipeline">
            @foreach($stages as $stage)
            <div class="rk-stage {{ $currentStatus == $stage ? 'active' : '' }}"
                onclick="changeLeadStatus('{{ $stage }}')">
                {{ $stage }}
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
            <div class="rk-files-card rk-attachments-card">
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
@include('admin.leads._email_modal',['emailTemplates'=>$emailTemplates])
@include('super.leads._edit_modal')
@include('admin.leads.call_logs')

<div class="offcanvas offcanvas-end rk-dist-approval-offcanvas" id="distributorApprovalOffcanvas" tabindex="-1"
    aria-labelledby="distributorApprovalOffcanvasLabel">
    <div class="rk-dist-offcanvas-gloss"></div>
    <div class="offcanvas-header rk-dist-offcanvas-header">
        <div>
            <span class="rk-dist-offcanvas-kicker"><i class="ph ph-plugs-connected"></i> Workflow</span>
            <h5 class="offcanvas-title" id="distributorApprovalOffcanvasLabel">Distributor Approval</h5>
            <p>Manage approval details and upload distributor documents for Job #{{ $lead->id }}.</p>
        </div>
        <button type="button" class="btn-close rk-dist-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body rk-dist-offcanvas-body">
        @include('super.leads.dist._distributor_approval_card')
    </div>
</div>



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
    const applyButtonHtml = $('#applyApprovalBtn').html();
    const uploadButtonHtml = $('#uploadApprovalBtn').html();

    function saveDistributorApprovalMeta(options) {
        return $.ajax({
            url: '{{ route("superadmin.saveDistributorApprovalMeta") }}',
            type: 'POST',
            data: options.formData,
            processData: false,
            contentType: false
        });
    }

    $('.rk-dist-step').on('click', function() {
        if ($(this).is(':disabled')) {
            return;
        }

        const target = $(this).data('target');

        $('.rk-dist-step').removeClass('active');
        $(this).addClass('active');

        $('.rk-dist-pane').removeClass('active');
        $('.rk-dist-pane[data-pane="' + target + '"]').addClass('active');
    });

    function toggleDistributorField() {
        if ($('#approvalRequired').val() === 'Yes') {
            $('#distributorField').show();
        } else {
            $('#distributorField').hide();
            $('#distributorName').val('');
        }

        toggleDistributorDetailsPanel();
    }

    function toggleDistributorDetailsPanel() {
        const shouldShow = $('#approvalRequired').val() === 'Yes' && !!$('#distributorName').val();

        if (shouldShow) {
            $('#distributorDetailsPanel').stop(true, true).slideDown(180);
        } else {
            $('#distributorDetailsPanel').stop(true, true).slideUp(180);
            $('#meterNumber').val('');
            $('#nmiNumber').val('');
            $('#photosRequired').val('');
        }
    }

    toggleDistributorField();

    $('#approvalRequired').on('change', function() {
        toggleDistributorField();
    });

    $('#distributorName').on('change', function() {
        toggleDistributorDetailsPanel();
    });

    $('#applyApprovalBtn').on('click', function() {
        if ($(this).is(':disabled')) {
            return;
        }

        if ($('#approvalRequired').val() === 'Yes' && !$('#distributorName').val()) {
            alert('Please select distributor.');
            return;
        }

        if (!$('#existingSystem').val()) {
            alert('Please select existing system option.');
            return;
        }

        if ($('#approvalRequired').val() === 'Yes' && $('#distributorName').val()) {
            if (!$('#meterNumber').val().trim()) {
                alert('Please enter meter number.');
                return;
            }

            if (!$('#nmiNumber').val().trim()) {
                alert('Please enter NMI number.');
                return;
            }

            if (!$('#photosRequired').val()) {
                alert('Please select if photos are required.');
                return;
            }
        }

        const nextStatus = $('#approvalRequired').val() === 'No'
            ? 'VIC REBATE NOT APPLIED'
            : 'Awaiting Approval';

        let formData = new FormData();
        formData.append('lead_id', leadId);
        formData.append('approval_required', $('#approvalRequired').val());
        formData.append('distributor_name', $('#distributorName').val() || '');
        formData.append('existing_system', $('#existingSystem').val());
        formData.append('meter_number', $('#meterNumber').val().trim());
        formData.append('nmi_number', $('#nmiNumber').val().trim());
        formData.append('photos_required', $('#photosRequired').val() || '');
        formData.append('status', nextStatus);
        formData.append('_token', '{{ csrf_token() }}');

        $('#applyApprovalBtn').prop('disabled', true).text('Saving...');

        saveDistributorApprovalMeta({ formData: formData })
            .done(function() {
                location.reload();
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to save distributor approval data.');
                $('#applyApprovalBtn').prop('disabled', false).html(applyButtonHtml);
            });
    });

    $('#chooseApprovalFileBtn').on('click', function() {
        $('#approvalFileInput').click();
    });

    $('#approvalFileInput').on('change', function() {
        const fileName = this.files && this.files[0] ? this.files[0].name : 'No file selected';
        $('#approvalFileName').text(fileName);
    });

    $('#uploadApprovalBtn').on('click', function() {
        let file = $('#approvalFileInput')[0].files[0];

        if (!file) {
            alert('Please select a file first.');
            return;
        }

        const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Only PDF, PNG, and JPG files are allowed.');
            return;
        }

        if (file.size > 10 * 1024 * 1024) {
            alert('File size must be 10MB or less.');
            return;
        }

        if (!$('#existingSystem').val()) {
            alert('Please select existing system option.');
            return;
        }

        if ($('#approvalRequired').val() === 'Yes' && !$('#distributorName').val()) {
            alert('Please select distributor.');
            return;
        }

        $('#uploadApprovalBtn').prop('disabled', true).text('Uploading...');

        let formData = new FormData();
        formData.append('approval_file', file);
        formData.append('lead_id', leadId);
        formData.append('approval_required', $('#approvalRequired').val());
        formData.append('distributor_name', $('#distributorName').val() || '');
        formData.append('existing_system', $('#existingSystem').val());
        formData.append('meter_number', $('#meterNumber').val().trim());
        formData.append('nmi_number', $('#nmiNumber').val().trim());
        formData.append('photos_required', $('#photosRequired').val() || '');
        formData.append('status', 'VIC REBATE NOT APPLIED');
        formData.append('_token', '{{ csrf_token() }}');

        saveDistributorApprovalMeta({ formData: formData })
            .done(function() {
                location.reload();
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Approval upload failed!');
                $('#uploadApprovalBtn').prop('disabled', false).html(uploadButtonHtml);
            });
    });

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
