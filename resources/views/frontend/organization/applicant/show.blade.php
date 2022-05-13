@extends('backend.layouts.app')

@section('title', $enumerator->name)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $enumerator))

@section('actions')
    {!! \Html::backButton('backend.portfolio.enumerators.index') !!}
    {!! \Html::modelDropdown('backend.portfolio.enumerators', $enumerator->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($enumerator->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        {{--Basic Information--}}
                        <fieldset>
                            <legend class="border-bottom lead mb-3 py-2 ml-0 pxl-0">
                                <i class="fas fa-user-check"></i> Basic Information
                            </legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!!  __('certificate.Comment') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->survey->name !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!!  __('certificate.Name') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->name !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Name(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->name_bd !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!!  __('certificate.Father Name') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->father !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!!  __('certificate.Father Name(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->father_bd !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Mother Name') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->mother !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Mother Name(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->mother_bd !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.NID Number') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->nid !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Mobile 1') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->mobile_1 !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Mobile 2') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->mobile_2 !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Email') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->email !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Present Address') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->present_address !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Present Address(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->present_address_bd !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Permanent Address') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->permanent_address !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Permanent Address(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->permanent_address_bd !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('certificate.Gender') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->gender->name !!}
                                </div>
                            </div>
                        </fieldset>
                        {{-- Education Qualification --}}
                        <fieldset>
                            <legend class="border-bottom lead mb-3 py-2 ml-0 pxl-0">
                                <i class="fas fa-graduation-cap"></i>
                                Educational Qualification
                            </legend>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                        <tr class="text-center font-weight-bold">
                                            <th>{!!  __('certificate.Examination') !!}</th>
                                            <th>{!!  __('certificate.Board') !!}
                                                / {!! __('certificate.Institute') !!}</th>
                                            <th> {!! __('certificate.Group/Subject') !!}</th>
                                            <th>{!! __('certificate.Passing Year') !!}</th>
                                            <th>{!! __('certificate.Result') !!}</th>
                                            <th>{!! __('certificate.GPA Point') !!}</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($enumerator->educationQualifications as $educationQualification)
                                            <tr>
                                                <th>{!! $educationQualification->examTitle->name !!}</th>
                                                <td>
                                                    @if($educationQualification->exam_board_id != null)
                                                        {!! $educationQualification->examBoard->name !!}
                                                    @else
                                                        {!! $educationQualification->institute->name !!}
                                                    @endif
                                                </td>
                                                <td>{!! $educationQualification->examGroup->name ?? ''  !!}</td>
                                                <td class="text-center">{!! $educationQualification->pass_year !!}</td>
                                                <td>
                                                    {!! \App\Supports\Constant::GPA_TYPE[$educationQualification->grade_type] !!}
                                                </td>
                                                <td class="text-center">
                                                    @if($educationQualification->grade_type > 3)
                                                        {!! $educationQualification->grade_point !!}
                                                    @else
                                                        {!! 'N/A' !!}
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                        {{--Work Experience--}}
                        <fieldset>
                            <legend class="border-bottom lead mb-3 py-2 ml-0 pxl-0">
                                <i class="fas fa-user-cog"></i>
                                Work Qualification
                            </legend>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                        <tr class="text-center font-weight-bold">
                                            <th>{!!  __('certificate.Company Name') !!}</th>
                                            <th>{!!  __('certificate.Designation') !!}</th>
                                            <th> {!! __('certificate.Service Start Date') !!}</th>
                                            <th>{!! __('certificate.Service End Date') !!}</th>
                                            <th>{!! __('certificate.Total Experience') !!}</th>
                                            <th>{!! __('certificate.Currently Working') !!}</th>
                                            <th>{!! __('certificate.Responsibility') !!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($enumerator->workQualifications as $workQualification)
                                            <tr>
                                                <th class="bg-light">{!! $workQualification->company ?? '' !!}</th>
                                                <td>{!! $workQualification->designation !!}</td>
                                                <td class="text-center">
                                                    @if($workQualification->start_date != null)
                                                        {!! $workQualification->start_date->format('d M, Y') !!}
                                                    @else
                                                        {!! 'N/A' !!}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($workQualification->end_date != null)
                                                        {!! $workQualification->end_date->format('d M, Y') !!}
                                                    @else
                                                        {!! 'N/A' !!}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $endServiceDate = ($workQualification->end_date != null) ? $workQualification->end_date : \Carbon\Carbon::now();
                                                    @endphp
                                                    {!! str_replace(['after', 'before'], '', $endServiceDate->diffForHumans($workQualification->start_date)) !!}
                                                </td>
                                                <td class="text-center">
                                                    {{ ($workQualification->end_date == null) ? 'Yes' : 'No' }}

                                                </td>
                                                <td>{!! $workQualification->responsibility ?? ''  !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
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

