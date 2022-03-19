@extends('layouts.app')

@section('title', __('menu-sidebar.Items'))

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
    {!! \Html::linkButton('Add Item', 'backend.shipment.items.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.shipment.items', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($items))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.shipment.items.index',
                            ['placeholder' => 'Search Item Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'item-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="item-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('rate', 'Rate')</th>
                                        <th class="text-center">@sortablelink('dimension', 'Dimension')</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($items as $index => $item)
                                        <tr @if($item->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $item->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.shipment.items.show')
                                                    <a href="{{ route('backend.shipment.items.show', $item->id) }}">
                                                        {{ $item->name }}
                                                    </a>
                                                @else
                                                    {{ $item->name }}
                                                @endcan
                                            </td>
                                            <td class="text-right">@money($item->rate, $item->currency, true)</td>
                                            <td class="text-center" data-toggle="tooltip" data-html="true"
                                                data-title="<p><b>Length: </b> <span class='text-success'>{{ $item->length  }} CM</span><br>
                                                            <b>Width: </b> <span class='text-success'>{{ $item->width  }} CM</span><br>
                                                            <b>Height: </b> <span class='text-success'>{{ $item->height  }} CM</span></p>"
                                            >{{ $item->dimension ?? null }}</td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($item) !!}
                                            </td>
                                            <td class="text-center">{{ $item->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.shipment.items', $item->id, array_merge(['show', 'edit'], ($item->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($items) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Item', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
