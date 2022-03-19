@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush
<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user_id">Customer<span style="color: #dc3545; font-weight:700">*</span></label>
                <select class="form-control custom-select user-select2" required="required" id="user_id" name="user_id">
                    <option value="" selected="selected" disabled>Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->getFirstMediaUrl('avatars') }}##{{ $customer->name }}##{{ $customer->mobile }}
                            ##{{ $customer->username }}
                        </option>
                    @endforeach
                </select>
                <span id="user_id-error" class="invalid-feedback"></span>
            </div>
        </div>
        <div class="col-md-6">
            {!! \Form::nText('name', __('common.Name'), old('name', $item->name ?? null), true) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nNumber('rate', 'Rate', old('rate', $item->rate ?? null), true, ['min' => 0, 'step' => '0.01']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('dimension', 'Dimension (Length X Width X Height) CM', old('dimension', $item->dimension ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nSelect('tax', 'Tax', \App\Supports\Constant::ENABLED_OPTIONS,
                old('tax', ($item->enabled ?? \App\Supports\Constant::ENABLED_OPTION)), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nSelect('enabled', __('common.Enabled'), \App\Supports\Constant::ENABLED_OPTIONS,
                old('enabled', ($item->enabled ?? \App\Supports\Constant::ENABLED_OPTION)), true) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('description', 'Description', old('remarks', $item->remarks ?? null), false) !!}
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
    <script>
        $(document).ready(function () {
            $(".user-select2").select2({
                width: "100%",
                templateResult: function (option) {
                    if (!option.id) {
                        return option.text;
                    }
                    var optionValues = option.text.trim().split("##");
                    return $('<div class="media">\
                                <img class="align-self-center mr-1 img-circle direct-chat-img elevation-1"\
                                 src="' + optionValues[0] + '" alt="' + optionValues[1] + '">\
                                <div class="media-body">\
                                    <p class="my-0 text-dark">' + optionValues[1] + '</p>\
                                    <p class="mb-0 small">\
                                    <span class="text-muted"><i class="fas fa-user"></i> ' + optionValues[3] + '</span>\
                                    <span class="ml-1 text-muted"><i class="fas fa-phone"></i> ' + optionValues[2] + '</span>\
                                    </p>\
                                </div>\
                            </div>');
                },
                templateSelection: function (option) {
                    if (!option.id) {
                        return option.text;
                    }
                    var optionValues = option.text.trim().split("##");
                    return $('<p class="my-0 text-dark font-weight-bold d-flex justify-content-between align-content-center">\
                    <span><i class="fas fa-user text-muted"></i> ' + optionValues[1] + '</span>\
                        <span><i class="fas fa-phone text-muted"></i> ' + optionValues[2] + '</span></p>');
                }
            });

            $('#dimension').inputmask('999X999X999', { 'placeholder': '___X___X___' });

            $("#item-form").validate({
                rules: {
                    name: {
                        required: true,
                        mindimension: 3,
                        maxdimension: 255
                    },
                    enabled: {
                        required: true
                    },
                    remarks: {},
                }
            });
        });
    </script>
@endpush
