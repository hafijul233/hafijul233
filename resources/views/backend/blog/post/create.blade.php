@extends('backend.layouts.app')

@section('title', __('blog.post.Add Post'))

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
    {!! \Html::backButton('backend.blog.posts.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    {!! \Form::open(['route' => 'backend.blog.posts.store', 'files' => true, 'id' => 'post-form']) !!}
                    @include('backend.blog.post.form')
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
