@extends('backend.layouts.app')

@section('title', __('menu-sidebar.Services'))

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
    {!! \Html::linkButton(__('portfolio.service.Add Service'), 'backend.portfolio.services.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.portfolio.services', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($services))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.portfolio.services.index',
                            ['placeholder' => 'Search service name, summary, description, enabled etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'service-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="service-table">
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
                                    @forelse($services as $index => $service)
                                        <tr @if($service->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $service->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.portfolio.services.show')
                                                    <a href="{{ route('backend.portfolio.services.show', $service->id) }}">
                                                        {{ $service->name }}
                                                    </a>
                                                @else
                                                    {{ $service->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($service) !!}
                                            </td>
                                            <td class="text-center">{{ $service->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.portfolio.services', $service->id, array_merge(['show', 'edit'], ($service->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($services) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Service', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
