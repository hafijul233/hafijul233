@extends('layouts.app')

@section('title', 'Barcodes')

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
    {!! \Html::linkButton('Add ExamLevel', 'core.settings.barcodes.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('core.settings.barcodes', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($barcodes))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'core.settings.barcodes.index',
                            ['placeholder' => 'Search ExamLevel Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'barcode-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="barcode-table">
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
                                    @forelse($barcodes as $index => $barcode)
                                        <tr @if($barcode->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $barcode->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('core.settings.barcodes.show')
                                                    <a href="{{ route('core.settings.barcodes.show', $barcode->id) }}">
                                                        {{ $barcode->name }}
                                                    </a>
                                                @else
                                                    {{ $barcode->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($barcode) !!}
                                            </td>
                                            <td class="text-center">{{ $barcode->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('core.settings.barcodes', $barcode->id, array_merge(['show', 'edit'], ($barcode->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($barcodes) !!}
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
    {!! \App\Supports\CHTML::confirmModal('ExamLevel', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
