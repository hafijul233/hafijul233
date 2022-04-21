@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('modules/admin/plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush

<div class="card-body">
    {!! \Form::hidden('country_id', 19) !!}
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', 'Name', old('name', $state->name ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('native', 'Native', old('native', $state->native ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nSelect('type', 'Type', ['district' => 'District', 'division' => 'Division']
            ,old('type', $state->type ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nNumber('latitude', 'Latitude', old('latitude', $state->latitude ?? null), false, ['step' => '0.000000001']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nNumber('longitude', 'longitude', old('longitude', $state->longitude ?? null), false, ['step' => '0.000000001']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nSelect('enabled', 'Enabled', \App\Supports\Constant::ENABLED_OPTIONS,
old('enabled', ($state->enabled ?? \App\Supports\Constant::ENABLED_OPTION))) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 justify-content-between d-flex">
            {!! \Form::nCancel('Cancel') !!}
            {!! \Form::nSubmit('submit', 'Save') !!}
        </div>
    </div>
</div>

@push('page-script')
    <script type="text/javascript" src="{{ asset('modules/admin/plugins/select2/js/select2.min.js') }}"></script>
@endpush
