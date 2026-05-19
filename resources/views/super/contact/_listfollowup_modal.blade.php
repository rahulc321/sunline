<div class="modal-body" style="max-height: 600px; overflow-y: auto;">


<!-- Upcoming Follow-ups -->
<h6 class="mb-2">
    <i class="bi bi-clock-history me-1"></i> Upcoming Follow-ups ({{ $upcoming->count() ?? 0}})
</h6>


@forelse($upcoming as $f)
<?php
//echo '<pre>'; print_r($f->lead->lead);die;
?>
<div class="card mb-2 shadow-sm {{ $f->is_overdue ? 'border-danger' : 'border-success' }}">
    <div class="card-body d-flex justify-content-between align-items-start">
        <div>
            <strong>{{ @$f->lead->lead->first_name }} {{ @$f->lead->lead->first_name }}</strong><br>
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


</div>