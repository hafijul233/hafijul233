@extends('layouts.app')

@section('title', 'Settings')

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



@section('breadcrumbs', \Breadcrumbs::render())

@section('actions')
    {!! \Html::linkButton('Add Setting', 'backend.settings.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.settings', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header p-0 border-bottom-0">
                        {!! \Html::cardSearch('search', 'backend.settings.index',
['placeholder' => 'Search Setting Name, Module, etc.',
'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'user-table']) !!}

                    </div>
                    @if(!empty($settings))
                        <div class="card-body min-vh-100 pt-0">
                            <div class="row">
                                @foreach($settings as $setting)
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="info-box shadow-sm">
                                <span class="info-box-icon shadow-lg" style="background-color: {{ $setting->color }}">
                                    <i class="{{ $setting->icon }} text-white"></i>
                                </span>
                                            <div class="info-box-content">
                                                <a href="{{ route($setting->route) }}"
                                                   class="h5 font-weight-bold info-box-text text-capitalize">{{ $setting->name }}</a>
                                                <span class="info-box-number text-muted font-weight-normal text-sm text-truncate">
                                            {{ $setting->description }}
                                        </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                @endforeach
                            </div>
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
    {!! \App\Supports\CHTML::confirmModal('Setting', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
