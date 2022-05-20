@extends('backend.layouts.app')

@section('title', __('portfolio.service.Edit Service'))

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


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName(), $service))

@section('actions')
    {!! \Html::backButton('backend.portfolio.services.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! \Form::open(['route' => ['backend.portfolio.services.update', $service->id], 'method' => 'put', 'files' => true, 'id' => 'service-form']) !!}
                    @include('backend.portfolio.service.form')
                    {!! \Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
