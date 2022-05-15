<!-- Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header  py-2 bg-warning">
                <h5 class="modal-title text-white">{{ $model ?? 'Item' }} Restore Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="restoreConfirmationForm">

            </div>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            //Restore  Modal Operation
            $("body").find(".restore-btn").each(function () {
                $(this).click(function (event) {
                    //stop href to trigger
                    event.preventDefault();
                    //ahref has link
                    var url = this.getAttribute('href');
                    if (url.length > 0 && url !== "#") {
                        //Ajax
                        $.get(url, function (response) {
                            $("#restoreConfirmationForm").empty().html(response);
                        }, 'html').done(function () {
                        }).fail(function (error) {
                            $("#restoreConfirmationForm").empty().html(error.responseText);
                        }).always(function () {
                            $("#restoreModal").modal({
                                backdrop: 'static',
                                show: true
                            });
                        });
                    }
                });
            });
        });
    </script>
@endpush