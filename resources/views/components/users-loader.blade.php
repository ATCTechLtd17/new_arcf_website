<div class="row">
    @forelse($users as $user)
        <div class="col-md-4 col-lg-4 col-xl-3">
            <div class="card card-body shadow-sm" style="padding: 0.2rem;border-radius: 5px;">
                <div class="row align-items-center">
                    <div class="text-center p-l-10">
                        <div class="ms-linear-background" style="width: 80px; height: 80px;border-radius: 50%;"></div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <figcaption class="ms-linear-background"style="height: 13px;margin-bottom: 5px;width: 90%;"></figcaption>
                        <figcaption class="ms-linear-background"style="height: 13px;margin-bottom: 5px;width: 90%;"></figcaption>
                        <small>
                            <figcaption class="ms-linear-background" style="height: 22px;margin-bottom: 5px;"></figcaption>
                            <div>
                                <span class="badge ms-badge-loader" style="width: 120px">&nbsp;</span>
                                <span class="badge ms-badge-loader" style="width: 120px">&nbsp;</span>
                            </div>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-4 col-lg-4 col-xl-3">
            <div class="card card-body shadow-sm" style="padding: 0.2rem;border-radius: 5px;">
                <div class="row align-items-center">
                    <div class="text-center p-l-10">
                        <div class="ms-linear-background" style="width: 80px; height: 80px;border-radius: 50%;"></div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <figcaption class="ms-linear-background"style="height: 13px;margin-bottom: 5px;width: 90%;"></figcaption>
                        <figcaption class="ms-linear-background"style="height: 13px;margin-bottom: 5px;width: 90%;"></figcaption>
                        <small>
                            <figcaption class="ms-linear-background" style="height: 22px;margin-bottom: 5px;"></figcaption>
                            <div>
                                <span class="badge ms-badge-loader" style="width: 120px">&nbsp;</span>
                                <span class="badge ms-badge-loader" style="width: 120px">&nbsp;</span>
                            </div>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</div>
