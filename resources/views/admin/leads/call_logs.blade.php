<div class="offcanvas offcanvas-end rk-call-offcanvas" id="leadDetailsModal" tabindex="-1" aria-labelledby="leadDetailsModalLabel">

            <!-- header -->
            <div class="offcanvas-header rk-call-header">
                <div>
                    <span class="rk-call-kicker"><i class="ph ph-phone-call"></i> Lead activity</span>
                    <h6 class="offcanvas-title fw-bold" id="leadDetailsModalLabel">Call Logs</h6>
                </div>
                <button type="button" class="btn-close rk-call-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <!-- body -->
            <div class="offcanvas-body rk-call-body">

                <div class="call-logs">

                    <!-- call item -->
                    <div class="rk-call-card">
                        <div class="rk-call-left">
                            <span class="rk-call-icon">📞</span>

                            <div>
                                <div class="rk-call-time">
                                    <strong>02/10/2025, 10:55:43</strong>
                                    <span class="rk-duration">0:24 min</span>
                                </div>

                                <div class="rk-call-type">
                                    Outbound • +61484680684
                                </div>
                            </div>
                        </div>

                        <button class="btn rk-play-btn">
                            🎵 Play
                        </button>
                    </div>

                    <!-- repeat dynamically -->
                    <div class="call-logs-list"></div>

                </div>

            </div>
</div>
<style>
.rk-call-offcanvas {
    width: min(520px, 100vw) !important;
    border: 0;
    background:
        radial-gradient(circle at 12% 0%, rgba(47, 128, 237, .18), transparent 30%),
        linear-gradient(180deg, #ffffff 0%, #f6fbff 100%);
    box-shadow: -20px 0 60px rgba(15, 23, 42, .22);
}

.rk-call-header {
    align-items: flex-start;
    padding: 22px;
    border: 0;
    background: linear-gradient(135deg, #0b376d, #1769aa 55%, #16a085);
    color: #fff;
}

.rk-call-kicker {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 7px;
    color: rgba(255, 255, 255, .72);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-call-header h6 {
    margin: 0;
    color: #fff;
    font-size: 20px;
}

.rk-call-close {
    filter: invert(1) grayscale(1) brightness(2);
    opacity: .9;
}

.rk-call-body {
    padding: 20px;
}

.rk-call-empty {
    border: 1px dashed rgba(47, 128, 237, .24);
    background: rgba(255, 255, 255, .72);
    border-radius: 10px;
    padding: 18px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
}

/* scroll */
.call-logs {
    max-height: none;
    overflow-y: auto;
}

/* grey rounded card */
.rk-call-card {
    border: 1px solid rgba(47, 128, 237, .12);
    background:
        linear-gradient(145deg, rgba(255, 255, 255, .95), rgba(239, 248, 255, .88));
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 12px 26px rgba(15, 23, 42, .08);
}

/* left side */
.rk-call-left {
    display: flex;
    gap: 10px;
    align-items: flex-start;
}

/* phone icon */
.rk-call-icon {
    font-size: 16px;
    color: #6c757d;
    margin-top: 2px;
}

/* time text */
.rk-call-time {
    font-size: 13px;
    color: #2c3e50;
}

.rk-duration {
    color: #6c757d;
    margin-left: 6px;
    font-weight: 500;
}

/* outbound text */
.rk-call-type {
    font-size: 13px;
    color: #00a3c8;
    font-weight: 500;
}

/* play button */
.rk-play-btn {
    background: #fff;
    border: 1px solid #2f80ed;
    color: #2f80ed;
    font-size: 12px;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 600;
    transition: 0.2s;
}

.rk-play-btn:hover {
    background: #2f80ed;
    color: #fff;
}

.rk-play-btn:disabled,
.rk-play-btn:disabled:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
    color: #94a3b8;
}

.log-item {
    background: #e8edf9;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}


</style>
