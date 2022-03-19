@extends('layouts.app')

@section('title', 'Contacts')

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
    {!! \Html::linkButton('Add Contact', 'contact.individual.contacts.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('contact.individual.contacts', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($contacts))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'contact.individual.contacts.index',
                            ['placeholder' => 'Search Contact Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'contact-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="user-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th class="pl-0">@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('email', __('common.Email'))</th>
                                        <th class="text-center">@sortablelink('mobile', __('common.Mobile'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($contacts as $contact)
                                        <tr @if($contact->deleted_at != null) class="table-danger" @endif >
                                            <td class="exclude-search align-middle">
                                                {{ $contact->id }}
                                            </td>
                                            <td class="text-left pl-0">
                                                <div class="media">
                                                    <img class="align-self-center mr-1 img-circle direct-chat-img elevation-1"
                                                         src="{{ $contact->getFirstMediaUrl('avatars') }}" alt="{{ $contact->name }}">
                                                    <div class="media-body">
                                                        <p class="my-0">
                                                            @if(auth()->user()->can('backend.settings.users.show') || $contact->id == auth()->user()->id)
                                                                <a href="{{ route('backend.settings.users.show', $contact->id) }}">
                                                                    {{ $contact->name }}
                                                                </a>
                                                            @else
                                                                {{ $contact->name }}
                                                            @endif
                                                        </p>
                                                        <p class="mb-0 small">{{ $contact->username }}</p>
                                                    </div>
                                                </div>


                                            </td>
                                            <td class="text-left">{{ $contact->email ?? '-' }}</td>
                                            <td class="text-center">{{ $contact->mobile ?? '-' }}</td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($contact) !!}
                                            </td>
                                            <td class="text-center">{{ $contact->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.settings.users', $contact->id, array_merge(['show', 'edit'], ($contact->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($contacts) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Contact', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
