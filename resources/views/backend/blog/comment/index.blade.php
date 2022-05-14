@extends('backend.layouts.app')

@section('title', __('menu-sidebar.Comments'))

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
    {!! \Html::linkButton(__('Add Comment'), 'backend.blog.comments.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.blog.comments', 0, ['color' => 'warning']) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($comments))
                        <div class="card-body p-0">
                            {!! \Html::cardSearch('search', 'backend.blog.comments.index',
                            ['placeholder' => 'Search Comment Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'comment-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">@sortablelink('id', '#')</th>
                                        <th>@sortablelink('user.name', __('common.User'))</th>
                                        <th class="text-center">@sortablelink('message', __('common.Message'))</th>
                                        <th class="text-center">@sortablelink('enabled', __('common.Enabled'))</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($comments as $index => $comment)
                                        <tr @if($comment->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search align-middle">
                                                {{ $comment->id }}
                                            </td>
                                            <td class="text-left pl-0">
                                                @include('backend.layouts.includes.user-media-card', ['dynamicUser' => $comment->user])
                                            </td>
                                            <td class="text-left">
                                                <button type="button" class="btn btn-xs p-0 border-0 d-inline mr-3 rounded-circle btn-light"
                                                        data-toggle="popover"
                                                        title="Comment Message"
                                                        data-placement="bottom"
                                                        data-content="{{ $comment->message ?? '' }}">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                @can('backend.blog.comments.show')
                                                    <a href="{{ route('backend.blog.comments.show', $comment->id) }}">
                                                        {{ \App\Supports\Utility::textTruncate(($comment->message ?? ''), 50) }}
                                                    </a>
                                                @else
                                                    {{ \App\Supports\Utility::textTruncate(($comment->message ?? ''), 50) }}
                                                @endcan
                                            </td>
                                            <td class="text-center exclude-search">
                                                {!! \Html::enableToggle($comment) !!}
                                            </td>
                                            <td class="text-center">{{ $comment->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! \Html::actionDropdown('backend.blog.comments', $comment->id, array_merge(['show', 'edit'], ($comment->deleted_at == null) ? ['delete'] : ['restore'])) !!}
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
                            {!! \App\Supports\CHTML::pagination($comments) !!}
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
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    });
</script>
@endpush
