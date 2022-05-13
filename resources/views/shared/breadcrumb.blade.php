@unless ($breadcrumbs->isEmpty())
    <nav aria-label="breadcrumb">
        <h4 class="mb-0">@yield('title')</h4>
        <ol class="breadcrumb bg-transparent p-0 mb-0 d-none d-sm-flex">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless
