@extends('layouts.app')

@section('title', 'Occupations')

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
    {!! \Html::linkButton('Add Occupations', 'contact.settings.occupations.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('contact.settings.occupations', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($occupations))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'contact.settings.occupations.index',
                            ['placeholder' => 'Search Occupations Display Name, Code, Guard, Status, etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'permission-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="permission-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th>@sortablelink('remarks', 'Remarks')</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($occupations as $index => $occupation)
                                        <tr @if($occupation->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $occupation->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('contact.settings.occupations.show')
                                                    <a href="{{ route('contact.settings.occupations.show', $occupation->id) }}">
                                                        {{ $occupation->name }}
                                                    </a>
                                                @else
                                                    {{ $occupation->name }}
                                                @endcan
                                            </td>
                                            <td>{{ $occupation->remarks }}</td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($occupation) !!}
                                            </td>
                                            <td class="text-center">{{ $occupation->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('contact.settings.occupations', $occupation->id, array_merge(['show', 'edit'], ($occupation->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($occupations) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Occupations', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
