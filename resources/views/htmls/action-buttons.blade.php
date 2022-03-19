<div class="d-flex justify-content-end">
    @if(in_array('show', $options) && Route::has($resourceRouteName . '.show'))
        @can($resourceRouteName . '.show')
            <a href="{{ route($resourceRouteName . '.show', $id) }}" title="{!! __('common.Show') !!}"
               class="btn btn-success btn-sm mx-1">
                <i class="mdi mdi-eye-outline fw-bold"></i>
            </a>
        @endcan
    @endif

    @if(in_array('edit', $options) && Route::has($resourceRouteName . '.edit'))
        @can($resourceRouteName . '.edit')
            <a href="{{ route($resourceRouteName . '.edit', $id) }}" title="{!! __('common.Edit') !!}"
               class="btn btn-warning btn-sm mx-1">
                <i class="mdi mdi-square-edit-outline fw-bold"></i>
            </a>
        @endcan
    @endif

    @if(in_array('delete', $options) && Route::has($resourceRouteName . '.destroy'))
        @can($resourceRouteName . '.destroy')
            <a href="{{ route('common.delete', [$resourceRouteName, $id]) }}" title="{!! __('common.Delete') !!}"
               class="btn btn-danger btn-sm mx-1 delete-btn">
                <i class="mdi mdi-close-thick fw-bold"></i>
            </a>
        @endcan
    @endif

    @if(in_array('restore', $options) && Route::has($resourceRouteName . '.restore'))
        @can($resourceRouteName . '.restore')
            <a href="{{ route($resourceRouteName . '.restore', $id) }}" title="{!! __('common.Restore') !!}"
               class="btn btn-secondary btn-sm mx-1">
                <i class="mdi mdi-delete-restore fw-bold"></i>
            </a>
        @endcan
    @endif
</div>
