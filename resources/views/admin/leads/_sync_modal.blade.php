<div class="offcanvas offcanvas-end rk-lead-form-offcanvas rk-sync-offcanvas" id="syncModel" tabindex="-1" aria-labelledby="popupFormLabel">

            <div class="offcanvas-header rk-lead-form-header">
                <div>
                    <span class="rk-lead-form-kicker">Integration</span>
                    <h5 class="offcanvas-title modal-title" id="popupFormLabel">Webhook</h5>
                </div>
                <button type="button" class="btn-close rk-lead-form-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <!-- Start form -->
            <form action="{{ route('admin.triggerwebhook') }}" method="post" class="rk-lead-form">
                @csrf
                <input type="hidden" name="lead_id" class="lead_id">

                <div class="offcanvas-body rk-lead-form-body">
                    <div class="mb-3">
                        <?php $webhooks = DB::table('webhooks')
                            ->where('status', 'Active')
                            ->get();

                            ?>
                        <label for="webhook_id" class="form-labelq fw-bold">Select Webhook</label>
                        <select name="webhook_id" id="webhook_id" class="form-select" required>
                            <option value="">-- Select Active Webhook --</option>
                            @foreach($webhooks as $webhook)
                                <option value="{{ $webhook->id }}">{{ $webhook->name ?? 'Webhook #'.$webhook->id }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Footer inside the form -->
                <div class="rk-lead-form-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

</div>
