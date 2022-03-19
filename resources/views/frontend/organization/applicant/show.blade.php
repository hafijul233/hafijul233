@extends('layouts.app')

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
    {!! \Html::backButton('backend.organization.enumerators.index') !!}
    {!! \Html::modelDropdown('backend.organization.enumerators', $enumerator->id, ['color' => 'success',
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
                                    <label class="font-weight-bold">{!!  __('enumerator.Survey') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->survey->name !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!!  __('enumerator.Name') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->name !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Name(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->name_bd !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!!  __('enumerator.Father Name') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->father !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!!  __('enumerator.Father Name(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->father_bd !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Mother Name') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->mother !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Mother Name(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->mother_bd !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.NID Number') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->nid !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Mobile 1') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->mobile_1 !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Mobile 2') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->mobile_2 !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Email') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->email !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Present Address') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->present_address !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Present Address(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->present_address_bd !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Permanent Address') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->permanent_address !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Permanent Address(Bangla)') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    {!! $enumerator->permanent_address_bd !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">{!! __('enumerator.Gender') !!}</label>
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
                                            <th>{!!  __('enumerator.Examination') !!}</th>
                                            <th>{!!  __('enumerator.Board') !!}
                                                / {!! __('enumerator.Institute') !!}</th>
                                            <th> {!! __('enumerator.Group/Subject') !!}</th>
                                            <th>{!! __('enumerator.Passing Year') !!}</th>
                                            <th>{!! __('enumerator.Result') !!}</th>
                                            <th>{!! __('enumerator.GPA Point') !!}</th>

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
                                            <th>{!!  __('enumerator.Company Name') !!}</th>
                                            <th>{!!  __('enumerator.Designation') !!}</th>
                                            <th> {!! __('enumerator.Service Start Date') !!}</th>
                                            <th>{!! __('enumerator.Service End Date') !!}</th>
                                            <th>{!! __('enumerator.Total Experience') !!}</th>
                                            <th>{!! __('enumerator.Currently Working') !!}</th>
                                            <th>{!! __('enumerator.Responsibility') !!}</th>
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
    {!! \App\Supports\CHTML::confirmModal('Enumerator', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

