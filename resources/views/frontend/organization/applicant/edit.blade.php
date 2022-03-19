@extends('layouts.app')

@section('title', 'Edit Enumerator')

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


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName(), $enumerator))

@section('actions')
    {!! \Html::backButton('backend.organization.enumerators.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! \Form::open(['route' => ['backend.organization.enumerators.update', $enumerator->id], 'method' => 'put', 'id' => 'enumerator-form']) !!}
                    @include('backend.organization.enumerator.form')
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
