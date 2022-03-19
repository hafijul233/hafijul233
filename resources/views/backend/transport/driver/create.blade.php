@extends('layouts.app')

@section('title', 'Add Driver')

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


@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName()))

@section('actions')
    {!! \Html::backButton('backend.transport.drivers.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {!! \Form::open(['route' => 'backend.transport.drivers.store', 'files' => true, 'id' => 'driver-form']) !!}
                    @include('backend.transport.driver.form')
                    {!! \Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('component-scripts')

@endpush


@push('page-scripts')

@endpush
