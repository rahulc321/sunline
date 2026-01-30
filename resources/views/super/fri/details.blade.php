@extends('layouts.admin')

@section('title', "Fri Details")

@section('content')
<div class="card p-3">
    <div class="d-flex justify-content-between align-items-start">
        
        <!-- Left section -->
        <div>
            <!-- Title -->
            <h5 class="fw-bold mb-2">
                <i class="ph-file-text me-1"></i>
                RFI-{{ str_pad($fri->id, 4, '0', STR_PAD_LEFT) }} - {{ $fri->subject }}
            </h5>

            <!-- Badges -->
            <div class="mb-2">
                <span class="badge bg-warning text-dark">{{ $fri->status ?? 'Pending' }}</span>
                <span class="badge bg-danger">{{ $fri->priority ?? 'Normal' }}</span>
                <span class="badge bg-info text-dark">{{ $fri->type ?? 'General' }}</span>
                
                @if(\Carbon\Carbon::parse($fri->due_date)->isPast())
                    <span class="badge bg-danger"><i class="ph-warning me-1"></i> Overdue</span>
                @endif
            </div>

            <!-- Meta Info -->
            <div class="small text-muted">
                <span class="me-3"><i class="ph-briefcase me-1"></i> Project: 
                    <strong>{{ $fri->project }}</strong></span>
                <span class="me-3"><i class="ph-user me-1"></i> Client: 
                    <strong>{{ $fri->client }}</strong></span>
                <span class="me-3"><i class="ph-user-circle me-1"></i> Created by: 
                    <strong>{{ $fri->user->name ?? 'Unknown' }}</strong></span>
                <span><i class="ph-calendar me-1"></i> Due: 
                    <strong class="{{ \Carbon\Carbon::parse($fri->due_date)->isPast() ? 'text-danger' : '' }}">
                        {{ \Carbon\Carbon::parse($fri->due_date)->format('Y-m-d') }}
                    </strong>
                </span>
            </div>
        </div>

        <!-- Right section -->
        <div>
            <a href="" class="btn btn-outline-primary btn-sm me-2">
                <i class="ph-pencil"></i> Edit
            </a>
            
            <!-- Dropdown for status -->
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $fri->status }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Pending</a></li>
                    <li><a class="dropdown-item" href="#">In Progress</a></li>
                    <li><a class="dropdown-item" href="#">Completed</a></li>
                </ul>
            </div>
        </div>
    </div>

    <hr>

    <!-- Description -->
    <p>{{ $fri->description }}</p>

    <!-- Attachments -->
    <h6>Attachments ({{ $fri->images->count() }})</h6>
    <ul class="list-unstyled">
        @foreach($fri->images as $img)
            <li><i class="ph-paperclip me-1"></i> 
                <a href="{{ asset('storage/'.$img->file_path) }}" target="_blank">{{ basename($img->file_path) }}</a>
            </li>
        @endforeach
    </ul>

    <!-- Responses -->
    <h6>Responses (0)</h6>
    @foreach($fri->responses as $res)
        <div class="border rounded p-2 mb-2">
            <strong>{{ $res->user->name ?? 'Unknown' }}</strong> 
            <span class="text-muted small">{{ $res->created_at->format('Y-m-d H:i') }}</span>
            <p class="mb-0">{{ $res->message }}</p>
        </div>
    @endforeach
</div>
@endsection
