@extends('layouts.app')

@section('title', $catalog->name)

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('page-style')

@endpush

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $catalog))

@section('actions')
    {!! \Html::backButton('backend.settings.catalogs.index') !!}
    {!! \Html::modelDropdown('backend.settings.catalogs', $catalog->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($catalog->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="d-block">Name</label>
                                <p class="font-weight-bold">{{ $catalog->name ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Type</label>
                                <p class="font-weight-bold">{{ \App\Supports\Constant::CATALOG_LABEL[$catalog->type] ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Location</label>
                                <p class="font-weight-bold">{{ $catalog->model_type }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Enabled</label>
                                <p class="font-weight-bold">{{ \App\Supports\Constant::ENABLED_OPTIONS[$catalog->enabled] }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="d-block">Remarks</label>
                                <p class="font-weight-bold">{{ $catalog->remarks ?? null }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Catalog', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

