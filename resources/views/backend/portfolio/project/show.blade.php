@extends('backend.layouts.app')

@section('title', \App\Supports\Utility::textTruncate($project->name, 30))

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $project))

@section('actions')
    {!! \Html::backButton('backend.portfolio.projects.index') !!}
    {!! \Html::modelDropdown('backend.portfolio.projects', $project->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($project->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('common.Name') }}</label>
                                <div class="border p-2">{{ $project->name ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.project.Owner') }}</label>
                                <div class="border p-2">
                                    {!! $project->owner ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.project.Start Date') }}</label>
                                <div class="border p-2">{{ $project->start_date->format('d F, Y') ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.project.End Date') }}</label>
                                <div class="border p-2">{{ $project->end_date->format('d F, Y') ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.project.Associate') }}</label>
                                <div class="border p-2">{{ $project->associate ?? null }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">{{ __('portfolio.project.URL') }}</label>
                                <div class="border p-2">
                                    {!! $project->url ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="d-block">{{ __('common.Description') }}</label>
                                <div class="border p-2">
                                    {!! $project->description ?? null !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="d-block">{{ __('common.Image') }}</label>
                                <div class="d-flex justify-content-center p-2 border">
                                    <img src="{!! $project->getFirstMediaUrl('projects') !!}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Project', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

