@extends('layouts.frontend')

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
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header border-bottom-0">
                        <h4 class="mb-1 text-center font-weight-bold">{!! __('common.Government of the People’s Republic of Bangladesh') !!}</h4>
                        <h5 class="mb-1 text-center">{!! __('common.Bangladesh Bureau of Statistics') !!}</h5>
                        <h5 class="mb-1 text-center">{!! __('common.NSDS Implementation Support Project') !!}</h5>
                        <h5 class="mb-1 text-center">{!! __('common.Parishankhyan Bhaban (8th Floor, Block-B)') !!}</h5>
                        <h5 class="mb-1 text-center">{!! __('common.E-27/A, Agargaon, Dhaka-1207') !!}</h5>
                        <h5 class="mb-1 text-center">
                            <a href="https://www.bbs.gov.bd" style="text-decoration: underline">www.bbs.gov.bd</a>
                        </h5>
                        <h3 class="font-weight-bold text-center mt-3"
                            style="text-decoration: underline">{!! __('common.Database of Enumerators') !!}</h3>
                    </div>
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
