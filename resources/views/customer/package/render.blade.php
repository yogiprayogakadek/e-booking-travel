@forelse ($packages as $package)
    <div class="col-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title text-center">{{ json_decode($package->detail, true)['name'] }}</div>
                <div class="img-con text-center">
                    <img src="{{ asset($package->image) }}" height="300px">
                    <button type="button" class="btn btn-primary btn-lg btn-rounded text-white btn-detail"
                        data-id="{{ $package->id }}" data-name="{{ json_decode($package->detail, true)['name'] }}"
                        data-address="{{ json_decode($package->detail, true)['address'] }}"
                        data-price={{ number_format($package->price, 0, '.', '.') }}>
                        <i class="fa fa-eye"></i> Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <h3 class="text-center">No Data Found!</h3><br />
    </div>
@endforelse

<div class="col-lg-12">
    {!! $packages->withQueryString()->links('pagination::bootstrap-5') !!}
</div>
