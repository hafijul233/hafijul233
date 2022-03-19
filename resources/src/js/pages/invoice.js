function userSelectDropdown(options) {
    $("#" + options.target).select2({
        width: "100%",
        placeholder: options.placeholder,
        /*minimumInputLength: 3,*/
        allowClear:true,
        ajax: {
            url: options.route,
            data: function (params) {
                return {
                    search: params.term,
                    type: 'public'
                }
            },
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            cache: false,
            delay:250,
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
}

/*function getRowTemplate(index) {
    return "{!! html_entity_decode(addslashes("<tr> <td width='50%'> " .
    (\Form::select('invoice[" + index + "][item]', [], null, ['class' => 'form-control item-select']) ) .
    "</td> <td> " .
    (\Form::number('invoice[" + index + "][price]', 0, ['class'=> 'form-control price', 'onchange'=>"updateInvoice();"]) ) .
    "</td><td> " .
    (\Form::number('invoice[" + index + "][quantity]', 0, ['class'=> 'form-control quantity', 'onchange'=>"updateInvoice();"]) ) .
    "</td><td> " .
    (\Form::number('invoice[" + index + "][total]', 0, ['class'=> 'form-control total', 'readonly' => 'readonly', 'onchange'=>"updateInvoice();"]) ) .
    "</td><td class='text-right' width='96'> " .
    "<button type='button' class='btn btn-sm btn-danger btn-block text-bold' onclick='removeRow(this);'>Remove</button> ".
    "</td></tr>")) !!}";
}*/

function updateInvoice() {
    var subTotalCol = $('#sub-total');
    var shipCostCol = $('#ship-cost');
    var discountCol = $('#discount');
    var grandTotalCol = $('#grand-total');

    var subTotal = 0, grandTotal = 0;

    $('table#invoice-table tbody tr').each(function () {
        var row = $(this);
        var priceCol = row.find('td input.price');
        var qtyCol = row.find('td input.quantity');
        var totalCol = row.find('td input.total');

        if (!isNaN(priceCol.val()) || !isNaN(qtyCol.val())) {
            var rate = parseFloat(priceCol.val());
            var qty = parseFloat(qtyCol.val());
            var total = rate * qty;
            subTotal += total;
            totalCol.val(total.toFixed(2));
        }
    });
    subTotalCol.val(subTotal.toFixed(2));

    if (!isNaN(discountCol.val())) {
        grandTotal = subTotal - parseFloat(discountCol.val());
    }

    console.log(shipCostCol.val());

    if (!isNaN(shipCostCol.val())) {

        grandTotal += parseFloat(shipCostCol.val());
    }

    grandTotalCol.val(grandTotal.toFixed(2));
}

function addRow(element) {
    var jqelement = $(element);
    var index = parseInt(jqelement.data('current-index'));
    $(getRowTemplate(index)).insertBefore(jqelement.parent().parent());
    jqelement.data('current-index', index + 1);

    updateInvoice();

    initItemDropDown();
}

function removeRow(element) {
    var r = $(element).parent().parent().remove();
    updateInvoice();
}

function formatResponseSelection(item) {
    return item.title || item.text;
}


function initItemDropDown() {
    $(".item-select").each(function () {
        $(this).select2({
            ajax: {
                url: "{{ route('sales.items') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search_text: params.term, // search term
                        page: params.page,
                        company_id: '{{ auth()->user()->userDetails->company_id }}'
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Select a Book/Course',
            minimumInputLength: 3,
            width: "100%",
            allowClear: true,
            escapeMarkup: function (item) {
                return item;
            },
            templateResult: function (item) {
                if (item.loading) {
                    return item.text;
                }

                return $(
                    `<div class="media">
                    <div class="media-left media-middle">
                        <img alt="64x64" class="media-object" style="width: 64px; height: 64px;"
                        src='` + item.image + `' data-holder-rendered="true">
                    </div>
                    <div class="media-body">
                        <p class="media-heading text-info text-bold">` + item.title + `</p>
                        <p><span class="badge badge-success" style='margin-right: 1rem;'> <i class="fa fa-tags"></i> ` + item.type + `</span>
                            <span style='margin-right: 1rem;'> <i class="fa fa-user"></i> ` + item.provider + `</span>
                            <span style='margin-right: 1rem;'> <i class="fa fa-usd"></i> ` + item.price + `</span>
                        </p>
                    </div>
                </div>`);
            },
            templateSelection: function (item) {
                return item.title || item.text;
            }

        });
    });
}

$(document).ready(function () {
    $('form#sales').validate({
        rules: {
            company: {
                required: true,
                min: 1
            }, branch: {
                min: 1
            },
            reference_number: {
                required: false
            },
            entry_date: {
                date: true,
                required: true
            },
            user: {
                digits: true
            },
            name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            phone: {
                required: true,
                minlength: 11,
                maxlength: 11,
            },
            email: {
                required: true
            },
            address: {
                required: false,
                minlength: 3
            }
        }
    });

/*    $("#user").change(function () {
        var user = $(this).val();
        var company = $('#company').val();
        if (user) {
            $.post('{{ route('users.find-user-have-id') }}', {
                user_id: user,
                company_id: company,
                '_token': CSRF_TOKEN
            },
                function (response) {
                    $("#name").val(response.name);
                    $("#phone").val(response.mobile_number);
                    $("#email").val(response.email);
                }, 'json');
        }
    });

    $("#coupon-apply").click(function () {
        var coupon = $("#coupon_code").val();
        var company = $('#company').val();
        var subTotalCol = $('#sub-total');

        if ((coupon.length > 3) && (!isNaN(subTotalCol.val()))) {
            $.post('{{ route('coupons.check') }}', {
                'company_id': company,
                'coupon_code': coupon,
                '_token': CSRF_TOKEN,
                'coupon_status': 'ACTIVE',
                'coupon_end_verify': 'YES',
                'coupon_end': 'CHECK'
            }, function (response) {
                if (response.status === true) {
                    alert(response.message);
                    var discountCol = $('#discount');
                    var discountAmount = 0;

                    var disAmt = parseFloat(response.coupon.discount_amount);
                    if (response.coupon.discount_type === 'percent') {
                        discountAmount = ((parseFloat(subTotalCol.val()) * disAmt) / 100) || 0;
                    } else {
                        discountAmount = disAmt || 0;
                    }

                    discountCol.val(discountAmount);
                    updateInvoice();
                } else {
                    alert(response.message);
                }
            }, 'json');
        }
    });*/

    if (selected_user_id.length > 0) {
        $("#user").val(selected_user_id);
        $("#user").trigger('change');

    }
    initItemDropDown();
});