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
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th width="30%">{!!  __('certificate.Name') !!}</th>
                                <td>{!! $enumerator->name   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Name(Bangla)') !!}</th>
                                <td>{!! $enumerator->name_bd   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Gender') !!}</th>
                                <td>{!! isset($enumerator->gender->name) ? $enumerator->gender->name : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!!  __('certificate.Date of Birth') !!}</th>
                                <td>@if($enumerator->dob != null)
                                        {!! \Carbon\Carbon::parse($enumerator->dob)->format('dS F, Y') !!}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{!!  __('certificate.Father Name') !!}</th>
                                <td>{!! $enumerator->father   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Mother Name') !!}</th>
                                <td> {!! $enumerator->mother   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.NID Number') !!}</th>
                                <td>{!! $enumerator->nid   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Present Address') !!}</th>
                                <td>{!! $enumerator->present_address   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Permanent Address') !!}</th>
                                <td> {!! $enumerator->permanent_address   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Highest Educational Qualification') !!}</th>
                                <td>{!! isset($enumerator->examLevel->name) ? $enumerator->examLevel->name : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Mobile 1') !!}</th>
                                <td>{!! $enumerator->mobile_1   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Mobile 2') !!}</th>
                                <td> {!! $enumerator->mobile_2   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Email') !!}</th>
                                <td>{!! $enumerator->email   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Whatsapp Number') !!}</th>
                                <td>  {!! $enumerator->whatsapp   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Facebook ID') !!}</th>
                                <td>{!! $enumerator->facebook   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Select the district(s) where you have worked earlier (it can be multiple)') !!}</th>
                                <td>
                                    @forelse($enumerator->previousPostings as $state)
                                        {{  $state->name }},
                                    @empty
                                        No District Available
                                    @endforelse
                                </td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Select the district(s) where you want to work in future (maximum 3)') !!}</th>
                                <td>
                                    <ul>
                                        @forelse($enumerator->futurePostings as $state)
                                            <li>{{  $state->name }}</li>
                                        @empty
                                            <li>No District Available</li>
                                        @endforelse
                                    </ul>

                                </td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Are you revenue staff of BBS?') !!}</th>
                                <td>{!! isset($enumerator->is_employee) ? ucfirst($enumerator->is_employee) : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Designation') !!}</th>
                                <td>{!! ($enumerator->is_employee == 'yes') ? $enumerator->designation :   'N/A' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Company Name') !!}</th>
                                <td>{!! ($enumerator->is_employee == 'yes') ? $enumerator->company :   'N/A' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('certificate.Work Experience in BBS as Post') !!}</th>
                                <td>
                                    <ul>
                                        @forelse($enumerator->surveys as $index => $survey)
                                            <li> {{ $index + 1 }}. {{ $survey->name ?? null }}</li>
                                        @empty
                                            <li> No Survey Available</li>
                                        @endforelse
                                    </ul>
                                </td>
                            </tr>

                        </table>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold"></label>
                            </div>
                            <div class="col-md-9">

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

