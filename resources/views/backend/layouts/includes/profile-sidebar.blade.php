@push('plugin-style')
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endpush

<div class="card border-0">
    <div class="card-body box-profile border-0">
        <div class="text-center">
            <a data-remote="{{ $user->getFirstMediaUrl('avatars') }}" data-toggle="lightbox"
               data-title="{{ $user->name }}" data-type="image">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ $user->getFirstMediaUrl('avatars') }}"
                     alt="{{ $user->name }}" width="128">
            </a>
        </div>
        <h3 class="profile-username text-center text-truncate"
            data-toggle="tooltip" data-placement="top" title="{{ $user->name }}">
            {{ $user->name }}
        </h3>

        @if($user->roles->count() > 0)
            <p class="text-muted text-center mb-3">
                {{ implode(", ", $user->roles->pluck('name')->toArray()) }}
            </p>
        @endif

        @if($user->username != null)
            <div class="d-flex align-items-center justify-content-between pb-1 font-weight-bold text-dark">
                Username
                <span class="text-muted font-weight-normal">{{ $user->username }}</span>
            </div>
        @endif

        @if($user->email != null)
            <div class="d-flex align-items-center justify-content-between pb-1 font-weight-bold text-dark">
                Email
                <span class="text-muted font-weight-normal">{{ $user->email }}</span>
            </div>
        @endif

        @if($user->mobile != null)
            <div class="d-flex align-items-center justify-content-between pb-1 font-weight-bold text-dark">
                Mobile
                <span class="text-muted font-weight-normal">{{ $user->mobile }}</span>
            </div>
        @endif

        <div class="list-group list-group-flush mt-3">
            <a href="{{ route('backend.settings.users.show', $user->id) }}"
               class="rounded list-group-item list-group-item-action @if(\Route::is('backend.settings.users.show')) active @endif">
                <span class="@if(\Route::is('backend.settings.users.show')) font-weight-bold @endif">
                <i class="fa fa-user-circle mr-2"></i>
                    Profile Detail
                </span>
            </a>

        </div>
    </div>
    <!-- /.card-body -->
</div>

@push('plugin-script')
    <!-- Ekko Lightbox -->
    <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
@endpush

@push('page-script')
    <script>
        $(function () {
            $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
        });
    </script>
@endpush
