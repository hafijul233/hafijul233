<div class="container-fluid my-3">
    <div class="row d-flex @can('backend.dashboard') justify-content-md-between @else justify-content-md-end @endcan justify-content-center pr-3">
        @can('backend.dashboard')
            <a href="{{ route('backend.dashboard') }}"
               class="ml-3 btn btn-light font-weight-bold">
                <i class="fas fa-arrow-left"></i>
                {!! __('menu-sidebar.Dashboard') !!}
            </a>
        @endcan
        {!! \Form::open(['route' => 'translate-locale', 'method' => 'post']) !!}
        <div class="btn-group">
            <button type="button" class="font-weight-bold btn btn-default">
                <i class="fas fa-globe"></i>
            </button>
            <button type="submit" name="language" value="en"
                    class="font-weight-bold btn @if(session()->get('locale') == 'en') btn-success @else btn-default @endif">
                EN
            </button>
            <button type="submit" name="language" value="bd"
                    class="font-weight-bold btn @if(session()->get('locale') == 'bd') btn-success @else btn-default @endif">
                BN
            </button>
        </div>
        {!! \Form::close() !!}
    </div>
</div>