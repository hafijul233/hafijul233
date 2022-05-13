@extends('backend.layouts.app')

@section('title', 'States')

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
    {!! \Html::linkButton('Add State', 'backend.settings.states.create', [], 'fa fa-plus', 'success') !!}
    {{--{!! \Html::bulkDropdown('backend.settings.states', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($states))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.settings.states.index',
                            ['placeholder' => 'Search State Name, Status, etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'state-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="permission-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('name', 'Name')</th>
                                        <th class="text-center">@sortablelink('type', 'Type')</th>
                                        <th class="text-center">Country</th>
                                        <th class="text-center">@sortablelink('enabled', 'Enabled')</th>
                                        <th class="text-center">@sortablelink('created_at', 'Created')</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($states as $index => $state)
                                        <tr @if($state->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $state->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.settings.states.show')
                                                    <a href="{{ route('backend.settings.states.show', $state->id) }}">
                                                        {{ $state->name ?? null }}
                                                    </a>
                                                @else
                                                    {{ $state->name ?? null }}
                                                @endcan
                                                <span class="mb-0 d-block">
                                            {!! $state->native ?? null !!}
                                        </span>
                                            </td>
                                            <td class="text-center">
                                                {{ $state->type  ?? null}}
                                            </td>
                                            <td>
                                                {{ $state->country->name ?? null }}
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($state) !!}
                                            </td>
                                            <td class="text-center">{{ $state->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionButton('backend.settings.states', $state->id, array_merge(['show', 'edit'], ($state->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($states) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Country', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
