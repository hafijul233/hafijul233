@extends('backend.layouts.app')

@section('title', __('menu-sidebar.Educations'))

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
    {!! \Html::linkButton(__('resume.education.Add Education'), 'backend.resume.educations.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.resume.educations', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($educations))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.resume.educations.index',
                            ['placeholder' => 'Search Comment Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'education-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('degree', __('resume.education.Degree'))</th>
                                        <th>@sortablelink('institute', __('resume.education.Institute'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($educations as $index => $education)
                                        <tr @if($education->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $education->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.resume.educations.show')
                                                    <a href="{{ route('backend.resume.educations.show', $education->id) }}">
                                                        {{ $education->degree }} of {{ $education->field }}
                                                    </a>
                                                @else
                                                    {{ $education->degree }} of {{ $education->field }}
                                                @endcan
                                            </td>
                                            <td>{{ $education->institute ?? null }}</td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($education) !!}
                                            </td>
                                            <td class="text-center">{{ $education->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.resume.educations', $education->id, array_merge(['show', 'edit'], ($education->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($educations) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Post', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
