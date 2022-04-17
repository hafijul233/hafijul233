@extends('layouts.app')

@section('title', $enumerator->name)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $enumerator))

@section('actions')
    {!! \Html::backButton('backend.organization.enumerators.index') !!}
    {!! \Html::modelDropdown('backend.organization.enumerators', $enumerator->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($enumerator->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!!  __('enumerator.Name') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->name   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Name(Bangla)') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->name_bd   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Gender') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! isset($enumerator->gender->name) ? $enumerator->gender->name : null !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!!  __('enumerator.Date of Birth') !!}</label>
                            </div>
                            <div class="col-md-9">
                                @if($enumerator->dob != null)
                                    {!! \Carbon\Carbon::parse($enumerator->dob)->format('dS F, Y') !!}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!!  __('enumerator.Father Name') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->father   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Mother Name') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->mother   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.NID Number') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->nid   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Present Address') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->present_address   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Permanent Address') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->permanent_address   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Highest Educational Qualification') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! isset($enumerator->examLevel->name) ? $enumerator->examLevel->name : null !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Mobile 1') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->mobile_1   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Mobile 2') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->mobile_2   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Email') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->email   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Whatsapp Number') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->whatsapp   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Facebook ID') !!}</label>
                            </div>
                            <div class="col-md-9">
                                {!! $enumerator->facebook   ?? '' !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold">{!! __('enumerator.Survey') !!}</label>
                            </div>
                            <div class="col-md-9">
                                <ul class="pl-0">
                                    @forelse($enumerator->surveys as $index => $survey)
                                        <li> {{ $index + 1 }}. {{ $survey->name ?? null }}</li>
                                    @empty
                                        <li> No Survey Available</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Enumerator', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

