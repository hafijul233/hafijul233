@extends('layouts.app')

@section('title', 'Roles')

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
    {!! \Html::linkButton('Add Role', 'backend.settings.roles.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.settings.roles', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($roles))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.settings.roles.index',
        ['placeholder' => 'Search Role Name, Code, Guard, Status, etc.',
        'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'role-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="role-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('guard_name', 'Guard')</th>
                                        <th class="text-center">@sortablelink('permissions', 'Permissions')</th>
                                        <th class="text-center">@sortablelink('users', 'Users')</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($roles as $index => $role)
                                        <tr @if($role->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $role->id }}
                                            </td>
                                            <td class="text-left">
                                                @if(auth()->user()->can('backend.settings.roles.show') || in_array($role->id, auth()->user()->role_ids))
                                                    <a href="{{ route('backend.settings.roles.show', $role->id) }}">
                                                        {{ $role->name }}
                                                    </a>
                                                @else
                                                    {{ $role->name }}
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $role->guard_name }}</td>
                                            <td class="text-center">{{ $role->total_permissions }}</td>
                                            <td class="text-center">{{ $role->total_users }}</td>

                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($role) !!}
                                            </td>
                                            <td class="text-center">{{ $role->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.settings.roles', $role->id, array_merge(['show', 'edit'], ($role->deleted_at == null) ? ['delete'] : ['restore'])) !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="exclude-search text-center">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pb-0">
                            {!! \App\Supports\CHTML::pagination($roles) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Role', ['export','delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
