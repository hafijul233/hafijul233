@extends('layouts.app')

@section('title', 'Edit SmsTemplate')

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


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName(), $smstemplate))

@section('actions')
    {!! \Html::backButton('core.settings.smstemplates.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! \Form::open(['route' => ['core.settings.smstemplates.update', $smstemplate->id], 'method' => 'put', 'id' => 'smstemplate-form']) !!}
                    @include('setting.smstemplate.form')
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
