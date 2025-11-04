@extends('layouts.admin')
@section('title', "Tier")
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h5 class="page-title mb-0 crm_c">
                Tier
            </h5>

            <a href="#page_header"
                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
            <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                <div class="d-inline-flex align-items-center">

                    <a href="{{ route("admin.tier.create") }}"
                        class="btn btn-primary btn-icon w-32px h-32px rounded-pill bg_s">
                        <i class="ph-plus"> </i>
                    </a>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content area -->
<div class="content pt-0">

    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="jsGrid1" class="table table-bordered table-striped table-hover datatable datatable-User">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tier</th>
                                    <th>Range</th>
                                    <th>Commission</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tiers as $key => $tier)
                                <tr data-entry-id="{{ $tier->id }}">

                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>{{ $tier->tier_name }}</td>
                                    <td>{{ $tier->min_value }} - {{ $tier->max_value }}</td>
                                    <td>₹{{ number_format($tier->commission, 2) }}</td>
                                    <td>
                                        @if($tier->category == 'solar')
                                        <i class="ph-sun ph-lg text-warning me-1"></i> Solar
                                        @elseif($tier->category == 'battery')
                                        <i class="ph-battery-charging ph-lg text-success me-1"></i> Battery
                                        @else
                                        <i class="ph-question ph-lg text-muted me-1"></i> {{ ucfirst($tier->category) }}
                                        @endif
                                    </td>



                                    <td>


                                        <a href="{{ route('admin.tier.edit', $tier->id) }}"
                                            class="btn btn-sm btn-outline-info p-1">
                                            <i class="ph-pencil"></i>
                                        </a>



                                        <form action="{{ route('admin.tier.destroy', $tier->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1">
                                                <i class="ph-trash"></i>
                                            </button>
                                        </form>


                                    </td>

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
 
</script>
@endsection