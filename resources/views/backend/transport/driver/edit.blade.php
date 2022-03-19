@extends('layouts.app')

@section('title', 'Edit Driver')

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $driver))

@section('actions')
    {!! \Html::backButton('backend.transport.drivers.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    {!! \Form::open(['route' => ['backend.transport.drivers.update', $driver->id], 'files' => true, 'id' => 'driver-form', 'method' => 'put']) !!}
                    @include('backend.setting.user.form')
                    {!! \Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('component-script')

@endpush


@push('page-script')

@endpush
