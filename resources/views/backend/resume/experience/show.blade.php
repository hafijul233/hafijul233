@extends('backend.layouts.app')

@section('title', $experience->title)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $experience))

@section('actions')
    {!! \Html::backButton('backend.resume.experiences.index') !!}
    {!! \Html::modelDropdown('backend.resume.experiences', $experience->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($experience->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.experience.Title') }}</label>
                                <div class="border p-2">{{ $experience->title ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.experience.Employment Type') }}</label>
                                <div class="border p-2">
                                    {!! (isset($experience->employmentType) ? $experience->employmentType->name : null) !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('resume.experience.Organization') }}</label>
                                <div class="border p-2">
                                    {!! $experience->organization ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('resume.experience.Address') }}</label>
                                <div class="border p-2">
                                    {!! $experience->address ?? null !!}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.experience.Start Date') }}</label>
                                <div class="border p-2">{{ $experience->start_date->format('d F, Y') ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.experience.End Date') }}</label>
                                <div class="border p-2">{{ $experience->end_date->format('d F, Y') ?? null }}</div>
                            </div>
                            {{--<div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.experience.Credential ID') }}</label>
                                <div class="border p-2">{{ $experience->credential ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.experience.Verify URL') }}</label>
                                <div class="border p-2">
                                    {!! $experience->url ?? null !!}
                                </div>
                            </div>--}}
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Description') }}</label>
                                <div class="border p-2">
                                    {!! $experience->description ?? null !!}
                                </div>
                            </div>
{{--                            <div class="col-md-12">
                                <label class="d-block">{{ __('common.Image') }}</label>
                                <div class="d-flex justify-content-center p-2 border">
                                    <img src="{!! $experience->getFirstMediaUrl('experiences') !!}" class="img-fluid">
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Experience', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

