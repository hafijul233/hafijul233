@extends('admin::layouts.master')

@section('title', 'System Logs')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('inline-style')
    <style>
        .text {
            word-break: break-all;
        }
    </style>
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
            <div class="col-sm-2">
                <div class="card card-default">
                    <h5 class="card-header text-center">Log Entries</h5>
                    <div class="card-body p-0">
                        <ul class="list-group p-0 list-group-flush">
                            @foreach($files as $file)
                                <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                                   class=" list-group-item list-group-item-action @if ($current_file == $file) active @endif">
                                    {{ \Modules\Admin\Supports\Utility::formatLogFilename($file) }}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="card card-default">
                    <h5 class="card-header text-center">Log Details</h5>
                    <div class="card-body min-vh-100">
                        <div class="pb-3 px-0 d-flex justify-content-center">
                            @if($current_file)
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                       title="Download"
                                       href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <i class="fa fa-download"></i>
                                        <span class="d-none d-sm-inline-flex">Download</span>
                                    </a>
                                    <a id="clean-log" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                       title="Clean"
                                       href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <i class="fa fa-eraser"></i>
                                        <span class="d-none d-sm-inline-flex">Clean</span>
                                    </a>
                                    <a id="delete-log" class="btn btn-warning" data-toggle="tooltip"
                                       data-placement="top" title="Delete"
                                       href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <i class="fa fa-trash"></i>
                                        <span class="d-none d-sm-inline-flex">Delete</span>
                                    </a>
                                    @if(count($files) > 1)
                                        <a id="delete-all-log" class="btn btn-danger" data-toggle="tooltip"
                                           data-placement="top" title="Delete All"
                                           href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                            <span class="fa fa-trash-alt"></span>
                                            <span class="d-none d-sm-inline-flex"> Delete All</span>

                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if ($logs === null)
                            <div class="alert alert-danger">
                                Log file >30M, please download it.
                            </div>
                        @else
                            <table id="table-log" class="table table-bordered table-striped"
                                   data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                                <thead>
                                <tr>
                                    @if ($standardFormat)
                                        <th>Level</th>
                                        <th>Context</th>
                                        <th>Date</th>
                                    @else
                                        <th>Line number</th>
                                    @endif
                                    <th>Content</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($logs as $key => $log)
                                    <tr data-display="stack{{{$key}}}">
                                        @if ($standardFormat)
                                            <td class="nowrap text-{{{$log['level_class']}}}">
                                    <span class="fa fa-{{{$log['level_img']}}}"
                                          aria-hidden="true"></span>
                                                {{ strtoupper($log['level']) }}
                                            </td>
                                            <td class="text">{{$log['context']}}</td>
                                        @endif
                                        <td class="date">{!! \Carbon\Carbon::parse($log['date'])->format('H:i:s') !!}</td>
                                        <td class="text">
                                            @if ($log['stack'])
                                                <button type="button" onclick="showContent(this);"
                                                        class="float-right look-btn expand btn btn-outline-dark btn-sm mb-2 ml-2"
                                                        data-display="stack{{{$key}}}">
                                                    <span class="fa fa-search"></span>
                                                </button>
                                            @endif
                                            {{{$log['text']}}}
                                            @if (isset($log['in_file']))
                                                <br/>{{{$log['in_file']}}}
                                            @endif
                                            @if ($log['stack'])
                                                <div class="stack" id="stack{{{$key}}}"
                                                     style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Large modal -->
    <div class="modal fade" id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title" id="exampleModalLongTitle">Log Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-black rounded-bottom" id="error-modal-content"
                     style="min-height: 80vh; overflow-y: scroll;">
                </div>
            </div>
        </div>
    </div>
@endsection


@push('plugin-script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endpush

@push('page-script')
    <script>
        var logTable = null;

        function showContent(element) {
            var container = $("<div style='color: limegreen;'></div>");
            container.html($(element).parent().html());

            container.find('.look-btn').each(function () {
                $(this).remove();
            });

            $("#error-modal-content").empty().append(container);
            $("#bd-example-modal-lg").modal();
        }

        $(document).ready(function () {
            $('.table-container tr').on('click', function () {
                $('#' + $(this).data('display')).toggle();
            });

            $('#delete-log, #clean-log, #delete-all-log').click(function () {
                return confirm('Are you sure?');
            });

            logTable = $('#table-log').DataTable({
                "order": [$('#table-log').data('orderingIndex'), 'desc'],
                "stateSave": true,
                "responsive": true,
                "info": true,
                "stateSaveCallback": function (settings, data) {
                    window.localStorage.setItem("datatable", JSON.stringify(data));
                },
                "stateLoadCallback": function (settings) {
                    var data = JSON.parse(window.localStorage.getItem("datatable"));
                    if (data) data.start = 0;
                    return data;
                }
            });
        });

        $(window).resize(function () {
            console.log(window.screen.width);
            //destroy existing instance
            logTable.destroy();
            //re-init instance
            logTable = $("#table-log").DataTable({
                "order": [$('#table-log').data('orderingIndex'), 'desc'],
                "stateSave": true,
                "responsive": true,
                "info": true,
                "stateSaveCallback": function (settings, data) {
                    window.localStorage.setItem("datatable", JSON.stringify(data));
                },
                "stateLoadCallback": function (settings) {
                    var data = JSON.parse(window.localStorage.getItem("datatable"));
                    if (data) data.start = 0;
                    return data;
                }
            });
        });

    </script>
@endpush
