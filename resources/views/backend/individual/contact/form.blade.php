@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"
          type="text/css">
@endpush

<div class="card-header">
    <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               id="pills-basic-tab" data-toggle="pill"
               href="#pills-basic" role="tab"
               aria-controls="pills-basic" aria-selected="true"><strong>Basic</strong></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               id="pills-address-tab" data-toggle="pill"
               href="#pills-address" role="tab"
               aria-controls="pills-address" aria-selected="false"><strong>Address</strong></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active"
               id="pills-detail-tab" data-toggle="pill"
               href="#pills-detail" role="tab"
               aria-controls="pills-detail" aria-selected="true"><strong>Details</strong></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               id="pills-work-tab" data-toggle="pill"
               href="#pills-work" role="tab"
               aria-controls="pills-work" aria-selected="false"><strong>Work</strong></a>
        </li>
    </ul>
</div>
<div class="card-body">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade" id="pills-basic" role="tabpanel" aria-labelledby="pills-basic-tab">
            <div class="row">
                <div class="col-md-4">
                    {!! \Form::nSelect('prefix', 'Prefix/Title', ['Mr.' => 'Mr'], old('prefix', $contact->prefix ?? null), false,
                                        ['data-placeholder'=>"Select or type"]) !!}
                </div>
                <div class="col-md-4">
                    {!! \Form::nText('first_name', 'First Name', old('first_name', $contact->first_name ?? null), true) !!}
                </div>
                <div class="col-md-4">
                    {!! \Form::nText('middle_name', 'Middle Name', old('middle_name', $contact->middle_name ?? null), false) !!}
                </div>
                <div class="col-md-4">
                    {!! \Form::nText('last_name', 'Last Name', old('last_name', $contact->last_name ?? null), true) !!}
                </div>
                <div class="col-md-4">
                    {!! \Form::nText('nick_name', 'Nick Name', old('nick_name', $contact->nick_name ?? null), false) !!}
                </div>
                <div class="col-md-4">
                    {!! \Form::nText('suffix', 'Suffix', old('suffix', $contact->suffix ?? null), true) !!}
                </div>
            </div>
            <fieldset>
                <legend class="border-bottom"><i class="fas fa-phone-alt"></i> Phone</legend>
                <div class="row">
                    @foreach(config('contact.phone_type') as $type => $label)
                        <div class="col-md-6">
                            {!! \Form::nText("phone[{$type}]", $label, old('prefix', $contact->phone[$type] ?? null), false) !!}
                        </div>
                    @endforeach
                </div>
            </fieldset>
            <fieldset>
                <legend class="border-bottom"><i class="fas fa-at"></i> Email</legend>
                <div class="row">
                    @foreach(config('contact.email_type') as $type => $label)
                        <div class="col-md-6">
                            {!! \Form::nText("email[{$type}]", $label, old('prefix', $contact->phone[$type] ?? null), false) !!}
                        </div>
                    @endforeach
                </div>
            </fieldset>

            <div class="row">
                <div class="col-md-4">
                    {!! \Form::nSelect('enabled', __('common.Enabled'), \App\Supports\Constant::ENABLED_OPTIONS,
                        old('enabled', ($contact->enabled ?? \App\Supports\Constant::ENABLED_OPTION)), true) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    {!! \Form::nTextarea('remarks', 'Remarks', old('remarks', $contact->remarks ?? null), false) !!}
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab">
            @foreach(config('contact.address_type') as $type => $label)
                <fieldset>
                    <legend class="border-bottom">{{ $label }}</legend>
                    <div class="row">
                        {!! \Form::hidden("address[{$type}][type]", $type) !!}
                        <div class="col-md-12">
                            {!! \Form::nTextarea("address[{$type}][street_address]", 'Street Address', old('street_address', $contact->first_name ?? null), false, ['rows' => 2]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! \Form::nSelect("address[{$type}][country_id]", 'Country', $countries, null, false) !!}
                        </div>
                        <div class="col-md-6">
                            {!! \Form::nSelect("address[{$type}][state_id]", 'State', $states, null, false) !!}
                        </div>
                        <div class="col-md-6">
                            {!! \Form::nSelect("address[{$type}][city_id]", 'City', $cities, null, false) !!}
                        </div>
                        <div class="col-md-6">
                            {!! \Form::nText("address[{$type}][post_code]", 'Post/Zip Code', null, false) !!}
                        </div>
                    </div>
                </fieldset>
            @endforeach
        </div>
        <div class="tab-pane fade show active" id="pills-detail" role="tabpanel" aria-labelledby="pills-detail-tab">
            <div class="row">
                <div class="col-md-6">
                    {!! \Form::nText('birth', 'Birth Date', null, false, ['type'=>'text']) !!}
                </div>
                <div class="col-md-6">
                    {!! \Form::nDate('anniversary', 'Anniversary', null, false, ['type'=>'text']) !!}
                </div>
                <div class="col-md-6">
                    {!! \Form::nSelect('sensitivity', 'Sensitivity', config('contact.sensitivity'), null, false, ['placeholder' => 'Select an Option']) !!}
                </div>
                <div class="col-md-6">
                    {!! \Form::nSelect('priority', 'Priority', config('contact.priority'), null, false, ['placeholder' => 'Select an Option']) !!}
                </div>
                <div class="col-md-6">
                    {!! \Form::nText('language', 'Language', null, false) !!}
                </div>
                <div class="col-md-6">
                    {!! \Form::nUrl('website', 'Website', null, false) !!}
                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="pills-work" role="tabpanel" aria-labelledby="pills-work-tab">...</div>
    </div>
    <div class="row">
        <div class="col-12 justify-content-between d-flex">
            {!! \Form::nCancel(__('common.Cancel')) !!}
            {!! \Form::nSubmit('submit', __('common.Save')) !!}
        </div>
    </div>
</div>


@push('page-script')
    <script type="text/javascript" src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(function () {
            $("#prefix").select2({
                allowClear: true,
                tags: true,
                width: '100%'
            });
            $("#birth").daterangepicker({
                showDropdowns:true,
                singleDatePicker:true,
                locale: {format: '{{ config('backend.js_date') }}'},
                isInvalidDate:function (date) {
                    console.log(date);
                    return true;
                }
            });

            $("#contact-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
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
