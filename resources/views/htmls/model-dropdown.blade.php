@if(!empty($options['actions']))
    @canany([$resourceRouteName . '.edit', $resourceRouteName . '.destroy', $resourceRouteName . '.restore'])
        <div class="dropdown d-inline-block  m-1 m-md-0">
            <button class="btn btn-{{ $options['color'] ?? 'warning' }} dropdown-toggle"
                    type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-sliders-h"></i>
                <span class="d-none d-md-inline-flex ml-2">Actions</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                @if(in_array('edit', $options['actions']) && \Route::has($resourceRouteName . '.edit'))
                    @can($resourceRouteName . '.edit')
                        <a href="{{ route($resourceRouteName . '.edit', $id) }}" title="Edit"
                           class="dropdown-item py-2 px-3 link-muted">
                            <i class="fas fa-edit mr-2"></i> Edit</a>
                    @endcan
                @endif

                @if(in_array('delete', $options['actions']) && \Route::has($resourceRouteName . '.destroy'))
                    @can($resourceRouteName . '.destroy')
                        <a href="{{ route('backend.common.delete', [$resourceRouteName, $id]) }}" title="Delete"
                           class="dropdown-item py-2 px-3 link-muted delete-btn">
                            <i class="fas fa-trash  mr-2"></i> Delete
                        </a>
                    @endcan
                @endif

                @if(in_array('restore', $options['actions']) && \Route::has($resourceRouteName . '.restore'))
                    @can($resourceRouteName . '.restore')
                        <a href="{{ route('backend.common.restore', [$resourceRouteName, $id]) }}" title="Restore"
                           class="dropdown-item py-2 px-3 link-muted delete-btn">
                            <i class="fas fa-trash-restore  mr-2"></i> Restore
                        </a>
                    @endcan
                @endif
            </div>
        </div>
    @endcanany
@endif
