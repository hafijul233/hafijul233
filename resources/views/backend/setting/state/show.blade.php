@extends('layouts.app')

@section('title', ($state->name ?? null))

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('inline-style')

@endpush

@push('head-script')

@endpush



@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $state))

@section('actions')
    {!! \Html::backButton('backend.settings.states.index') !!}
    {!! \Html::modelDropdown('backend.settings.states', $state->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($state->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
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
                                <p class="fw-bolder">{{ $state->name ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Native</label>
                                <p class="fw-bolder">{!! $state->native ?? null  !!}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Country</label>
                                <p class="fw-bolder">{{ $state->country->name ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Region</label>
                                <p class="fw-bolder">{{ $state->country->region ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Sub-Region</label>
                                <p class="fw-bolder">{{ $state->country->subregion ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Latitude</label>
                                <p class="fw-bolder">{{ $state->latitude ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Longitude</label>
                                <p class="fw-bolder">{{ $state->longitude ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Enabled</label>
                                <p class="fw-bolder">{{ \App\Supports\Constant::ENABLED_OPTIONS[$state->enabled] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Country', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

