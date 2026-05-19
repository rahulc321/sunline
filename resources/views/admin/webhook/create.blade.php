@extends('layouts.admin')
@section('title', "Create Webhook")
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Create Webhook
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
                    <form id="apiForm" class="row g-3" action="{{route('admin.storeWebhook')}}">
                        @csrf

                        <div class="col-md-6">
                            <label for="url" class="form-label1 fw-bold">Webhook Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Webhook Name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="method" class="form-label1 fw-bold">Method</label>
                            <select class="form-select" name="method" id="method">
                                <option>GET</option>
                                <option>POST</option>
                                <option>PUT</option>
                                <option>DELETE</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="method" class="form-label1 fw-bold">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="Active">Active</option>
                                <option value="In-Active">In-Active</option>

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="url" class="form-label1 fw-bold">URL</label>
                            <input type="text" class="form-control" id="url" name="url"
                                placeholder="https://example.com/api/v1/getToken" required>
                        </div>

                        <div class="col-12">
                            <label for="bearer_token" class="form-label1 fw-bold">Bearer Token</label>
                            <input type="text" class="form-control" id="bearer_token" name="bearer_token"
                                placeholder="Paste token here">
                        </div>

                        <div class="col-12">
                            <label for="body" class="form-label1 fw-bold">Body (JSON)</label>
                            <textarea class="form-control mb-3" id="body" name="body"
                                rows="6">{}</textarea>

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
                                <span id="btnText">Save</span>

                            </button>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection