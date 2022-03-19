@extends('layouts.app')

@section('title', 'Catalogs')

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
    {!! \Html::linkButton('Add Catalog', 'backend.settings.catalogs.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.settings.catalogs', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($catalogs))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.settings.catalogs.index',
                            ['placeholder' => 'Search Catalog Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'catalog-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="catalog-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('type', 'Type')</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($catalogs as $index => $catalog)
                                        <tr @if($catalog->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $catalog->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.settings.catalogs.show')
                                                    <a href="{{ route('backend.settings.catalogs.show', $catalog->id) }}">
                                                        {{ $catalog->name }}
                                                    </a>
                                                @else
                                                    {{ $catalog->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center">
                                                {{ \App\Supports\Constant::CATALOG_LABEL[$catalog->type] }}
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($catalog) !!}
                                            </td>
                                            <td class="text-center">{{ $catalog->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.settings.catalogs', $catalog->id, array_merge(['show', 'edit'], ($catalog->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($catalogs) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Catalog', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
