@extends('layouts.app')

@section('title', 'Permissions')

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



@section('breadcrumbs', \Breadcrumbs::render())

@section('actions')
    {!! \Html::linkButton('Add Permission', 'backend.settings.permissions.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.settings.permissions', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($permissions))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.settings.permissions.index',
                            ['placeholder' => 'Search Permission Display Name, Code, Guard, Status, etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'permission-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="permission-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th>@sortablelink('display_name', 'Display Name')</th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th>@sortablelink('guard_name', 'Guard')</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($permissions as $index => $permission)
                                        <tr @if($permission->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $permission->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.settings.permissions.show')
                                                    <a href="{{ route('backend.settings.permissions.show', $permission->id) }}">
                                                        {{ $permission->display_name }}
                                                    </a>
                                                @else
                                                    {{ $permission->display_name }}
                                                @endcan
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($permission) !!}
                                            </td>
                                            <td class="text-center">{{ $permission->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.settings.permissions', $permission->id, array_merge(['show', 'edit'], ($permission->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($permissions) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Permission', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
