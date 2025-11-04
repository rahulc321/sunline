@extends('layouts.admin')
@section('title', "Edit Tier")

@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">Edit Tier</h4>

            <a href="#page_header"
                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="content pt-0">
    <div class="row">
        <div class="col-xl-12">
            <div class="card form_1">
                <div class="card-body">
                    {{-- Update form --}}
                    <form action="{{ route('admin.tier.update', $edit->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label class="form-label">Min Value</label>
                                <input type="number" name="min_value" class="form-control"
                                    value="{{ old('min_value', $edit->min_value) }}" placeholder="Enter min value"
                                    required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Max Value</label>
                                <input type="number" name="max_value" class="form-control"
                                    value="{{ old('max_value', $edit->max_value) }}" placeholder="Enter max value"
                                    required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tier Name</label>
                                <input type="text" name="tier_name" class="form-control"
                                    value="{{ old('tier_name', $edit->tier_name) }}" placeholder="Enter tier name"
                                    required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Commission (₹)</label>
                                <input type="number" step="0.01" name="commission" class="form-control"
                                    value="{{ old('commission', $edit->commission) }}" placeholder="Enter commission"
                                    required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="solar" {{ old('category', $edit->category) == 'solar' ? 'selected' : '' }}>Solar</option>
                                    <option value="battery" {{ old('category', $edit->category) == 'battery' ? 'selected' : '' }}>Battery</option>
                                </select>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Update</button>
                            </div>
                        </div>
                    </form>
                    {{-- /Update form --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
