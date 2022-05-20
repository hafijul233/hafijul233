@extends('backend.layouts.app')

@section('title', $testimonial->client)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $testimonial))

@section('actions')
    {!! \Html::backButton('backend.portfolio.testimonials.index') !!}
        {!! \Html::modelDropdown('backend.portfolio.testimonials', $testimonial->id, ['color' => 'success',
            'actions' => array_merge(['edit'], ($testimonial->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="d-block">Name</label>
                                <p class="font-weight-bold">{{ $testimonial->client ?? null }}</p>
                            </div>
                            <div class="col-md-12">
                                <label class="d-block">Feedback</label>
                                <p class="font-weight-bold">{{ $testimonial->feedback }}</p>
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

