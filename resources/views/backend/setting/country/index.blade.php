@extends('layouts.app')

@section('title', 'Countries')

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
    {!! \Html::linkButton('Add Country', 'contact.settings.countries.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('contact.settings.countries', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($countries))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'contact.settings.countries.index',
                            ['placeholder' => 'Search Permission Display Name, Code, Guard, Status, etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'permission-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="permission-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th class="text-center align-middle">Flag</th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('iso3', 'ISO Code')</th>
                                        <th>@sortablelink('region', 'Region')</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($countries as $index => $country)
                                        <tr @if($country->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $country->id }}
                                            </td>
                                            <th class="text-center align-middle p-0">
                                        <span style="font-size: 300%;" data-toggle="tooltip"
                                              data-title="{!!  $country->native !!}" data-html="true">
                                            {!! $country->emoji !!}
                                        </span>
                                            </th>
                                            <td class="text-left">
                                                @can('contact.settings.countries.show')
                                                    <a href="{{ route('contact.settings.countries.show', $country->id) }}">
                                                        {{ $country->name }}
                                                    </a>
                                                @else
                                                    {{ $country->name }}
                                                @endcan
                                                <span class="mb-0 d-block">
                                            {!! $country->native !!}
                                        </span>
                                            </td>
                                            <td class="text-center">
                                                {{ $country->iso3 }}
                                                @if($country->iso2 != null)
                                                    ({{ $country->iso2 }})
                                                @endif
                                            </td>
                                            <td>
                                                {{ $country->region }}
                                                @if($country->subregion != null)
                                                    ({{ $country->subregion }})
                                                @endif
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($country) !!}
                                            </td>
                                            <td class="text-center">{{ $country->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('contact.settings.countries', $country->id, array_merge(['show', 'edit'], ($country->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($countries) !!}
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
