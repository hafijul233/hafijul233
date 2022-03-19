@extends('layouts.app')

@section('title', 'Add Contact')

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


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName()))

@section('actions')
    {!! \Html::backButton('contact.individual.contacts.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    {!! \Form::open(['route' => 'contact.individual.contacts.store', 'id' => 'contact-form']) !!}
                    @include('contact::individual.contact.form')
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
