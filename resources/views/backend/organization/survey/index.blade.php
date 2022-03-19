@extends('layouts.app')

@section('title', 'Surveys')

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



@section('breadcrumbs', \Breadcrumbs::render())

@section('actions')
    {!! \Html::linkButton('Add Survey', 'backend.organization.surveys.create', [], 'fas fa-plus', 'success') !!}
    {{--{!! \Html::bulkDropdown('backend.organization.surveys', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($surveys))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.organization.surveys.index',
                            ['placeholder' => 'Search Survey Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'survey-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($surveys as $index => $survey)
                                        <tr @if($survey->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $survey->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.organization.surveys.show')
                                                    <a href="{{ route('backend.organization.surveys.show', $survey->id) }}">
                                                        {{ $survey->name }}
                                                    </a>
                                                @else
                                                    {{ $survey->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($survey) !!}
                                            </td>
                                            <td class="text-center">{{ $survey->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.organization.surveys', $survey->id, array_merge(['show', 'edit'], ($survey->deleted_at == null) ? ['delete'] : ['restore'])) !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="exclude-search text-center">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pb-0">
                            {!! \App\Supports\CHTML::pagination($surveys) !!}
                        </div>
                    @else
                        <div class="card-body min-vh-100">

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    {!! \App\Supports\CHTML::confirmModal('Enumerator', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
