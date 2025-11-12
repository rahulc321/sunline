@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">Settings</h4>
        </div>
    </div>
</div>

<div class="content pt-0">
    <div class="card form_1">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Heatpump Commission (₹)</label>
                        <input type="number" step="0.01" name="heatpump_commission"
                            class="form-control" value="{{ $settings['heatpump_commission'] }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Aircon Commission (₹)</label>
                        <input type="number" step="0.01" name="aircon_commission"
                            class="form-control" value="{{ $settings['aircon_commission'] }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Office Ip Address</label>
                        <input type="text"  name="office_ip_address"
                            class="form-control" value="{{ @$settings['office_ip_address'] }}" >
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <br>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
