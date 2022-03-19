@extends('layouts.app')

@section('title', 'Edit Customer')

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $customer))

@section('actions')
    {!! \Html::backButton('backend.shipment.customers.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    {!! \Form::open(['route' => ['backend.shipment.customers.update', $customer->id], 'files' => true, 'id' => 'customer-form', 'method' => 'put']) !!}
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
