{!! \Form::open(['route' => $route, 'method' => 'get']) !!}
<div class="row p-3">
    <div class="col-md-12">
        <div class="input-group">
            {!! \Form::search($field, old($field, (request()->get($field) ?? null)),
                array_merge(['class' => 'form-control'], $attributes)) !!}
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary input-group-right-btn">
                    <i class="fas fa-search"></i>
                    <span class="d-none d-md-inline">{!! __('common.Search') !!}</span>
                </button>
            </div>
        </div>
    </div>
</div>
{!! \Form::close() !!}
