<div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
        <div class="inner">
            <h3>{{ $enumerators ?? 0 }}</h3>

            <p>Enumerators</p>
        </div>
        <div class="icon">
            <i class="fas fa-user-check"></i>
        </div>
        <a href="{{ route('backend.organization.enumerators.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>