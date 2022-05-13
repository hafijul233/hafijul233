@extends('layouts.app')

@section('title', "{$education->degree} of {$education->field}")

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $education))

@section('actions')
    {!! \Html::backButton('backend.resume.educations.index') !!}
    {!! \Html::modelDropdown('backend.resume.educations', $education->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($education->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.education.Degree') }}</label>
                                <div class="border p-2">{{ $education->degree ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.education.Field') }}</label>
                                <div class="border p-2">
                                    {!! $education->field ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('resume.education.Institute') }}</label>
                                <div class="border p-2">
                                    {!! $education->institute ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('resume.education.Address') }}</label>
                                <div class="border p-2">
                                    {!! $education->address ?? null !!}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.education.Start Date') }}</label>
                                <div class="border p-2">{{ $education->start_date->format('d F, Y') ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.education.End Date') }}</label>
                                <div class="border p-2">{{ $education->end_date->format('d F, Y') ?? null }}</div>
                            </div>
                            {{--<div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.education.Credential ID') }}</label>
                                <div class="border p-2">{{ $education->associate ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('resume.education.URL') }}</label>
                                <div class="border p-2">
                                    {!! $education->url ?? null !!}
                                </div>
                            </div>--}}
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Description') }}</label>
                                <div class="border p-2">
                                    {!! $education->description ?? null !!}
                                </div>
                            </div>
                            {{--<div class="col-md-12">
                                <label class="d-block">{{ __('common.Image') }}</label>
                                <div class="d-flex justify-content-center p-2 border">
                                    <img src="{!! $education->getFirstMediaUrl('educations') !!}" class="img-fluid">
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Education', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

