@extends('admin::layouts.master')

@section('title', 'Notifications')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@push('inline-style')
@endpush

@push('head-script')

@endpush

@section('body-class', 'sidebar-mini')

@section('breadcrumbs', \Breadcrumbs::render())

@section('actions')
    {!! \Html::backButton('admin.') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('admin::common.notification.partials.sidebar')
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-default">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                @forelse($notifications as $notification)
                                    <tr>
                                        <td>
                                            <div class="icheck-primary">
                                                <input type="checkbox" value="" id="check1">
                                                <label for="check1"></label>
                                            </div>
                                        </td>
                                        <td class="media">
                                            <div class="align-self-center">
                                                @if($notification->data['has_image'] == true)
                                                    <img src="" class="align-self-center mr-3 img-circle elevation-2" alt="...">
                                                @else
                                                    <span style="width: 65px; height: 65px"
                                                        class="{{ $notification->data['icon_background'] }}">
                                                        <i class="{{ $notification->data['icon_class'] }}" style="font-size: 3rem"></i>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <h5 class="mt-0">{!! $notification->data['title'] !!}</h5>
                                                <div
                                                    class="d-block mb-0">{!!  $notification->data['description'] !!}</div>
                                            </div>
                                        </td>
                                        <td class="mailbox-attachment"></td>
                                        <td class="mailbox-date">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</td>
                                    </tr>
                                @empty

                                @endforelse
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
