@extends('layouts.app')

@section('title', __('menu-sidebar.Vehicles'))

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
    {!! \Html::linkButton('Add Vehicle', 'backend.transport.vehicles.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.transport.vehicles', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($vehicles))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.transport.vehicles.index',
                            ['placeholder' => 'Search Vehicle Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'vehicle-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="vehicle-table">
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
                                    @forelse($vehicles as $index => $vehicle)
                                        <tr @if($vehicle->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $vehicle->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.transport.vehicles.show')
                                                    <a href="{{ route('backend.transport.vehicles.show', $vehicle->id) }}">
                                                        {{ $vehicle->name }}
                                                    </a>
                                                @else
                                                    {{ $vehicle->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($vehicle) !!}
                                            </td>
                                            <td class="text-center">{{ $vehicle->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.transport.vehicles', $vehicle->id, array_merge(['show', 'edit'], ($vehicle->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($vehicles) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Vehicle', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
