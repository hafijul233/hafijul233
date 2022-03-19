@extends('layouts.app')

@section('title', 'SmsTemplates')

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
    {!! \Html::linkButton('Add SmsTemplate', 'core.settings.smstemplates.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('core.settings.smstemplates', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($smstemplates))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'core.settings.smstemplates.index',
                            ['placeholder' => 'Search SmsTemplate Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'smstemplate-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="smstemplate-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')
                                        </th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($smstemplates as $index => $smstemplate)
                                        <tr @if($smstemplate->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $smstemplate->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('core.settings.smstemplates.show')
                                                    <a href="{{ route('core.settings.smstemplates.show', $smstemplate->id) }}">
                                                        {{ $smstemplate->name }}
                                                    </a>
                                                @else
                                                    {{ $smstemplate->name }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($smstemplate) !!}
                                            </td>
                                            <td class="text-center">{{ $smstemplate->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('core.settings.smstemplates', $smstemplate->id, array_merge(['show', 'edit'], ($smstemplate->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($smstemplates) !!}
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
    {!! \App\Supports\CHTML::confirmModal('SmsTemplate', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
