@extends('layouts.app')

@section('title', __('portfolio.certificate.Edit Certificate'))

@push('plugin-style')

@endpush

@push('page-style')

@endpush


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName(), $certificate))

@section('actions')
    {!! \Html::backButton('backend.portfolio.certificates.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! \Form::open(['route' => ['backend.portfolio.certificates.update', $certificate->id], 'method' => 'put', 'files'=>true, 'id' => 'certificate-form']) !!}
                    @include('backend.portfolio.certificate.form')
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
