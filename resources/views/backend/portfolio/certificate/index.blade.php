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
    {!! \Html::linkButton(__('certificate.Add Post'), 'backend.portfolio.enumerators.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.portfolio.enumerators', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-transparent pb-0">
                        <h2 class="card-title">Filter Results</h2>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('backend.portfolio.enumerators.index') }}"
                              accept-charset="UTF-8">
                            <div class="input-group">
                                <input class="form-control" placeholder="Search Enumerator Name etc." id="search"
                                       data-target-table="enumerator-table" name="search" type="search" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <input class="btn btn-primary input-group-right-btn" type="submit" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($enumerators))
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="employee-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th>@sortablelink('mobile_1', __('common.Mobile'))</th>
                                        <th>@sortablelink('email', __('common.Email'))</th>
                                        <th>@sortablelink('whatsapp', __('enumerator.Whatsapp Number'))</th>
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
                                                @can('backend.portfolio.enumerators.show')
                                                    <a href="{{ route('backend.portfolio.enumerators.show', $enumerator->id) }}">
                                                        {{ $enumerator->name }}<br>
                                                        {!!  $enumerator->name_bd !!}

                                                    </a>
                                                @else
                                                    {{ $enumerator->name }}<br>
                                                    {!!  $enumerator->name_bd !!}
                                                @endcan
                                            </td>
                                            <td>
                                                {{ $enumerator->mobile_1 }}@if(!empty($enumerator->mobile_2)),
                                                <br>{{ $enumerator->mobile_2 }}@endif
                                            </td>
                                            <td>
                                                {{ $enumerator->email }}
                                            </td>
                                            <td>
                                                {{ $enumerator->whatsapp }}
                                            </td>

                                            <td class="text-center">{{ $enumerator->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.portfolio.enumerators', $enumerator->id, array_merge(['show', 'edit'], ($enumerator->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Post', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
