@extends('backend.layouts.app')

@section('title', __('blog.post.Edit Post'))

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


@section('breadcrumbs', \Breadcrumbs::render(Route::getCurrentRoute()->getName(), $post))

@section('actions')
    {!! \Html::backButton('backend.blog.posts.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! \Form::open(['route' => ['backend.blog.posts.update', $post->id], 'method' => 'put', 'files' => true, 'id' => 'post-form']) !!}
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
