@extends('backend.layouts.app')

@section('title', $certificate->name)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $certificate))

@section('actions')
    {!! \Html::backButton('backend.portfolio.certificates.index') !!}
    {!! \Html::modelDropdown('backend.portfolio.certificates', $certificate->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($certificate->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('common.Name') }}</label>
                                <div class="border p-2">{{ $certificate->name ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.certificate.Portfolio') }}</label>
                                <div class="border p-2">
                                    {!! $certificate->organization ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.certificate.Issue Date') }}</label>
                                <div class="border p-2">{{ $certificate->issue_date->format('d F, Y') ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.certificate.Expire Date') }}</label>
                                <div class="border p-2">{{ $certificate->expire_date->format('d F, Y') ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.certificate.Credential ID') }}</label>
                                <div class="border p-2">{{ $certificate->credential ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.certificate.Verify URL') }}</label>
                                <div class="border p-2">
                                    {!! $certificate->verify_url ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Description') }}</label>
                                <div class="border p-2">
                                    {!! $certificate->description ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="d-block">{{ __('common.Image') }}</label>
                                <div class="d-flex justify-content-center p-2 border">
                                    <img src="{!! $certificate->getFirstMediaUrl('certificates') !!}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Certificate', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

