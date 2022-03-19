@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush

@push('page-style')
    <style>
        span[aria-labelledby="select2-user_id-container"],
        span[aria-labelledby="select2-receiver_id-container"] {
            height: calc(7.60rem + 2px) !important;
        }

        span[aria-labelledby="select2-user_id-container"] span.select2-selection__arrow,
        span[aria-labelledby="select2-receiver_id-container"] span.select2-selection__arrow {
            margin-top: calc(2.50rem);
        }

        span#select2-user_id-container,
        span#select2-receiver_id-container {
            margin-top: calc(2.50rem);
        }
    </style>
@endpush

<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            {!! \Form::nText('number', 'Invoice Number', old('number', $invoice->number ?? null), true) !!}
            {!! \Form::nDate('invoiced_at', 'Invoice Date',
                    old('invoiced_at', $invoice->invoiced_at ?? \Carbon\Carbon::now()->format('Y-m-d')), true,
                     ['class' => 'form-control date-range-picker']) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nSelect('user_id', 'Sender', [], old('user_id', ($invoice->user_id ?? null)),
 true, ['placeholder' => 'Select Sender', 'custom-select customer-select2']) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nSelect('receiver_id', 'Receiver', [], old('receiver_id', ($invoice->receiver_id ?? null)), true, ['placeholder' => 'Select Receiver']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-12 table-responsive">

            <table class="table table-center table-hover">
                <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Quantity</th>
                    <th>Items</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="invoice-body">
                @for($index=0;$index<10; $index++)
                    <tr class="invoice-item">
                        <td style="width: 40px;" class="align-content-center text-center pr-0 pb-0">
                            <button class="btn btn-outline-secondary  btn-sm remove-btn">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </td>
                        <td class="pb-0">
                            {!! \Form::iNumber("item_quantity_{$index}", 'Quantity', '0.00', true, null, 'before', ['placeholder' => 'Enter Item Quantity', 'class' => 'form-control text-right']) !!}
                        </td>
                        <td class="pb-0">
                            {!! \Form::iText("item_name_{$index}", 'Name', null, true, null, 'before', ['placeholder' => 'Enter Item Name']) !!}
                            <div class="detail-panel">
                                {!! \Form::iTextarea("item_description_{$index}", 'Description', null, false, null, 'before', ['placeholder' => 'Enter Item Description', 'rows' => 2 ]) !!}
                            </div>
                        </td>
                        <td class="pb-0">
                            <div class="row">
                                <div class="col-12">
                                    {!! \Form::iNumber("item_price_{$index}", 'Price', '0.00', true, null, 'before', ['placeholder' => 'Enter Item Price', 'class' => 'form-control text-right']) !!}
                                </div>
                            </div>
                            <div class="row detail-panel">
                                <div class="col-6">
                                    {!! \Form::nText("item_dimension_{$index}", 'Dimension', null, false, ['placeholder' => 'Enter Item Dimension', 'class' => 'form-control dimension-field']) !!}
                                </div>
                                <div class="col-6">
                                    {!! \Form::nNumber("item_weight_{$index}", 'Weight', '0.00', false, ['placeholder' => 'Enter Item Weight', 'class' => 'form-control text-right']) !!}
                                </div>
                            </div>
                        </td>
                        <td class="pb-0">
                            {!! \Form::iNumber("item_total_{$index}", 'Amount', '0.00', false, null, 'before', ['placeholder' => 'Enter Item Total', 'class' => 'form-control bg-white text-right']) !!}
                        </td>
                        <td>
                            <a href="#" class="text-secondary detail-panel-btn">
                                <i class="fas fa-angle-double-down"></i>
                            </a>
                        </td>
                    </tr>
                @endfor
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="7" class="px-0">
                        {!! \Form::iSelect('item_query', 'Items', [], null, true, null, 'before', ['class' => 'form-control custom-select item-query-select2']) !!}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {!! \Form::nTextarea('remarks', 'Remarks', old('remarks', $invoice->remarks ?? null), false) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 justify-content-between d-flex">
            {!! \Form::nCancel(__('common.Cancel')) !!}
            {!! \Form::nSubmit('submit', __('common.Save')) !!}
        </div>
    </div>
</div>

@push('page-script')
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/invoice.min.js') }}"></script>
    <script>
        const customer_ajax_route = "{{ route('backend.shipment.customers.ajax') }}";
        var selected_user_id = '{{ old('user_id', $invoice->user_id ?? null) }}';
        var selected_receiver_id = '{{ old('receiver_id', $invoice->receiver_id ?? null) }}';
        const defaultMedia = '{{ asset(\App\Supports\Constant::USER_PROFILE_IMAGE) }}' + "##";
        $(function () {
            $(".dimension-field").inputmask('999X999X999', {'placeholder': '___X___X___'});
            $(".detail-panel").addClass('d-none');
            $(".detail-panel-btn").on("click", function () {
                $(".detail-panel").toggleClass('d-none');
            });

            userSelectDropdown({
                target: "user_id",
                placeholder: "Select a Sender",
                route: customer_ajax_route
            });
            userSelectDropdown({
                target: "receiver_id",
                placeholder: "Select a Receiver",
                route: customer_ajax_route
            });

            $(".item-query-select2").select2({
                width: "100%",
                placeholder: "Please Select Item",
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('backend.shipment.items.ajax') }}",
                    data: function (params) {
                        return {
                            user: $("#user_id").val(),
                            search: params.term,
                            type: 'public-v2'
                        }
                    },
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    cache: false,
                    processResults: function (response) {
                        var returnObject = {results: []};
                        if (response.status === true) {
                            var options = [];
                            response.data.forEach(function (customer) {
                                var id = customer.id;
                                var text = '';
                                if (customer.media.length > 0) {
                                    var avatarImage = customer.media.pop();
                                    text = avatarImage.original_url + "##";
                                } else {
                                    text = defaultMedia + "##";
                                }

                                text += (customer.name + "##") + (customer.mobile + "##") + (customer.username + "##");

                                options.push({
                                    "id": id,
                                    "text": text
                                });
                            });
                            returnObject.results = options;
                        } else {
                            notify("No Active Senders Found", 'warning', 'Alert!');
                        }
                        return returnObject;
                    }
                },
                templateResult: function (item) {
                    if (!item.id) {
                        return item.text;
                    }
                    var itemValues = item.text.trim().split("##");
                    return $('<div class="media">\
                                <img class="align-self-center mr-1 img-circle direct-chat-img elevation-1"\
                                 src="' + itemValues[0] + '" alt="' + itemValues[1] + '">\
                                <div class="media-body">\
                                    <p class="my-0 text-dark">' + itemValues[1] + '</p>\
                                    <p class="mb-0 small">\
                                    <span class="text-muted"><i class="fas fa-user"></i> ' + itemValues[3] + '</span>\
                                    <span class="ml-1 text-muted"><i class="fas fa-phone"></i> ' + itemValues[2] + '</span>\
                                    </p>\
                                </div>\
                            </div>');
                },
                templateSelection: function (item) {
                    if (!item.id) {
                        return item.text;
                    }
                    var itemValues = item.text.trim().split("##");
                    return $('<p class="my-0 text-dark font-weight-bold d-flex justify-content-between align-content-center">\
                    <span><i class="fas fa-user text-muted"></i> ' + itemValues[1] + '</span>\
                        <span><i class="fas fa-phone text-muted"></i> ' + itemValues[2] + '</span></p>');
                }
            });

        });
    </script>
@endpush
