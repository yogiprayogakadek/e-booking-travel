@extends('template.master')

@section('page-title', 'Cart')
@section('page-sub-title', 'Data')

@push('css')
    <link href="{{ asset('assets/helper/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="row render"></div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="{{ asset('assets/helper/main.js') }}">
        < script src = "{{ asset('assets/helper/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}" >
    </script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-WLa4T_aeiQfLdfyC"></script>
    <script>
        function getData() {
            $.ajax({
                type: "get",
                url: "/customer/cart/render",
                dataType: "json",
                success: function(response) {
                    $(".render").html(response.data);
                },
                error: function(error) {
                    console.log("Error", error);
                },
            });
        }

        function paymentChecking(status_code, order_id) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                type: "POST",
                url: "/customer/cart/payment-checking",
                data: {
                    status_code: status_code,
                    order_id: order_id,
                },
                success: function(response) {
                    Swal.fire(response.title, response.message, response.status);
                    getData();
                }
            });
        }

        function screenLoading() {
            $.LoadingOverlay("show", {
                image: "",
                progress: true
            });
            var count = 0;
            var interval = setInterval(function() {
                if (count >= 100) {
                    clearInterval(interval);
                    $.LoadingOverlay("hide");
                    return;
                }
                count += 10;
                $.LoadingOverlay("progress", count);
            }, 200);
        }

        $(document).ready(function() {
            getData();

            $('body').on('click', '.quantity-update', function() {
                var id = $(this).data('id');
                var prevQty = $(this).data('qty');
                var cat = $(this).data('cat');
                var date = $(this).data('date');
                let data = id + '%' + date;
                let maxQuantity = 8;
                var that = this;

                $.get("/customer/package/order-quantity/" + data, function(quantity) {
                    let currentQuantity = parseInt(quantity)
                    var qty = (cat == 'up' ? parseInt(parseInt($(that).closest('.input-group').find(
                            '.quantity')
                        .val())) + 1 : parseInt(parseInt($(that).closest('.input-group')
                        .find(
                            '.quantity').val())) - 1);
                    if ((qty + currentQuantity) > maxQuantity) {
                        parseInt($(that).closest('.input-group').find('.quantity').val(prevQty))
                        Swal.fire({
                            title: 'The  quantity is exceeded the limit!',
                            text: "Only 8 allow everyday and now already  have " +
                                currentQuantity + " package.",
                            // text: "You can only add  up to " + (maxQuantity -
                            //     currentQuantity) + " more items.",
                            icon: "warning"
                        })
                    } else {
                        if (qty == 0) {
                            parseInt($(that).closest('.input-group').find('.quantity').val(prevQty))
                        } else {
                            $.ajax({
                                url: '/customer/cart/update',
                                type: 'POST',
                                data: {
                                    id: id,
                                    quantity: qty,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(result) {
                                    Swal.fire(
                                        result.title,
                                        result.message,
                                        result.status
                                    )
                                    getData()
                                }
                            });
                        }
                    }
                });
            });

            $('body').on('focus', '.quantity', function() {
                $(this).data('prevQuantity', parseInt($(this).val()));
            });

            $('body').on('blur', '.quantity', function() {
                var id = $(this).data('id');
                var date = $(this).data('date');
                var prevQty = $(this).data('prevQuantity');
                var qty = parseInt($(this).val());

                let maxQuantity = 8;

                var that = this;

                let data = id + '%' + date;
                $.get("/customer/package/order-quantity/" + data, function(quantity) {
                    let currentQuantity = parseInt(quantity)

                    // console.log(qty)
                    if ((qty + currentQuantity) > maxQuantity) {
                        $(that).val(prevQty);
                        Swal.fire({
                            title: 'The  quantity is exceeded the limit!',
                            text: "You can only add  up to " + (maxQuantity -
                                currentQuantity) + " more items.",
                            icon: "warning"
                        })
                    } else {
                        $.ajax({
                            url: '/customer/cart/update',
                            type: 'POST',
                            data: {
                                id: id,
                                quantity: qty,
                                // cat: cat,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(result) {
                                Swal.fire(
                                    result.title,
                                    result.message,
                                    result.status
                                )
                                getData()
                            }
                        });
                    }
                });

            });

            $('body').on('click', '.btn-process', function() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                Swal.fire({
                    title: "Process this transaction?",
                    // text: "Proses akan dilanjutkan ke tahap pembayaran!",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, process!",
                    cancelButtonText: "Cancel",
                }).then((response) => {
                    if (response.value) {
                        $.ajax({
                            url: "/customer/cart/payment",
                            type: "POST",
                            // data: {
                            //     provinsi: $('#provinces').find("option:selected").text(),
                            //     kabupaten: $('#regencies').find("option:selected").text(),
                            //     kecamatan: $('#districts').find("option:selected").text(),
                            //     desa: $('#villages').find("option:selected").text(),
                            //     kode_pos: $('#kode-pos').val(),
                            //     alamat: $('#alamat').val(),
                            // },
                            success: function(res) {
                                screenLoading();
                                if (res.status == 'success') {
                                    snap.pay(res.midtransToken, {
                                        onSuccess: function(result) {
                                            console.log(result)
                                            paymentChecking(result
                                                .status_code, result
                                                .order_id);
                                            // Swal.fire('Berhasil', 'Pembayaran berhasil', 'success');
                                            // setTimeout(() => {
                                            //     location.reload();
                                            // }, 1000);
                                        },
                                        onPending: function(result) {
                                            console.log(result)
                                            paymentChecking(result
                                                .status_code, result
                                                .order_id);
                                            // Swal.fire('Info', 'Menunggu pembayaran', 'info');
                                            // setTimeout(() => {
                                            //     location.reload();
                                            // }, 1000);
                                        },
                                        onError: function(result) {
                                            console.log(result)
                                            paymentChecking(result
                                                .status_code, result
                                                .order_id);
                                            // Swal.fire('Gagal', 'Pembayaran gagal', 'error');
                                            // setTimeout(() => {
                                            //     location.reload();
                                            // }, 1000);
                                        }
                                    });
                                }
                            },
                        });
                    }
                });
            })
        });
    </script>
@endpush
