<div class="media">
    <img class="align-self-center mr-1 img-circle direct-chat-img elevation-1"
         src="{{ $dynamicUser->getFirstMediaUrl('avatars') }}" alt="{{ $dynamicUser->name }}">
    <div class="media-body">
        <p class="my-0">
            @if(auth()->user()->can('backend.settings.users.show') || $dynamicUser->id === auth()->user()->id)
                <a href="{{ route('backend.settings.users.show', $dynamicUser->id) }}">
                    {{ $dynamicUser->name }}
                </a>
            @else
                {{ $dynamicUser->name }}
            @endif
        </p>
        <p class="mb-0 small">{{ $dynamicUser->username }}</p>
    </div>
</div>