@extends('layouts.app')

@section('title', __('menu-sidebar.Enumerators'))

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
    {!! \Html::linkButton(__('enumerator.Add Enumerator'), 'backend.organization.enumerators.create', [], 'fas fa-plus', 'success') !!}
    {{--{!! \Html::bulkDropdown('backend.organization.enumerators', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($enumerators))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.organization.enumerators.index',
                            ['placeholder' => 'Search Enumerator Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'enumerator-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="employee-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th>@sortablelink('name', __('common.Mobile'))</th>
                                        <th>@sortablelink('name', __('common.Email'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($enumerators as $index => $enumerator)
                                        <tr @if($enumerator->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $enumerator->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.organization.enumerators.show')
                                                    <a href="{{ route('backend.organization.enumerators.show', $enumerator->id) }}">
                                                        {{ $enumerator->name }}
                                                    </a>
                                                @else
                                                    {{ $enumerator->name }}
                                                @endcan
                                            </td>
                                            <td>
                                                {{ $enumerator->mobile_1 }}@if(!empty($enumerator->mobile_2)), <br>{{ $enumerator->mobile_2 }}@endif
                                            </td>
                                            <td>
                                                {{ $enumerator->email }}
                                            </td>
                                            <td class="text-center">{{ $enumerator->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.organization.enumerators', $enumerator->id, array_merge(['show', 'edit'], ($enumerator->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($enumerators) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Enumerator', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
