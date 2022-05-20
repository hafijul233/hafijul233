<!-- Modal -->
<div class="modal fade" id="importConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Selection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="get" id="importOptionForm">
            <div class="modal-body">
                @hasrole(\App\Supports\Constant::SUPER_ADMIN_ROLE)
                {!! \Form::nRadio('with_trashed', 'Include Trashed',
                     ['yes' => 'With Trashed', 'no' => 'Exclude Trashed'], 'no') !!}
                @endhasrole
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            //Import modal operations
            $("body").find(".import-btn").each(function () {
                $(this).click(function (event) {
                    //stop href to trigger
                    event.preventDefault();
                    $("#importOptionForm").attr('action', $(this).attr('href'));
                    $("#importConfirmModal").modal();
                });
            });

            $("body").find("#importOptionForm").each(function () {
                $(this).submit(function (event) {
                    event.preventDefault();
                    var search = window.location.search;
                    if (search.length === 0) {
                        search = "?";
                    }
                    var formAction = $(this).attr('action') + search + "&format=" + $("#format").val();
                    var deleted = $('#exportOptionForm input[name=with_trashed]:radio');
                    if (deleted) {
                        formAction += "&with_trashed=" + deleted.val();
                    }
                    window.location.href = formAction;
                });
            });
        });
    </script>
@endpush