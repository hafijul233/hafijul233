@extends('layouts.app')

@section('title', 'Add State')

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
    {!! \Html::backButton('backend.settings.states.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            {!! \Form::open(['route' => 'backend.settings.states.store', 'id' => 'state-form']) !!}
            @include('backend.setting.state.form')
            {!! \Form::close() !!}
        </div>
    </div>
@endsection

@push('component-scripts')

@endpush


@push('page-scripts')

@endpush
