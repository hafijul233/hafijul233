@extends('layouts.app')

@section('title', 'Edit State')

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $state))

@section('actions')
    {!! \Html::backButton('backend.settings.states.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            {!! \Form::open(['route' => ['backend.settings.states.update', $state->id], 'id' => 'user-form', 'method' => 'put']) !!}
            @include('backend.setting.state.form')
            {!! \Form::close() !!}
        </div>
    </div>
@endsection

@push('component-script')

@endpush


@push('page-script')

@endpush
