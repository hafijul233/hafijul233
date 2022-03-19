@extends('layouts.app')

@section('title', 'Edit Transaction')

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


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName(), $transaction))

@section('actions')
    {!! \Html::backButton('backend.shipment.transactions.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! \Form::open(['route' => ['backend.shipment.transactions.update', $transaction->id], 'method' => 'put', 'id' => 'transaction-form']) !!}
                    @include('setting.transaction.form')
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
