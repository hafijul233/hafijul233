@extends('backend.layouts.app')

@section('title', $post->name)

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
    {{--    {!! \Html::modelDropdown('backend.blog.posts', $post->id, ['color' => 'success',
            'actions' => array_merge(['edit'], ($post->deleted_at == null) ? ['delete'] : ['restore'])]) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="d-block">Name</label>
                                <p class="font-weight-bold">{{ $post->name ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Enabled</label>
                                <p class="font-weight-bold">{{ \App\Supports\Constant::ENABLED_OPTIONS[$post->enabled] }}</p>
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

