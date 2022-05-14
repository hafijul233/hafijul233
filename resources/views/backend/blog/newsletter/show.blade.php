@extends('backend.layouts.app')

@section('title', $newsLetter->name)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $newsLetter))

@section('actions')
    {!! \Html::backButton('backend.blog.newsletters.index') !!}
    {!! \Html::modelDropdown('backend.blog.newsletters', $newsLetter->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($newsLetter->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
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
                                <p class="font-weight-bold">{{ $newsLetter->name ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Email</label>
                                <p class="font-weight-bold">{{ $newsLetter->email ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Mobile</label>
                                <p class="font-weight-bold">{{ $newsLetter->mobile ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Website</label>
                                <p class="font-weight-bold">{{ $newsLetter->website ?? null }}</p>
                            </div>
                            <div class="col-md-12">
                                <label class="d-block">Message</label>
                                <p class="font-weight-bold">{{ $newsLetter->message ?? null }}</p>
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

