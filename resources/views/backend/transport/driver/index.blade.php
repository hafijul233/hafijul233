@extends('layouts.app')

@section('title', __('menu-sidebar.Drivers'))

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
    {!! \Html::linkButton('Add Driver', 'backend.transport.drivers.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.transport.drivers', 0, ['color' => 'warning']) !!}

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($drivers))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.transport.drivers.index',
        ['placeholder' => 'Search Role Name, Code, Guard, Status, etc.',
        'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'user-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="user-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th class="pl-0">@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('mobile', __('common.Mobile'))</th>
                                        <th class="text-center">@sortablelink('roles.name', 'Role')</th>
                                        <th class="text-center">@sortablelink('email', __('common.Email'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($drivers as $driver)
                                        <tr @if($driver->deleted_at != null) class="table-danger" @endif >
                                            <td class="exclude-search align-middle">
                                                {{ $driver->id }}
                                            </td>
                                            <td class="text-left pl-0">
                                                @include('layouts.includes.user-media-card', ['dynamicUser' => $driver])
                                            </td>
                                            <td class="text-center">{{ $driver->mobile ?? '-' }}</td>
                                            <td class="text-center">
                                                {!! \App\Supports\CHTML::displayTags($driver->roles->pluck('name')->toArray(), 'fas fa-user-secret') !!}
                                            </td>
                                            <td class="text-left">{{ $driver->email ?? '-' }}</td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($driver) !!}
                                            </td>
                                            <td class="text-center">{{ $driver->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.transport.drivers', $driver->id, array_merge(['show', 'edit'], ($driver->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($drivers) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Driver', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
