@extends('backend.layouts.app')

@section('title', __('menu-sidebar.Experiences'))

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
    {!! \Html::linkButton(__('resume.experience.Add Experience'), 'backend.resume.experiences.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.resume.experiences', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($experiences))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.resume.experiences.index',
                            ['placeholder' => 'Search Catalog Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'experience-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="experience-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('title', __('resume.experience.Title'))</th>
                                        <th>@sortablelink('organization', __('resume.experience.Organization'))</th>
                                        <th class="text-center">@sortablelink('employmentType.name', 'Type')</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($experiences as $index => $experience)
                                        <tr @if($experience->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $experience->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.resume.experiences.show')
                                                    <a href="{{ route('backend.resume.experiences.show', $experience->id) }}">
                                                        {{ $experience->title }}
                                                    </a>
                                                @else
                                                    {{ $experience->title }}
                                                @endcan
                                            </td>
                                            <td class="text-left">
                                                {{ $experience->organization ?? null }}
                                            </td>
                                            <td class="text-center">
                                                {!! (isset($experience->employmentType) ? $experience->employmentType->name : null) !!}
                                            </td>

                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($experience) !!}
                                            </td>
                                            <td class="text-center">{{ $experience->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.resume.experiences', $experience->id, array_merge(['show', 'edit'], ($experience->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($experiences) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Catalog', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
