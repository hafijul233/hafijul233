@extends('backend.layouts.app')

@section('title', __('service.Edit Comment'))

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


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName(), $survey))

@section('actions')
    {!! \Html::backButton('backend.resume.surveys.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! \Form::open(['route' => ['backend.resume.surveys.update', $survey->id], 'method' => 'put', 'id' => 'service-form']) !!}
                    @include('backend.resume.service.form')
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
