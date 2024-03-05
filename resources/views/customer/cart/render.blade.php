<div class="col-xl-8">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th>Tourist</th>
                            <th>Tourist Name</th>
                            <th>Tourist Address</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th colspan="2">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cart as $cart)
                            <tr>
                                <td>
                                    <img src="{{ asset($cart->associatedModel['image']) }}" alt="product-img"
                                        title="product-img" class="avatar-md">
                                </td>
                                <td>
                                    <h5 class="font-size-14 text-truncate"><a
                                            href="{{ route('customer.package.index') }}"
                                            class="text-dark">{{ $cart->name }}</a></h5>
                                    {{-- <p class="mb-0">Tahun terbit : <span class="fw-medium">{{json_decode($cart->associatedModel->data_buku, true)['tahun_terbit']}}</span></p> --}}
                                </td>
                                <td>
                                    {{ json_decode($cart->associatedModel->detail, true)['address'] }}
                                </td>
                                <td>
                                    {{ convertToRupiah($cart->price) }}
                                </td>
                                <td>
                                    <div class="me-3" style="width: 120px;">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                            <input type="text" value="{{ $cart->quantity }}" name="quantity"
                                                class="form-control quantity" data-id="{{ $cart->id }}"
                                                data-date={{ $cart->attributes['order_date'] }}>
                                            <span class="input-group-btn-vertical">
                                                <button class="btn btn-primary bootstrap-touchspin-up quantity-update"
                                                    type="button" data-cat='up' data-id="{{ $cart->id }}"
                                                    data-qty="{{ $cart->quantity }}"
                                                    data-date={{ $cart->attributes['order_date'] }}>+</button>
                                                <button class="btn btn-primary bootstrap-touchspin-down quantity-update"
                                                    type="button" data-cat='down' data-id="{{ $cart->id }}"
                                                    data-qty="{{ $cart->quantity }}"
                                                    data-date={{ $cart->attributes['order_date'] }}>-</button>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    {{ convertToRupiah($cart->quantity * $cart->price) }}
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="action-icon text-danger"> <i
                                            class="mdi mdi-trash-can font-size-18"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <h2>No Data</h2>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (cart()->count() > 0)
                <div class="row mt-4">
                    <div class="col-sm-6">
                        <a href="{{ route('customer.package.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-alt-circle-left"></i> Back to package </a>
                    </div> <!-- end col -->
                    <div class="col-sm-6">
                        <div class="float-right mt-2 mt-sm-0">
                            <button type="button" class="btn btn-success btn-process">
                                <i class="i-Dollar-Sign"></i> Process Payment
                            </button>
                        </div>
                    </div> <!-- end col -->
                </div>
            @endif
            <!-- end row-->
        </div>
    </div>
</div>

<!-- SUMMARY -->
<div class="col-xl-4">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-3">Order Summary</h4>

            <div class="table-responsive">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td>Total item :</td>
                            <td>{{ cart()->count() }}</td>
                        </tr>
                        <tr>
                            <td>Quantity : </td>
                            <td>{{ cartQuantity() }}</td>
                        </tr>
                        <tr>
                            <th>Total :</th>
                            <th>{{ subTotal() }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->
        </div>
    </div>
    <!-- end card -->
</div>

<script>
    $("input[name=kuantitas]").inputFilter(function(value) {
        return /^\d*$/.test(value);
    }, "Hanya mengandung angka ");
</script>
