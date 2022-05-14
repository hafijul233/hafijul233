@include('backend.layouts.includes.html-editor')
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('title', __('blog.post.Title'), old('title', $post->title ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('content', __('blog.post.Content'), old('content', $post->content ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('summary', __('blog.post.Summary'), old('summary', $post->summary ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nImage('image',__('common.Image'), false,
                ['preview' => true, 'height' => '240',
                 'default' => (isset($post))
                 ? $post->getFirstMediaUrl('posts')
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
            htmlEditor("#summary", {height: 100});

            htmlEditor("#content", {height: 500});

            $("#post-form").validate({
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
