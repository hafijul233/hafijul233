@extends('layouts.app')

@section('title', __('menu-sidebar.Invoices'))

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
    {!! \Html::linkButton('Add Invoice', 'backend.shipment.invoices.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.shipment.invoices', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($invoices))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.shipment.invoices.index',
                            ['placeholder' => 'Search Invoice Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'invoice-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="invoice-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('number', 'Invoice')</th>
                                        <th>@sortablelink('user.name', 'Customer')</th>
                                        <th>@sortablelink('entry_date', 'Entry Date')</th>
                                        <th>@sortablelink('total', 'Amount')</th>
                                        <th class="text-center">@sortablelink('status', 'Status')</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('invoiced_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($invoices as $index => $invoice)
                                        <tr @if($invoice->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $invoice->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.shipment.invoices.show')
                                                    <a href="{{ route('backend.shipment.invoices.show', $invoice->id) }}">
                                                        {{ $invoice->name }}
                                                    </a>
                                                @else
                                                    {{ $invoice->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($invoice) !!}
                                            </td>
                                            <td class="text-center">{{ $invoice->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.shipment.invoices', $invoice->id, array_merge(['show', 'edit'], ($invoice->deleted_at == null) ? ['delete'] : ['restore'])) !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="exclude-search text-center">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pb-0">
                            {!! \App\Supports\CHTML::pagination($invoices) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Invoice', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
