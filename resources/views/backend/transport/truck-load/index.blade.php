@extends('layouts.app')

@section('title', __('menu-sidebar.Truck Loads'))

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
    {!! \Html::linkButton('Add TruckLoad', 'backend.transport.truck-loads.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.transport.truck-loads', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($truckloads))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.transport.truck-loads.index',
                            ['placeholder' => 'Search TruckLoad Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'truck-load-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="truck-load-table">
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
                                    @forelse($truckloads as $index => $truckload)
                                        <tr @if($truckload->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $truckload->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.transport.truck-loads.show')
                                                    <a href="{{ route('backend.transport.truck-loads.show', $truckload->id) }}">
                                                        {{ $truckload->name }}
                                                    </a>
                                                @else
                                                    {{ $truckload->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($truckload) !!}
                                            </td>
                                            <td class="text-center">{{ $truckload->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.transport.truck-loads', $truckload->id, array_merge(['show', 'edit'], ($truckload->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($truckloads) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Truck Load', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
