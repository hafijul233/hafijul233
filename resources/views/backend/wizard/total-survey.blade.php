<div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
        <div class="inner">
            <h3>{{ $surveys ?? 0 }}</h3>

            <p>Surveys</p>
        </div>
        <div class="icon">
            <i class="fas fa-file-invoice"></i>
        </div>
        <a href="{{ route('backend.organization.surveys.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>