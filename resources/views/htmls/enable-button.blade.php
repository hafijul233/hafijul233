@if($model instanceof \Illuminate\Database\Eloquent\Model)
    <input type="checkbox" class="toggle-class" data-toggle="toggle" data-size="sm"
           data-onstyle="outline-success" data-offstyle="outline-danger" data-model="{{ get_class($model) }}"
           data-id="{{ $model->id }}" data-width="72" data-style="ios"
           data-on="<i class='fas fa-check'></i> {{ \App\Supports\Constant::ENABLED_OPTIONS[\App\Supports\Constant::ENABLED_OPTION] }}"
           data-off="<i class='fas fa-times'></i> {{ \App\Supports\Constant::ENABLED_OPTIONS[\App\Supports\Constant::DISABLED_OPTION] }}"
           data-onvalue="{{ \App\Supports\Constant::ENABLED_OPTION }}"
           data-offvalue="{{ \App\Supports\Constant::DISABLED_OPTION }}"
           @if($model->enabled == \App\Supports\Constant::ENABLED_OPTION) checked @endif
    >
{{--@else
    @php throw new \Exception('Input must be instance of Eloquent Model'); @endphp--}}
@endif
