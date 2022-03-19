@extends('layouts.app')

@section('title', $state->name)

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
    {!! \Html::backButton('contact.settings.states.index') !!}
    {!! \Html::modelDropdown('contact.settings.states', $state->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($state->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header p-3">
                        <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab"
                                   data-toggle="pill" href="#pills-home" role="tab"
                                   aria-controls="pills-home" aria-selected="true">
                                    <strong>Details</strong>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-city-tab"
                                   data-toggle="pill" href="#pills-city" role="tab"
                                   aria-controls="pills-city" aria-selected="true">
                                    <strong>Cities</strong>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-timeline-tab"
                                   data-toggle="pill" href="#pills-timeline"
                                   role="tab" aria-controls="pills-timeline"
                                   aria-selected="false"><strong>Timeline</strong></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body min-vh-100">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                 aria-labelledby="pills-home-tab">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="d-block">Name</label>
                                        <p class="font-weight-bold">{{ $state->name ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Native</label>
                                        <p class="font-weight-bold">{!! $state->native ?? null  !!}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Country</label>
                                        <p class="font-weight-bold">{{ $state->country->name ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Region</label>
                                        <p class="font-weight-bold">{{ $state->country->region ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Sub-Region</label>
                                        <p class="font-weight-bold">{{ $state->country->subregion ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Latitude</label>
                                        <p class="font-weight-bold">{{ $state->latitude ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Longitude</label>
                                        <p class="font-weight-bold">{{ $state->longitude ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Enabled</label>
                                        <p class="font-weight-bold">{{ \App\Supports\Constant::ENABLED_OPTIONS[$state->enabled] }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="d-block">Remarks</label>
                                        <p class="font-weight-bold">{{ $state->remarks ?? null }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-city" role="tabpanel"
                                 aria-labelledby="pills-city-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="city-table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle">Name</th>
                                            <th class="align-middle">Type</th>
                                            <th class="text-center">Enabled</th>
                                            <th class="text-center">Created</th>
                                            <th class="text-center">{!! __('common.Actions') !!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @dump($state->cities)
                                        @forelse($state->cities as $index => $city)
                                            <tr @if($city->deleted_at != null) class="table-danger" @endif>
                                                <td class="exclude-search align-middle">
                                                    {{ $city->id }}
                                                </td>
                                                <td class="text-left">
                                                    @can('contact.settings.states.show')
                                                        <a href="{{ route('contact.settings.states.show', $city->id) }}">
                                                            {{ $city->name }}
                                                        </a>
                                                    @else
                                                        {{ $city->name }}
                                                    @endcan
                                                    <span class="mb-0 d-block">
                                            {!! $city->native !!}
                                        </span>
                                                </td>
                                                <td class="text-left">
                                                    {{ $city->type }}
                                                </td>
                                                <td class="text-center exclude-search">
                                                    {!! \Html::enableToggle($city) !!}
                                                </td>
                                                <td class="text-center">{{ $city->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                                <td class="exclude-search pr-3 text-center align-middle">
                                                    {!! \Html::actionDropdown('contact.settings.states', $city->id, array_merge(['show', 'edit'], ($city->deleted_at == null) ? ['delete'] : ['restore'])) !!}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="exclude-search text-center">No data to display</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-timeline" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                @include('layouts.partials.timeline', $timeline)
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

