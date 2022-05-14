@extends('backend.layouts.app')

@section('title', $post->title)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $post))

@section('actions')
    {!! \Html::backButton('backend.blog.posts.index') !!}
        {!! \Html::modelDropdown('backend.blog.posts', $post->id, ['color' => 'success',
            'actions' => array_merge(['edit'], ($post->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Name') }}</label>
                                <div class="border p-2">{{ $post->title ?? null }}</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Summary') }}</label>
                                <div class="border p-2">
                                    {!! $post->summary ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Content') }}</label>
                                <div class="border p-2">
                                    {!! $post->content ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="d-block">{{ __('common.Image') }}</label>
                                <div class="d-flex justify-content-center p-2 border">
                                    <img src="{!! $post->getFirstMediaUrl('posts') !!}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Post', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

