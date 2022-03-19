<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-success btn-sm" id="select-all-checkbox">
        <i class="mdi mdi-check-all"></i> Select All
    </button>
    <button type="button" class="btn btn-secondary btn-sm" id="unselect-all-checkbox">
        <i class="mdi mdi-close-outline"></i> UnSelect All
    </button>
</div>

@once
    @push('page-script')
        <script>
            $(function () {
                $("#select-all-checkbox").click(function () {
                    $(".{{ $target }}").each(function () {
                        $(this).prop("checked", true);
                    });
                });

                $("#unselect-all-checkbox").click(function () {
                    $(".{{ $target }}").each(function () {
                        $(this).prop("checked", false);
                    });
                });
            });
        </script>
    @endpush
@endonce
