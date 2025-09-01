<div class="modal fade" id="replyModel" tabindex="-1" aria-labelledby="replyModel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header py-2">
                <h5 class="modal-title fw-bold" id="replyModelLabel">
                    <i class="ph-chat-centered-text me-2"></i> RFI Response
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
                <input type="hidden" name="type" value="rfi">

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

<script>
    function loadReplies(ticketId) {
        var currentUser = "{{Auth::id()}}";
        $.ajax({
            url: '/admin/ticketsRepliesList/' + ticketId,
            method: 'GET',
            data:{'type':'rfi'},
            success: function(res) {
                let repliesHtml = '';

                if (res.length) {
                    res.forEach(r => {
                        let attachmentHtml = '';

                        if (r.attachment) {
                            let ext = r.attachment.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                                // image clickable
                                attachmentHtml = `
                                                    <a href="/${r.attachment}" target="_blank">
                                                        <img src="/${r.attachment}" class="img-fluid rounded mt-1" style="max-width:200px;">
                                                    </a>
                                                `;
                            } else if (['mp4', 'webm', 'ogg'].includes(ext)) {
                                // video
                                attachmentHtml = `
                                                    <video controls class="rounded mt-1" style="max-width:200px;">
                                                        <source src="/${r.attachment}" type="video/${ext}">
                                                    </video>
                                                `;
                            } else if (['pdf'].includes(ext)) {
                                attachmentHtml = `
                                                    <a href="/${r.attachment}" target="_blank" class="d-block mt-1">
                                                        <i class="ph-file-pdf me-1"></i> View PDF
                                                    </a>
                                                `;
                            } else {
                                attachmentHtml = `
                                                    <a href="/${r.attachment}" target="_blank" class="d-block mt-1">
                                                        <i class="ph-file me-1"></i> Download File
                                                    </a>
                                                `;
                            }
                        }


                        // bubble HTML
                        let bubbleHtml = `
                        ${r.reply ? `<p class="mb-1">${r.reply}</p>` : ''}
                        ${attachmentHtml}
                        <div class="small mt-1 text-${r.user_id == currentUser ? 'light' : 'muted'}">
                            ${r.created_at_formatted}
                        </div>
                    `;

                        if (r.user_id == currentUser) {
                            repliesHtml += `
                            <div class="d-flex justify-content-end mb-2">
                                <div class="p-2 rounded bg-primary text-white small bg_s" style="max-width:75%;">
                                    ${bubbleHtml}
                                </div>
                            </div>
                        `;
                        } else {
                            repliesHtml += `
                            <div class="d-flex mb-2">
                                <div class="p-2 rounded bg-light text-dark small" style="max-width:75%;">
                                    <strong><i class="ph-user me-2"></i>${r.user?.name}</strong>
                                    ${bubbleHtml}
                                </div>
                            </div>
                        `;
                        }
                    });
                } else {
                    repliesHtml = `<p class="text-muted">No replies yet.</p>`;
                }

                $('#repliesContainer').html(repliesHtml);
                $("#repliesContainer").scrollTop($("#repliesContainer")[0].scrollHeight);
            }
        });
    }


    // open modal + load replies
    $(document).on('click', '.reply', function() {
        let ticketId = $(this).data('id');
        $('#reply_ticket_id').val(ticketId);
        loadReplies(ticketId);
    });

    // submit reply
    $('#replyForm').on('submit', function(e) {
        e.preventDefault();

        let ticketId = $('#reply_ticket_id').val();
        let formData = new FormData(this); // includes message + attachment + CSRF token

        $.ajax({
            url: '/admin/ticketsReplies/' + ticketId,
            method: 'POST',
            data: formData,
            contentType: false, // important for file upload
            processData: false, // important for file upload
            success: function(res) {
                $('#reply_message').val(''); // clear textarea
                $('#reply_attachment').val(''); // clear file input
                loadReplies(ticketId); // reload replies
            },
            error: function(err) {
                console.error(err);
                alert('Failed to send reply');
            }
        });
    });
</script>