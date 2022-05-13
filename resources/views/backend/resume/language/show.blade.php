@extends('backend.layouts.app')

@section('title', $language->name)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $language))

@section('actions')
    {!! \Html::backButton('backend.resume.languages.index') !!}
    {{--    {!! \Html::modelDropdown('backend.resume.languages', $language->id, ['color' => 'success',
            'actions' => array_merge(['edit'], ($language->deleted_at == null) ? ['delete'] : ['restore'])]) !!}--}}
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
                                <p class="font-weight-bold">{{ $language->name ?? null }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block">Enabled</label>
                                <p class="font-weight-bold">{{ \App\Supports\Constant::ENABLED_OPTIONS[$language->enabled] }}</p>
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

