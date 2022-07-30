@if ($errors->any())
    <div class="container-fluid">
        <div class="row">
            <div class="alert alert-danger col-12">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
