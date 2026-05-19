<div class="modal fade" id="replyModel" tabindex="-1" aria-labelledby="replyModel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header py-2">
                <h5 class="modal-title fw-bold" id="replyModelLabel">
                    <i class="ph-chat-centered-text me-2"></i> Ticket Reply
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body py-3">
                <!-- Dynamic replies will load here -->
                <div id="repliesContainer" style="max-height:300px; overflow-y:auto;">
                    <p class="text-muted">Loading messages...</p>
                </div>
            </div>

            <!-- Reply form -->
            <form id="replyForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ticket_id" id="reply_ticket_id">

                <div class="modal-footer py-2 flex-column">

                    <!-- Row: attachment icon + textarea + send button -->
                    <div class="d-flex align-items-center w-100 mb-2">
                        <!-- Attachment icon -->
                        <label for="reply_attachment" class="me-2 mb-0" style="cursor:pointer;">
                            <i class="ph-paperclip fs-5 text-secondary"></i>
                            <!-- you can use ph-image if you prefer image icon -->
                        </label>
                        <input type="file" name="attachment" id="reply_attachment" class="d-none" accept="image/*">

                        <!-- Textarea -->
                        <textarea id="reply_message" name="message" class="form-control form-control-sm flex-grow-1"
                            rows="2" placeholder="Type your reply..." required></textarea>

                        <!-- Send button -->
                        <button type="submit" class="btn btn-primary btn-sm ms-2 bg_s">
                            <i class="ph-paper-plane"></i> Send
                        </button>
                    </div>

                </div>
            </form>


        </div>
    </div>
</div>