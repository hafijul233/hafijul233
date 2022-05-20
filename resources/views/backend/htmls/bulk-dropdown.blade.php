@canany([$resourceRouteName . '.exports.show', $resourceRouteName . '.edit',
        $resourceRouteName . '.destroy', $resourceRouteName . '.restore'])
    <div class="dropdown d-inline-block">
        <button class="btn btn-{{ $options['color'] ?? 'warning' }} dropdown-toggle"
                type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-sliders-h"></i>
            <span class="d-none d-md-inline-flex ml-2">{!! __('common.Actions') !!}</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            {{--
            @if(\Route::has($resourceRouteName . '.destroy'))
                @can($resourceRouteName . '.destroy')
                    <a href="{{ route('admin.common.delete', [$resourceRouteName, $id]) }}" title="Delete"
                       class="dropdown-item py-2 px-3 link-muted delete-btn">
                        <i class="fas fa-trash  mr-2"></i> Delete
                    </a>
                @endcan
            @endif

            @if(\Route::has($resourceRouteName . '.restore'))
                @can($resourceRouteName . '.restore')
                    <a href="{{ route('admin.common.delete', [$resourceRouteName, $id]) }}" title="Restore"
                       class="dropdown-item py-2 px-3 link-muted delete-btn">
                        <i class="fas fa-trash-restore  mr-2"></i> Restore
                    </a>
                @endcan
            @endif
            --}}

            @if(\Route::has($resourceRouteName . '.import'))
                @can($resourceRouteName . '.import')
                    <a href="{{ route($resourceRouteName . '.import') }}" title="Import"
                       class="dropdown-item py-2 px-3 import-btn link-muted">
                        <i class="fas fa-file-import mr-2"></i> {!! __('common.Import') !!}
                    </a>
                @endcan
            @endif

            @if(\Route::has($resourceRouteName . '.export'))
                @can($resourceRouteName . '.export')
                    <a href="{{ route($resourceRouteName . '.export') }}" title="Export"
                       class="dropdown-item py-2 px-3 link-muted export-btn">
                        <i class="fas fa-file-export mr-2"></i> {!! __('common.Export') !!}
                    </a>
                @endcan
            @endif

            @if(\Route::has($resourceRouteName . '.print'))
                @can($resourceRouteName . '.print')
                    <a href="{{ route($resourceRouteName . '.print') }}" title="Print"
                       class="dropdown-item py-2 px-3 print-btn link-muted">
                        <i class="fas fa-print mr-2"></i> {!! __('common.Print') !!}
                    </a>
                @endcan
            @endif
        </div>
    </div>
@endcanany
