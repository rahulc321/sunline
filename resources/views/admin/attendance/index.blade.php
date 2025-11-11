@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h3>All Users Attendance ({{ \Carbon\Carbon::parse($month)->format('F Y') }})</h3>

    <!-- Month Selector -->
    <form method="GET" class="mb-3">
        <div class="d-flex align-items-center gap-2">
            <input type="month" name="month" value="{{ $month }}" class="form-control w-auto">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered" id="jsGrid1">
        <thead>
            <tr>
                <th>User</th>
                @for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay())
                <th>{{ $date->format('d') }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $userData)
            <tr>
                <td><strong>{{ $userData['user']->name }}</strong></td>

                @foreach ($userData['days'] as $day)
                @php
                $textClass = match($day['status']) {
                'P' => 'text-success',
                'SP' => 'text-warning',
                default => 'text-danger',
                };
                @endphp
                <td class="text-center   {{ $textClass }}">
                    {{ $day['status'] }}
                </td>
                @endforeach

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection