@include('layouts.includes.html-editor')

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('degree', __('resume.education.Degree'), old('degree', $education->degree ?? null), true, ['placeholder' => 'Example: Bachelors']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('field', __('resume.education.Field'), old('field', $education->field ?? null), true, ['placeholder' => 'Example: Computer Science']) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nText('institute', __('resume.education.Institute'), old('institute', $education->institute ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nText('address', __('resume.education.Address'), old('address', $education->address ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('start_date', __('resume.education.Start Date'), old('start_date', $education->start_date ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('end_date', __('resume.education.End Date'), old('end_date', $education->end_date ?? null), false) !!}
        </div>
        <div class="col-12">
            {!! \Form::nTextarea('description', __('common.Description'), old('description', $education->description ?? null), false) !!}
        </div>
        {{--<div class="col-md-12">
            {!! \Form::nImage('image',__('common.Image'), false,
                ['preview' => true, 'height' => '240',
                 'default' => (isset($education))
                 ? $education->getFirstMediaUrl('services')
                 : asset(\App\Supports\Constant::SERVICE_IMAGE)]) !!}
        </div>--}}
    </div>
    <div class="row mt-3">
        <div class="col-12 justify-content-between d-flex">
            {!! \Form::nCancel(__('common.Cancel')) !!}
            {!! \Form::nSubmit('submit', __('common.Save')) !!}
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(function () {
            htmlEditor("#description", {height: 200});
            $("#service-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    enabled: {
                        required: true
                    },
                    remarks: {
                    },
                }
            });
        });
    </script>
@endpush
