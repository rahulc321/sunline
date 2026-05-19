@extends('layouts.admin')
@section('title', "Create Tier")
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Create Tier
            </h4>

            <a href="#page_header"
                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>


    </div>
</div>
<div class="content pt-0">

    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card form_1">

                <div class="card-body">
                    <form action="{{ route('admin.tier.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label class="form-label">Min Value</label>
                                <input type="number" name="min_value" class="form-control" placeholder="Enter min value"
                                    required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Max Value</label>
                                <input type="number" name="max_value" class="form-control" placeholder="Enter max value"
                                    required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tier Name</label>
                                <input type="text" name="tier_name" class="form-control" placeholder="Enter tier name"
                                    required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Commission (₹)</label>
                                <input type="number" step="0.01" name="commission" class="form-control"
                                    placeholder="Enter commission" required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="solar">Solar</option>
                                    <option value="battery">Battery</option>
                                </select>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Add</button>
                            </div>
                        </div>
                    </form>




                </div>
            </div>
        </div>
    </div>
</div>
@endsection