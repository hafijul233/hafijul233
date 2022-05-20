@include('backend.layouts.includes.html-editor')

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', __('common.Name'), old('name', $project->name ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('owner', __('portfolio.project.Owner'), old('owner', $project->owner ?? 'Self'), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('start_date', __('portfolio.project.Start Date'), old('start_date', $project->start_date ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('end_date', __('portfolio.project.End Date'), old('end_date', $project->end_date ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('associate', __('portfolio.project.Associate'), old('associate', $project->associate ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nUrl('url', __('portfolio.project.URL'), old('url', $project->url ?? null), false) !!}
        </div>
        <div class="col-12">
            {!! \Form::nTextarea('description', __('common.Description'), old('description', $project->description ?? null), false) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nImage('image',__('common.Image'), false,
                ['preview' => true, 'height' => '240',
                 'default' => (isset($project))
                 ? $project->getFirstMediaUrl('projects')
                 : asset(\App\Supports\Constant::SERVICE_IMAGE)]) !!}
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
    <script>
        $(function () {
            htmlEditor("#description", {height: 200});

            $("#project-form").validate({
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
