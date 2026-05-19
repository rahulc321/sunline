@extends('layouts.admin')
@section('title', "Edit Webhook")
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Edit Webhook
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
                    <form id="apiForm" class="row g-3" action="{{ route('admin.updateWebhook', $webhook->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label for="name" class="form-label1 fw-bold">Webhook Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Webhook Name"
                                value="{{ old('name', $webhook->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="method" class="form-label1 fw-bold">Method</label>
                            <select class="form-select" name="method" id="method">
                                <option value="GET" {{ $webhook->method == 'GET' ? 'selected' : '' }}>GET</option>
                                <option value="POST" {{ $webhook->method == 'POST' ? 'selected' : '' }}>POST</option>
                                <option value="PUT" {{ $webhook->method == 'PUT' ? 'selected' : '' }}>PUT</option>
                                <option value="DELETE" {{ $webhook->method == 'DELETE' ? 'selected' : '' }}>DELETE
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label1 fw-bold">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="Active" {{ $webhook->status == 'Active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="In-Active" {{ $webhook->status == 'In-Active' ? 'selected' : '' }}>
                                    In-Active</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="url" class="form-label1 fw-bold">URL</label>
                            <input type="text" class="form-control" id="url" name="url"
                                placeholder="https://example.com/api/v1/getToken"
                                value="{{ old('url', $webhook->url) }}" required>
                        </div>

                        <div class="col-12">
                            <label for="bearer_token" class="form-label1 fw-bold">Bearer Token</label>
                            <input type="text" class="form-control" id="bearer_token" name="bearer_token"
                                placeholder="Paste token here"
                                value="{{ old('bearer_token', $webhook->bearer_token) }}">
                        </div>

                        <div class="col-12">
                            <label for="body" class="form-label1 fw-bold">Body (JSON)</label>
                            <textarea class="form-control mb-3" id="body" name="body"
                                rows="6">{{ json_encode(json_decode($webhook->body, true), JSON_PRETTY_PRINT) }}</textarea>

                            <div class="row">
                                <!-- Left: Payload JSON preview -->
                                 

                                <!-- Right: Lead table columns -->
                                <div class="col-md-6">
                                    <div class="card border shadow-sm">
                                        <div class="card-header bg-light fw-bold">
                                            Lead Table Fields
                                        </div>
                                        <div class="card-body" style="max-height:300px; overflow-y:auto;">
                                            <ul class="list-group list-group-flush">
                                            <?php $leadColumns = \Schema::getColumnListing('leads');?>
                                                @foreach($leadColumns as $col)
                                                <li class="list-group-item">
                                                    <i class="ph-database text-secondary me-2"></i>
                                                    {{ $col }}
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4" id="sendBtn">
                                <span id="btnText">Update</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection