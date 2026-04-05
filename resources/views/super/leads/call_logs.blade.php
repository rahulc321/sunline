<div class="modal fade" id="leadDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content rk-call-modal">

            <!-- header -->
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold">Call Logs</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- body -->
            <div class="modal-body pt-2">

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
    </div>
</div>
<style>
    /* modal */
.rk-call-modal {
    border-radius: 10px;
}

/* scroll */
.call-logs {
    max-height: 340px;
    overflow-y: auto;
}

/* grey rounded card */
.rk-call-card {
    background: #e9edf5;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
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

.log-item {
    background: #e8edf9;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}


</style>