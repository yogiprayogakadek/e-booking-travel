@extends('template.master')

@section('page-title', 'Package')
@section('page-sub-title', 'Data')

@push('css')
    <style>
        .img-con {
            position: relative;
        }

        .btn-detail {
            position: absolute;
            top: 50%;
            left: 43%;
            visibility: hidden;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            transition: visibility 0.3s, background-color 0.3s;
        }

        .img-con:hover .btn-detail {
            visibility: visible;
            background-color: rgba(0, 0, 0, 0.9);
        }
    </style>
@endpush

@section('content')
    <div class="row" id="packages">
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
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Tourist</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">Tourist Name</div>
                        <div class="col-9 tourist-name"></div>

                        <div class="col-3 mt-3">Tourist Address</div>
                        <div class="col-9 mt-3 tourist-address"></div>

                        <div class="col-3 mt-3">Tourist Price</div>
                        <div class="col-9 mt-3 tourist-price"></div>

                        <div class="col-3 mt-3">Quantity</div>
                        <div class="col-9 mt-3">
                            <input type="number" name="quantity" id="quantity" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-primary btn-add">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/js/print/main.js') }}"></script>
    <script>
        function getPackages(url) {
            $.ajax({
                url: url
            }).done(function(data) {
                $('#packages').html(data);
            }).fail(function() {
                alert('Data cant be load.');
            });
        }
        $(document).ready(function() {
            localStorage.clear();

            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                getPackages(url);
            });

            $('.btn-detail').click(function() {
                localStorage.setItem('package_id', $(this).data('id'));

                // set detail
                $('#modal .tourist-name').text($(this).data('name'))
                $('#modal .tourist-address').text($(this).data('address'))
                $('#modal .tourist-price').text($(this).data('price'))

                $('#modal').modal('show');
            });

            $('body').on('click', '.btn-add', function(e) {
                var id = localStorage.getItem('package_id');

                if($('input[name=quantity]').val() == '' || $('input[name=quantity]').val() <= 0) {
                    e.preventDefault()
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Please fill with exact number',
                    });
                    return false
                }

                Swal.fire({
                    title: 'Add to Cart?',
                    // text: "Add",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, add!',
                }).then((result) => {
                    var formData = new FormData();
                    formData.append('package_id', id);
                    formData.append('quantity', $('input[name=quantity]').val());
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "/customer/package/store",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush
