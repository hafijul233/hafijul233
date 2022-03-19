@extends('layouts.app')

@section('title', $country->name)

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



@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $country))

@section('actions')
    {!! \Html::backButton('contact.settings.countries.index') !!}
    {!! \Html::modelDropdown('contact.settings.countries', $country->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($country->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
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
                                <a class="nav-link" id="pills-state-tab"
                                   data-toggle="pill" href="#pills-state" role="tab"
                                   aria-controls="pills-state" aria-selected="true">
                                    <strong>States</strong>
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
                                        <p class="font-weight-bold">{{ $country->name ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Native</label>
                                        <p class="font-weight-bold">{!! $country->native ?? null  !!}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">ISO Alpha-2 Code</label>
                                        <p class="font-weight-bold">{{ $country->iso2 ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">ISO Alpha-3 Code</label>
                                        <p class="font-weight-bold">{{ $country->iso3 ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Phone Code</label>
                                        <p class="font-weight-bold">{{ $country->phone_code ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Numeric Code</label>
                                        <p class="font-weight-bold">{{ $country->numeric_code ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">States</label>
                                        <p class="font-weight-bold">{{ $country->total_states ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Cities</label>
                                        <p class="font-weight-bold">{{ $country->total_cities ?? null }}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="d-block">Capital</label>
                                        <p class="font-weight-bold">{{ $country->capital ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Currency</label>
                                        <p class="font-weight-bold">
                                            {{ $country->currency ?? null }}
                                            @if($country->currency_symbol != null)
                                                ({!! $country->currency_symbol !!})
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Region</label>
                                        <p class="font-weight-bold">{{ $country->region ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Sub-Region</label>
                                        <p class="font-weight-bold">{{ $country->subregion ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Latitude</label>
                                        <p class="font-weight-bold">{{ $country->latitude ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Longitude</label>
                                        <p class="font-weight-bold">{{ $country->longitude ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Flag Emoji</label>
                                        <p class="font-weight-bold">
                                            {{ $country->emoji ?? null }}

                                            @if($country->emojiU != null)
                                                ({!! $country->emojiU !!})
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Enabled</label>
                                        <p class="font-weight-bold">{{ \App\Supports\Constant::ENABLED_OPTIONS[$country->enabled] }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-md-6">
                                        <label class="d-block">Timezone(s)</label>
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>TimeZone</th>
                                                <th>Details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($country->timezones as $index => $timezone)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $timezone['zoneName'] }}</td>
                                                    <td>
                                                        @foreach($timezone as $field => $value)
                                                            <p class="my-1">
                                                                <strong>{{ ucwords(str_replace('_', ' ', \Str::snake($field))) }}:</strong>
                                                                {!! $value !!}
                                                            </p>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label class="d-block">Translation(s)</label>
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th class="text-left">#</th>
                                                <th class="text-center">Locale</th>
                                                <th class="text-left">Abbreviation</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $c = 1 @endphp
                                            @forelse($country->translations as $locale => $translation)
                                                <tr>
                                                    <td>{{ $c++ }}</td>
                                                    <td class="text-center">{{ $locale }}</td>
                                                    <td>{!! $translation !!}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="d-block">Remarks</label>
                                        <p class="font-weight-bold">{{ $country->remarks ?? null }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-state" role="tabpanel"
                                 aria-labelledby="pills-state-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="permission-table">
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
                                        @forelse($country->states as $index => $state)
                                            <tr @if($state->deleted_at != null) class="table-danger" @endif>
                                                <td class="exclude-search align-middle">
                                                    {{ $state->id }}
                                                </td>
                                                <td class="text-left">
                                                    @can('contact.settings.states.show')
                                                        <a href="{{ route('contact.settings.states.show', $state->id) }}">
                                                            {{ $state->name }}
                                                        </a>
                                                    @else
                                                        {{ $state->name }}
                                                    @endcan
                                                    <span class="mb-0 d-block">
                                            {!! $state->native !!}
                                        </span>
                                                </td>
                                                <td class="text-left">
                                                    {{ $state->type }}
                                                </td>
                                                <td class="text-center exclude-search">
                                                    {!! \Html::enableToggle($state) !!}
                                                </td>
                                                <td class="text-center">{{ $state->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                                <td class="exclude-search pr-3 text-center align-middle">
                                                    {!! \Html::actionDropdown('contact.settings.states', $state->id, array_merge(['show', 'edit'], ($state->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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

