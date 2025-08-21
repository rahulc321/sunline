<div class="modal fade" id="followUpModal" tabindex="-1" aria-labelledby="followUpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="followUpLabel">
                    Follow-up Management

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" style="max-height: 600px; overflow-y: auto;">


                <!-- Upcoming Follow-ups -->
                <h6 class="mb-2">
                    <i class="bi bi-clock-history me-1"></i> Upcoming Follow-ups ({{ $upcoming->count() ?? 0}})
                </h6>
                @forelse($upcoming as $f)
                <div class="card mb-2 shadow-sm {{ $f->is_overdue ? 'border-danger' : 'border-success' }}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $f->lead->first_name }} {{ $f->lead->last_name }}</strong><br>
                            <span class="badge bg-light text-dark me-2">{{ ucfirst($f->type) }}</span>
                            <span class="{{ $f->is_overdue ? 'text-danger' : '' }}">
                                {{ $f->date }}
                            </span>
                            @if($f->is_overdue)
                            <span class="badge bg-danger ms-2">Overdue</span>
                            @endif
                            <p class="mb-1 small text-muted">{{ $f->notes }}</p>
                        </div>
                        @if(!$f->is_overdue)
                        <button class="btn btn-outline-secondary btn-sm mark_complete" data-id="{{$f->id}}">Mark
                            Complete</button>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-muted">No upcoming follow-ups.</p>
                @endforelse

                <!-- <div class="card mb-3 shadow-sm border-danger">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger me-2">Email</span>
                                <span class="fw-bold text-danger">2025-08-07 at 09:00</span>
                                <span class="badge bg-danger ms-2">Overdue</span>
                                <p class="mb-1 small text-muted">Send follow-up email with proposal details</p>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm">Mark Complete</button>
                        </div>
                    </div> -->

                <!-- Past Follow-ups -->
                <h6 class="mb-2">
                    <i class="bi bi-check2-circle me-1"></i> Past Follow-ups ({{ $past->count() ?? 0 }})
                </h6>

                @forelse($past as $f)
                <div class="card shadow-sm border-info">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $f->lead->first_name }} {{ $f->lead->last_name }}</strong><br>
                            <span class="badge bg-info text-dark me-2">{{ ucfirst($f->type) }}</span>
                            <span class="">{{ $f->date }}</span>
                            <span class="badge bg-success ms-2">Completed</span>
                            <p class="mb-1 small text-muted">{{ $f->notes }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">No past follow-ups.</p>
                @endforelse


            </div><!-- End modal body -->

        </div>
    </div>
</div>
<script>
$(document).on('click', '.mark_complete', function() {
    let followUpId = $(this).data('id');

    if (!confirm("Are you sure you want to mark this follow-up as complete?")) {
        return;
    }

    $.ajax({
        url: "{{ route('admin.followupComplete') }}", // create this route
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: followUpId
        },
        success: function(res) {
            if (res.success) {
                // update UI (for example change button to Completed)
                $(`button.mark_complete[data-id="${followUpId}"]`)
                    .replaceWith('<span class="badge bg-success">Completed</span>');
            } else {
                alert("Something went wrong.");
            }
        },
        error: function() {
            alert("Server error, please try again.");
        }
    });
});
</script>