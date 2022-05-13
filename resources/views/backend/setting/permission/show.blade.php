@extends('backend.layouts.app')

@section('title', $permission->display_name)

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('inline-style')

@endpush

@push('head-script')

@endpush



@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $permission))

@section('actions')
    {!! \Html::backButton('backend.settings.permissions.index') !!}
    {!! \Html::modelDropdown('backend.settings.permissions', $permission->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($permission->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header p-3">
                        <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab"
                                   data-toggle="pill" href="#pills-home" role="tab"
                                   aria-controls="pills-home" aria-selected="true">
                                    <strong>Details</strong>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-timeline-tab"
                                   data-toggle="pill" href="#pills-timeline"
                                   role="tab" aria-controls="pills-timeline"
                                   aria-selected="false"><strong>Timeline</strong></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body min-vh-100">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                 aria-labelledby="pills-home-tab">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="d-block">Display Name</label>
                                        <p class="font-weight-bold">{{ $permission->display_name ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Name</label>
                                        <p class="font-weight-bold">{{ $permission->name ?? null }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="d-block">Guard(s)</label>
                                        <p class="font-weight-bold">{{ $permission->guard_name ?? null }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">Enabled</label>
                                        <p class="font-weight-bold">{{ \App\Supports\Constant::ENABLED_OPTIONS[$permission->enabled] }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="d-block">Remarks</label>
                                        <p class="font-weight-bold">{{ $permission->remarks ?? null }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-timeline" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                @include('backend.layouts.partials.timeline', $timeline)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Permission', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

