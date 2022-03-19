@extends('admin::layouts.master')

@section('title', 'Admin Panel')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

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
        <div class="card card-default">
            <div class="card-body p-0 min-vh-100">

            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
