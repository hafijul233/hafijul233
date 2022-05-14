@extends('backend.layouts.app')

@section('title', __('menu-sidebar.Newsletters'))

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
    {!! \Html::linkButton(__('Add Newsletter'), 'backend.blog.newsletters.create', [], 'fas fa-plus', 'success') !!}
    {{--{!! \Html::bulkDropdown('backend.blog.newsletters', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($newsLetters))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.blog.newsletters.index',
                            ['placeholder' => 'Search Comment Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'newsLetter-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('name', __('common.Name'))</th>
                                        <th>@sortablelink('email', __('common.Email'))</th>
                                        <th>@sortablelink('mobile', __('common.Mobile'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($newsLetters as $index => $newsLetter)
                                        <tr @if($newsLetter->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $newsLetter->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.blog.newsletters.show')
                                                    <a href="{{ route('backend.blog.newsletters.show', $newsLetter->id) }}">
                                                        {{ $newsLetter->name }}
                                                    </a>
                                                @else
                                                    {{ $newsLetter->name }}
                                                @endcan
                                            </td>
                                            <td>{{ $newsLetter->email ?? null }}</td>
                                            <td>{{ $newsLetter->mobile ?? null }}</td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($newsLetter) !!}
                                            </td>
                                            <td class="text-center">{{ $newsLetter->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.blog.newsletters', $newsLetter->id, array_merge(['show', 'edit'], ($newsLetter->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($newsLetters) !!}
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
