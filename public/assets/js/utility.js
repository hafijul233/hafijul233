
/**
 *
 * @param dest target object
 * @param data received data
 * @param id data pointer that will be value
 * @param text data pointer that will be option text
 * @param selected prefill an options
 * @param msg default message to display as placeholder
 */
function dropdownFiller(dest, data, id, text, selected = null, msg = 'Select an option') {
    dest.empty();
    var optionDOMElement = $("<option></option>").attr({"value": null, "selected": "selected"}).text(msg);
    dest.append(optionDOMElement);

    if (data.length > 0) {
        $.each(data, function (key, value) {
            var selectedStatus = "";
            if (selected == value[id]) {
                selectedStatus = "selected";
            }
            var option = $("<option></option>").attr({
                "value": value[id],
                "selected": selectedStatus
            }).text(value[text]);
            dest.append(option);
        });
        //if destination DOM have select 2 init
        if (selectedStatus.length > 3) {
            dest.val(selected);

            if (dest.data('select2-id'))
                dest.trigger('change.select2');
            else
                dest.trigger('change');
        }
    }
}

/**
 * @param route to get json
 * @param options Object {params: JSObject, target: JQueryObject, value: string, text: string ,selected: string , message: string}
 */
function populateDropdown(route, options) {
    if (typeof options === "object") {
        options.params = (options.hasOwnProperty('params')) ? options.params : {};
        options.target = (options.hasOwnProperty('target')) ? options.target : $("body");
        options.value = (options.hasOwnProperty('value')) ? options.value : 'id';
        options.text = (options.hasOwnProperty('text')) ? options.text : 'name';
        options.selected = (options.hasOwnProperty('selected')) ? options.selected : null;
        options.message = (options.hasOwnProperty('message')) ? options.message : 'Please select a option';

        $.getJSON(route, options.params, function (response) {
            if (response.status === true) {
                dropdownFiller(options.target, response.data,
                    options.value, options.text,
                    options.selected, options.message);
            } else {
                options.target.empty();
                var optionDOMElement = $("<option></option>").attr({
                    "value": null,
                    "selected": "selected"
                }).text(options.message);
                options.target.append(optionDOMElement);
            }
        }).fail(function (jqXHR, textStatus, error) {
            options.target.empty();
            var optionDOMElement = $("<option></option>").attr({
                "value": null,
                "selected": "selected"
            }).text(options.message);
            options.target.append(optionDOMElement);
            console.log(jqXHR, textStatus, error);
        });
    }
}

/**
 * Mark search keyword in table
 *
 * @param searchElement
 * @param targetTable
 */
function highLightQueryString(searchElement, targetTable) {
    var JqSearchElement = $("#" + searchElement);
    var JqTargetTable = $("#" + targetTable);

    var searchText = JqSearchElement.val();
    var searchTextLength = searchText.length;
    //only if search text in not empty
    if (searchTextLength > 0) {
        JqTargetTable.find("tr").each(function () {

            $(this).find("td").each(function () {

                var tableCell = $(this);

                if (!tableCell.hasClass("exclude-search")) {

                    var innerHtml = tableCell.html();

                    var patternPosition = innerHtml.search(new RegExp(searchText, "igmsu"));

                    if (patternPosition !== -1) {
                        var innerContent = innerHtml.substr(patternPosition, searchTextLength);

                        tableCell.html(
                            innerHtml.replace(innerContent,
                                "<span class='text-dark bg-warning py-1 px-0'>" + innerContent + "</span>"
                            )
                        );
                    }

                }
            });
        });
    }
}

/**
 * Filter Table Row based on search Query
 *
 * @param filter
 * @param targetTable
 */
function searchFilter(filter, targetTable) {
    $("#" + targetTable).find("tbody tr").each(function () {
        var row = $(this);
        if (filter.length >= 1) {
            var cellText = row.find("td").eq(1).text();
            if (cellText.toLowerCase().indexOf(filter.toLowerCase()) < 0) {
                row.hide();
            } else {

            }
        } else {
            row.show();
        }
    });
}

/**
 * Validation Type
 * @param fileType
 * @returns {{error: string, status: boolean}}
 */
function fileTypeValidation(fileType) {
    if (fileType != 'image/png' && fileType != 'image/jpg' &&
        fileType != 'image/gif' && fileType != 'image/jpeg') {

        return {
            "status": false,
            "error": "<b>Invalid File Type (" + fileType + ")</b>. Allowed (.jpg, .png, .gif)."
        };
    } else {
        return {
            "status": true,
            "error": "<b>Valid File Type (" + fileType + ")</b>."
        };
    }
}

/**
 * File Validation Size
 * @param fileSize
 * @param minSize
 * @param maxSize
 * @returns {{error: string, status: boolean}}
 */
function fileSizeValidation(fileSize, minSize, maxSize) {
    if (fileSize < minSize || fileSize > maxSize) {
        return {
            "status": false,
            "error": "<b>Invalid File Size( " + fileSize.toFixed(2) + " kb)</b>." +
                " Allowed between " + minSize + " kb to " + maxSize + " kb"
        };
    } else
        return {
            "status": true,
            "error": "<b>Valid File Size (" + fileSize + "kb)</b>."
        };
}

/**
 * Resolution Validation
 * @param imgWidth
 * @param imgHeight
 * @param minWidth
 * @param minHeight
 * @param maxWidth
 * @param maxHeight
 * @param stdRatio
 * @returns {{error: string, status: boolean}}
 */
function imageResolutionValidation(imgWidth, imgHeight, minWidth, minHeight, maxWidth, maxHeight, stdRatio) {
    var ratio = (imgWidth / imgHeight).toPrecision(3);
    /* Maximum Width */
    if (imgWidth > maxWidth || imgHeight > maxHeight) {
        return {
            "status": false,
            "error": "<b>Invalid Resolution( Width: " + imgWidth + " px , Height: " + imgHeight + "px )</b>." +
                " Allowed maximum width: " + maxWidth + "px , height: " + maxHeight + "px."
        }

    }
    /* Minimum Width */
    else if (imgWidth < minWidth || imgHeight < minHeight) {
        return {
            "status": false,
            "error": "<b>Invalid Resolution( Width: " + imgWidth + " px , Height: " + imgHeight + "px )</b>." +
                " Allowed minimum width: " + minWidth + "px , height:  " + minHeight + "px."
        }
    }
    /* Image Ratio */
    else if (ratio != stdRatio) {
        return {
            "status": false,
            "error": "<b>Invalid Image Scale ( Ratio: " + ratio + " )</b>." +
                " Allowed Ratio Scale of " + stdRatio + "."
        };

    } else {
        return {
            "status": true,
            "error": "<b>Image Validation Successful.</b>"
        };
    }
}


function notify(message, level = 'success', title = '') {
    if (window.toastr != undefined) {
        switch (level) {
            case 'success' :
                toastr.success(message, title, []);
                break;

            case 'danger':
            case 'error' :
                toastr.error(message, title, []);
                break;

            case 'warning' :
                toastr.warning(message, title, []);
                break;

            case 'info' :
                toastr.warning(message, title, []);
                break;

            default :
                toastr.success(message, title, []);
                break;
        }
    }
}

/***************************************** JQuery Validation **********************************/
if (typeof $.validator === 'function') {

    //default proof
    var proof = null;
    var fileSize = 0;


//Set Template for Error Validation
    $.validator.setDefaults({
        errorElement: "span",
        errorClass: "invalid-feedback",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                if (element.next('span'))
                    element.next('span').replaceWith(error);
                else
                    error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });
    //regex match method
    $.validator.addMethod("regex", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input.(Invalid Format)"
    );

    //name match method
    $.validator.addMethod("nametitle", function (value, element) {
            return this.optional(element) || /[a-zA-Z\s]+$/.test(value);
        },
        "Please enter only alphabets and spaces."
    );

    //mobile number match method
    $.validator.addMethod("mobilenumber", function (value, element) {
            return this.optional(element) || /^01[0-9]{9}$/.test(value);
        },
        "Please enter value on this 01XXXXXXXXX format."
    );

    //applicant's id & password match method
    $.validator.addMethod("credential", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]{8,10}$/.test(value);
        },
        "Please enter only alphabet and numbers."
    );

    $.validator.addMethod("filesize", function (value, element) {
            return !!(this.optional(element) || (value < 50 || value > 1000));
        },
        "Please enter file size between 50 kb to 1000 kb"
    );

    $.validator.addMethod("noSpace", function (value, element) {
            return this.optional(element) || value.indexOf(" ") < 0 && value.length >= 1;
        },
        "No space please and don't leave it empty"
    );

    $.validator.addMethod("username", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9\-\.]+$/i.test(value);
        },
        "Letters, numbers, hyphen sign and dot only please"
    );

    $.validator.addMethod("notEqualPassword", function (value, element, param) {
        return this.optional(element) || value !== param;
    }, "Old/Temporary password should not match with new password.");

    //@TODO current message set to 8 MB need some improvements
    $.validator.addMethod("videofilesize", function (value, element, param) {
            //console.log(element.files[0].size);
            return this.optional(element) || (element.files[0].size <= param);
        },
        "Upload Max File Size Limit 8MB. Try another file."
    );

    /*
        //AJAx Based Unique user name confirm
        /!**
         * @param value inout field value
         * @param element input field
         * @param id user id for edit except purpose
         *!/
        $.validator.addMethod('uniqueusername', function (value, element, id) {
            $.post(USERNAME_FIND_URL, {username: value, _token: CSRF_TOKEN, user_id: id}, function (response) {
                if (response.status == 200)
                    proof = response.data;
                else
                    proof = false;
            }, 'json');
            return this.optional(element) || proof;

        }, "Username already taken, Try another one");

        /!**
         * @param value inout field value
         * @param element input field
         * @param id user id for edit except purpose
         *!/
        $.validator.addMethod('uniqueemail', function (value, element, id) {
            $.post(EMAIL_FIND_URL, {email: value, user_id: id, _token: CSRF_TOKEN}, function (response) {
                if (response.status == 200)
                    proof = response.data;
                else
                    proof = false;
            }, 'json');
            return this.optional(element) || proof;

        }, "Email Address already taken, Try another one");
    */

    /**
     * @param value inout field value
     * @param element input field
     * @param paramDate max date limit
     */
    $.validator.addMethod("maxDate", function (value, element, paramDate = null) {

        var inputDate = new Date(value);
        var compareDate = new Date(paramDate);

        return this.optional(element) || (new Date(value) <= new Date(paramDate));
    }, "Input date cannot be greater then current date.");

    /**
     * @param value inout field value
     * @param element input field
     * @param paramDate max date limit
     */
    $.validator.addMethod("minDate", function (value, element, paramDate = null) {

        var inputDate = new Date(value);
        var compareDate = new Date(paramDate);
        return this.optional(element) || (inputDate >= compareDate);
    }, "Input date cannot be smaller then birth date.");
}

$(document).ready(function () {
    //Enable Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //Delete  Modal Operation
    $("body").find(".delete-btn").each(function () {
        $(this).click(function (event) {
            //stop href to trigger
            event.preventDefault();
            //ahref has link
            var url = this.getAttribute('href');
            if (url.length > 0 && url !== "#") {
                //Ajax
                $.get(url, function (response) {
                    $("#deleteConfirmationForm").empty().html(response);
                }, 'html').done(function () {
                }).fail(function (error) {
                    $("#deleteConfirmationForm").empty().html(error.responseText);
                }).always(function () {
                    $("#deleteModal").modal({
                        backdrop: 'static',
                        show: true
                    });
                });
            }
        });
    });

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

    //Export modal operations
    $("body").find(".export-btn").each(function () {
        $(this).click(function (event) {
            //stop href to trigger
            event.preventDefault();
            $("#exportOptionForm").attr('action', $(this).attr('href'));
            $("#exportConfirmModal").modal();
        });
    });

    $("body").find("#exportOptionForm").each(function () {
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

    //Enabled Status operation
    $("body").find(".toggle-class").each(function () {
        $(this).change(function (event) {
            //stop href to trigger
            event.preventDefault();
            var toggleSwitch = $(this);

            var toggleCurrentState = toggleSwitch.prop("checked");

            var fieldData = (toggleSwitch.prop("checked") === true)
                ? toggleSwitch.data("onvalue")
                : toggleSwitch.data("offvalue");

            $.ajax({
                url: TOGGLE_URL,
                data: {m: toggleSwitch.data("model"), i: toggleSwitch.data("id"), v: fieldData},
                method: "GET",
                cache: false,
                dataType: "json",
                success: function (response) {
                    //notify update
                    notify(response.message, response.level, response.title);
                    //revert to old state
                    console.log(response.status);

                    if (response.status === false) {
                        //revert to old state
                        if (toggleCurrentState === false)
                            toggleSwitch.bootstrapToggle('on', true);
                        else
                            toggleSwitch.bootstrapToggle('off', true);
                    }
                },
                error: function (errorResponse) {
                    errorResponse = errorResponse.responseJSON;
                    //notify update
                    notify(errorResponse.message, errorResponse.level, errorResponse.title);
                    //revert to old state
                    if (toggleCurrentState === false)
                        toggleSwitch.bootstrapToggle('on', true);
                    else
                        toggleSwitch.bootstrapToggle('off', true);
                }
            });
        });
    });

    //High light Search Match in Table
    $("body").find("input[name=search]").each(function () {
        var searchElementId = $(this).attr("id");
        var targetTableId = $(this).data("target-table");

        //verify table exist
        if (!$("table#" + targetTableId)) {
            alert("Invalid Table ID");
        } else {
            if (searchElementId.length > 0 && targetTableId.length > 0) {
                highLightQueryString(searchElementId, targetTableId);
            }
        }
    });

    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('wheel.disableScroll', function (e) {
            e.preventDefault()
        })
    }).on('blur', 'input[type=number]', function (e) {
        $(this).off('wheel.disableScroll')
    });
});
