@extends('layouts.app')

@section('title', __('menu-sidebar.Testimonials'))

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
    {!! \Html::linkButton(__('Add Testimonial'), 'backend.portfolio.testimonials.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.portfolio.testimonials', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($testimonials))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.portfolio.testimonials.index',
                            ['placeholder' => 'Search Comment Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'testimonial-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th class="text-center">@sortablelink('client', __('common.Client'))</th>
                                        <th class="text-center">@sortablelink('feedback', __('common.Feedback'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($testimonials as $index => $testimonial)
                                        <tr @if($testimonial->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $testimonial->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.portfolio.testimonials.show')
                                                    <a href="{{ route('backend.portfolio.testimonials.show', $testimonial->id) }}">
                                                        {{ $testimonial->client ?? null }}
                                                    </a>
                                                @else
                                                    {{ $testimonial->client ?? null }}
                                                @endcan
                                            </td>
                                            <td class="text-left">
                                                {{ $testimonial->feedback ?? null }}
                                            </td>

                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($testimonial) !!}
                                            </td>
                                            <td class="text-center">{{ $testimonial->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.portfolio.testimonials', $testimonial->id, array_merge(['show', 'edit'], ($testimonial->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($testimonials) !!}
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
