@extends('layouts.app')

@section('title', __('menu-sidebar.Certificates'))

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
    {!! \Html::linkButton(__('portfolio.certificate.Add Certificate'), 'backend.portfolio.certificates.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.portfolio.certificates', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($certificates))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.portfolio.certificates.index',
                            ['placeholder' => 'Search Comment Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'certificate-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('title', __('portfolio.certificate.Title'))</th>
                                        <th>@sortablelink('organization', __('portfolio.certificate.Organization'))</th>
                                        <th>@sortablelink('issue_date', __('portfolio.certificate.Issue Date'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($certificates as $index => $certificate)
                                        <tr @if($certificate->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $certificate->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.portfolio.certificates.show')
                                                    <a href="{{ route('backend.portfolio.certificates.show', $certificate->id) }}">
                                                        {{ $certificate->title }}
                                                    </a>
                                                @else
                                                    {{ $certificate->title }}
                                                @endcan
                                            </td>
                                            <td>
                                                {{ $certificate->organization ?? null }}
                                            </td>
                                            <td>
                                                {{ $certificate->issue_date->format('F, Y') ?? null }}
                                            </td>

                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($certificate) !!}
                                            </td>
                                            <td class="text-center">{{ $certificate->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.portfolio.certificates', $certificate->id, array_merge(['show', 'edit'], ($certificate->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($certificates) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Certificate', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
