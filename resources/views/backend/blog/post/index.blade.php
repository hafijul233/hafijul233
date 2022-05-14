@extends('backend.layouts.app')

@section('title', __('menu-sidebar.Posts'))

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
    {!! \Html::linkButton(__('blog.post.Add Post'), 'backend.blog.posts.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.blog.posts', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($posts))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.blog.posts.index',
                            ['placeholder' => 'Search Comment Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'post-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('title', __('blog.post.Title'))</th>
                                        <th>@sortablelink('published_at', __('blog.post.Published'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($posts as $index => $post)
                                        <tr @if($post->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $post->id }}
                                            </td>
                                            <td class="text-left">
                                                @can('backend.blog.posts.show')
                                                    <a href="{{ route('backend.blog.posts.show', $post->id) }}">
                                                        {{ $post->title }}
                                                    </a>
                                                @else
                                                    {{ $post->title }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($post) !!}
                                            </td>
                                            <td class="text-center">{{ $post->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.blog.posts', $post->id, array_merge(['show', 'edit'], ($post->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($posts) !!}
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
