@if(config('backend.preloader') != null)
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset(config('backend.preloader')) }}"
             alt="{{ config('app.name') }}" height="60" width="60">
    </div>
@endif
