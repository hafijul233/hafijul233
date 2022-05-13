@extends('layouts.app')

@section('title', __('menu-sidebar.Awards'))

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
    {!! \Html::linkButton(__('resume.award.Add Award'), 'backend.resume.awards.create', [], 'fas fa-plus', 'success') !!}
    {{--{!! \Html::bulkDropdown('backend.resume.awards', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($awards))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.resume.awards.index',
                            ['placeholder' => 'Search Comment Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'award-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th>@sortablelink('issuer', __('resume.award.Issuer'))</th>
                                        <th>@sortablelink('issue_date', __('resume.award.Issue Date'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($awards as $index => $award)
                                        <tr @if($award->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $award->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.resume.awards.show')
                                                    <a href="{{ route('backend.resume.awards.show', $award->id) }}">
                                                        {{ $award->title ?? null }}
                                                    </a>
                                                @else
                                                    {{ $award->title ?? null }}
                                                @endcan
                                            </td>
                                            <td>{{ $award->issuer ?? null }}</td>
                                            <td>{{ $award->issue_date->format('dS F, Y') ?? null }}</td>

                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($award) !!}
                                            </td>
                                            <td class="text-center">{{ $award->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.resume.awards', $award->id, array_merge(['show', 'edit'], ($award->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($awards) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Post', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
