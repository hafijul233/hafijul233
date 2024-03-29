@extends('backend.layouts.app')

@section('title', $service->name)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $service))

@section('actions')
    {!! \Html::backButton('backend.portfolio.services.index') !!}
        {!! \Html::modelDropdown('backend.portfolio.services', $service->id, ['color' => 'success',
            'actions' => array_merge(['edit'], ($service->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Name') }}</label>
                                <div class="border p-2">{{ $service->name ?? null }}</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Summary') }}</label>
                                <div class="border p-2">
                                    {!! $service->summary ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Description') }}</label>
                                <div class="border p-2">
                                    {!! $service->description ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="d-block">{{ __('common.Image') }}</label>
                                <div class="d-flex justify-content-center p-2 border">
                                    <img src="{!! asset($service->getFirstMediaUrl('services')) !!}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Service', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

