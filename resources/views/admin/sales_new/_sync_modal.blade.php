<div class="modal fade" id="syncModel" tabindex="-1" aria-labelledby="syncModel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="popupFormLabel">Webhook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Start form -->
            <form action="{{ route('admin.triggerwebhook') }}" method="post">
                @csrf
                <input type="hidden" name="lead_id" class="lead_id">

                <div class="modal-body">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
