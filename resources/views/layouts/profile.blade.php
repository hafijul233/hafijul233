@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('layouts.includes.profile-sidebar', $user)
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-3">
                        <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link " id="pills-home-tab"
                                   data-toggle="pill" href="#pills-home" role="tab"
                                   aria-controls="pills-home" aria-selected="true"><strong>Details</strong></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-address-book-tab"
                                   data-toggle="pill" href="#pills-address-book"
                                   role="tab" aria-controls="pills-address-book"
                                   aria-selected="false"><strong>Address Book</strong></a>
                            </li>
                            {{--                            <li class="nav-item">
                                                            <a class="nav-link" id="pills-permission-tab"
                                                               data-toggle="pill" href="#pills-permission"
                                                               role="tab" aria-controls="pills-permission"
                                                               aria-selected="false"><strong>Permissions</strong></a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="pills-timeline-tab"
                                                               data-toggle="pill" href="#pills-timeline"
                                                               role="tab" aria-controls="pills-timeline"
                                                               aria-selected="false"><strong>Timeline</strong></a>
                                                        </li>--}}
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            @yield('sub-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--    <div class="modal fade" id="bd-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    {!! \Form::open(['route' => ['backend.settings.roles.user', $role->id], 'method' => 'put', 'id' => 'role-user-form']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Available Permissions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: scroll;">
                        <div class="container-fluid px-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                <i class="mdi mdi-magnify"></i>
                                                </span>
                                            </div>
                                            <input class="form-control" onkeyup="searchFilter(this.value, 'role-table');"
                                                   placeholder="Search Permission Name" id="search" type="search">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <table class="table table-hover table-sm mb-0" id="role-table">
                                        <thead class="thead-light">
                                        <tr class="text-center">
                                            <th width="35" class="p-2 align-middle">
                                                <div class="icheck-primary">
                                                    {!! Form::checkbox('test', 1,false, ['id' => 'role_all']) !!}
                                                    <label for="role_all"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">Permission</th>
                                            <th class="align-middle">Enabled</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($roles as $role)
                                            <tr class="@if($role->enabled == \App\Supports\Constant::ENABLED_OPTION) table-success @else table-danger @endif">
                                                <td class="p-2 text-center align-middle">
                                                    <div class="icheck-primary">
                                                        {!! Form::checkbox('roles[]', $role->id,
                                                            in_array($role->id, $availablePermissionIds),
                                                             ['id' => 'role_' . $role->id, 'class' => 'role-checkbox']) !!}
                                                        <label for="{{ 'role_' . $role->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{ $role->display_name }}</td>
                                                <td class="align-middle text-center">{{ \App\Supports\Constant::ENABLED_OPTIONS[$role->enabled] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center font-weight-bolder">
                                                    No Permission/Privileges Available
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    {!! \Form::close(); !!}
                </div>
            </div>
        </div>--}}
    <!-- Address Modal -->
        {{--    <div class="modal fade" id="staticBackdrop" data-backdrop="static"
                 data-keyboard="false" tabindex="-1"
                 aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Address Book</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                {!! \Form::hidden("address[{$type}][type]", $type) !!}
                                <div class="col-md-6">
                                    {!! \Form::nText("address[{$type}][representative]", 'Representative', null, false) !!}
                                    {!! \Form::nTel("address[{$type}][phone]", 'Phone', null, false) !!}
                                    {!! \Form::nTextarea("address[{$type}][street_address]", 'Street Address', old('street_address', $contact->first_name ?? null), false, ['rows' => 4]) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! \Form::nSelect("address[{$type}][country_id]", 'Country', $countries ?? [], null, false) !!}
                                    {!! \Form::nSelect("address[{$type}][state_id]", 'State', $states ?? [], null, false) !!}
                                    {!! \Form::nSelect("address[{$type}][city_id]", 'City', $cities ?? [], null, false) !!}
                                    {!! \Form::nText("address[{$type}][post_code]", 'Post/Zip Code', null, false) !!}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>--}}
        {!! \App\Supports\CHTML::confirmModal('User', ['export', 'delete', 'restore']) !!}
    </div>
@endsection

@push('plugin-script')

@endpush


@push('page-script')
    <script>
        const USER_ID = {{ $user->id }};
    </script>
    <script src="{{ asset('assets/js/pages/address-book.js') }}"></script>
    <script>
        $(function () {
            $.ajax({
                url: '{{ route('backend.settings.roles.ajax') }}',
                data: {paginate: false},
                contentType: 'application/json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                dataType: 'json',
                success: function (response) {

                },
                error: function (response) {

                }
            });

            $("#role_all").click(function () {
                if ($(this).prop("checked")) {
                    $(".role-checkbox").each(function () {
                        $(this).prop("checked", true);
                    });
                } else {
                    $(".role-checkbox").each(function () {
                        $(this).prop("checked", false);
                    });
                }
            });

            $("#role-user-form").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                var formUrl = $(this).attr('action');

                $.ajax({
                    url: formUrl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: "POST",
                    dateType: "JSON",
                    success: function (response) {
                        if (response.status === true) {
                            notify(response.message, response.level, response.title);
                            setTimeout(function () {
                                window.location.reload();
                            }, 5000);

                        } else {
                            notify(response.message, response.level, response.title);
                        }
                    },
                    error: function (error) {
                        var responseObject = error.responseJSON;

                        var message = responseObject.message;

                        for (var field in responseObject.errors) {
                            message += "<br><ul>";
                            for (var errorText of responseObject.errors[field]) {
                                message += ("<li>" + errorText + "</li>");
                            }
                            message += "</ul>";
                        }

                        notify(message, 'error', 'Error!');
                    }
                });
            });

        });
    </script>
@endpush

