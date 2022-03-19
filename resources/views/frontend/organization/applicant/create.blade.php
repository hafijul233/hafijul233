@extends('layouts.guest')

@section('title', __('enumerator.Applicant Registration'))

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

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    {!! \Form::open(['route' => 'frontend.organization.applicants.store', 'id' => 'enumerator-form']) !!}
                    @include('frontend.organization.applicant.form')
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
