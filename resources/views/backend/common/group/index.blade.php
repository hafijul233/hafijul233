@extends('layouts.app')

@section('title', 'Groups')

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
    {!! \Html::linkButton('Add Group', 'backend.settings.groups.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.settings.groups', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($groups))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.settings.groups.index',
                            ['placeholder' => 'Search Group Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'group-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="group-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($groups as $index => $group)
                                        <tr @if($group->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $group->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.settings.groups.show')
                                                    <a href="{{ route('backend.settings.groups.show', $group->id) }}">
                                                        {{ $group->name }}
                                                    </a>
                                                @else
                                                    {{ $group->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($group) !!}
                                            </td>
                                            <td class="text-center">{{ $group->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.settings.groups', $group->id, array_merge(['show', 'edit'], ($group->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($groups) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Group', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
