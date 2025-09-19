@extends('layouts.admin')
@section('content')

<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Notifications
            </h4>
        </div>
    </div>
</div>

<div class="content pt-0">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover datatable text-wrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th>Received At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $notifications = auth()->user()
                          ->notifications()
                          ->orderBy('id', 'desc') // newest first
                          ->get();
                                ?>
                                @foreach($notifications as $key => $notification)
                                <tr data-entry-id="{{ $notification->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $notification->data['title'] ?? '' }}</td>
                                    <td>{{ $notification->data['message'] ?? '' }}</td>
                                    <td>
                                        <a href="{{ $notification->data['url'] ?? '#' }}">
                                            {{ $notification->data['url'] ?? '#' }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($notification->read_at)
                                            <span class="badge bg-success">Read</span>
                                        @else
                                            <span class="badge bg-warning">Unread</span>
                                        @endif
                                    </td>
                                    <td>{{ $notification->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
$(function() {
    $.extend(true, $.fn.dataTable.defaults, {
       
        pageLength: 10,
    });
    $('.datatable').DataTable();
})
</script>
@endsection
