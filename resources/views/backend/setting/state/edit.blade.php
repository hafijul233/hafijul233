@extends('core::layouts.app')

@section('title', 'Edit User')

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $user))

@section('actions')
    {!! \Html::backButton('core.settings.users.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            {!! \Form::open(['route' => ['core.settings.users.update', $user->id], 'files' => true, 'id' => 'user-form', 'method' => 'put']) !!}
            @include('core::setting.user.form')
            {!! \Form::close() !!}
        </div>
    </div>
@endsection

@push('component-script')

@endpush


@push('page-script')

@endpush
