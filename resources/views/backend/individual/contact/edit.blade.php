@extends('layouts.app')

@section('title', 'Edit Contact')

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


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName(), $contact))

@section('actions')
    {!! \Html::backButton('backend.settings.contacts.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! \Form::open(['route' => ['backend.settings.contacts.update', $contact->id], 'method' => 'put', 'id' => 'contact-form']) !!}
                    @include('setting.contact.form')
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
