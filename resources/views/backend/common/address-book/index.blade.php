@extends('layouts.app')

@section('title', __('menu-sidebar.Address Book'))

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
    {!! \Html::linkButton('Add Address', 'backend.common.address-books.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.common.address-books', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($addressBooks))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.common.address-books.index',
                            ['placeholder' => 'Search Address Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'addressbook-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="addressbook-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        @if(\App\Services\Auth\AuthenticatedSessionService::isSuperAdmin())
                                            <th class="align-middle">
                                                @sortablelink('user.name', 'User')
                                            </th>
                                        @endif
                                        <th>@sortablelink('type', 'Type')</th>
                                        <th>@sortablelink('name', 'Representative')</th>
                                        <th>@sortablelink('phone', 'Contact')</th>
                                        <th>Address</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($addressBooks as $index => $addressbook)
                                        <tr @if($addressbook->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $addressbook->id }}
                                            </td>
                                            @if(\App\Services\Auth\AuthenticatedSessionService::isSuperAdmin())
                                                <td class="text-left pl-0">
                                                    @include('layouts.includes.user-media-card', ['dynamicUser' => $addressbook->addressable])
                                                </td>
                                            @endif
                                            <td>{{ config("contact.address_type.{$addressbook->type}") }}</td>
                                            <td class="text-left">
                                                @can('backend.common.address-books.show')
                                                    <a href="{{ route('backend.common.address-books.show', $addressbook->id) }}">
                                                        {{ $addressbook->name }}
                                                    </a>
                                                @else
                                                    {{ $addressbook->name }}
                                                @endcan
                                            </td>
                                            <td>{{ $addressbook->phone }}</td>
                                            <td>{{ \App\Supports\Utility::getAddressBlock($addressbook) }}</td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($addressbook) !!}
                                            </td>
                                            <td class="text-center">{{ $addressbook->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.common.address-books', $addressbook->id, array_merge(['show', 'edit'], ($addressbook->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($addressBooks) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Address', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
