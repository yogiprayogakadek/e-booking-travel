@extends('template.master')

@section('page-title', 'Order')
@section('page-sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Data Order
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <div class="m-auto"></div>
                            <button type="button" class="btn btn-outline-success ml-2 btn-print">
                                <i class="nav-icon fa fa-print font-weight-bold"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped" id="tableData">
                        <thead>
                            <th>No</th>
                            <th>Order Code</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ date_format(date_create($order->date), 'd-m-Y') }}</td>
                                    <td>{{ convertToRupiah($order->payment->total) }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <button class="btn btn-detail btn-primary" data-id="{{ $order->id }}">
                                            <i class="fa fa-eye text-white mr-2 pointer"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Destination</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <table class="table table stripped" id="tableDetail">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Destination Name</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Order Date</th>
                                    <th>Order Message</th>
                                    <th>Quantity</th>
                                    <th>Price </th>
                                    <th>Total </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Print Report</h5>
                    <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times-circle"></i>
                    </button>
                </div>
                <form action="{{ route('order.print') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="start">Start Date (Date created)</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ date_format(date_create(now()), 'Y-m-d') }}" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-6">
                                <label for="end">End Date (Date created)</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ date_format(date_create(now()), 'Y-m-d') }}" max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary pull-right" type="submit">Print</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/helper/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#tableData').DataTable({
                language: {
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    },
                    info: "Showing _START_ to _END_ from _TOTAL_ data",
                    infoEmpty: "Showing 0 to 0 from 0 data",
                    lengthMenu: "Showing _MENU_ data",
                    search: "Search:",
                    emptyTable: "Data doesn't exists",
                    zeroRecords: "Data doesn't match",
                    loadingRecords: "Loading..",
                    processing: "Processing...",
                    infoFiltered: "(filtered from _MAX_ total data)"
                },
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                order: [
                    [0, 'desc']
                ],
                "rowCallback": function(row, data, index) {
                    // Set the row number as the first cell in each row
                    $('td:eq(0)', row).html(index + 1);
                }
            });

            // Update row numbers when the table is sorted
            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $('body').on('click', '.btn-print', function() {
                $('#modalPrint').modal('show');
            })

            $('body').on('click', '.btn-detail', function() {
                let orderId = $(this).data('id')
                $('#tableDetail tbody').empty()
                $.get("/order/detail/" + orderId, function(data) {
                    $.each(data, function(index, value) {
                        let tr_list = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + $.parseJSON(value.package.detail)['name'] + '</td>' +
                            '<td>' + value.order.customer.email + '</td>' +
                            '<td>' + value.order.customer.name + '</td>' +
                            '<td>' + value.order_date + '</td>' +
                            '<td>' + (value.order_message ?? '-') + '</td>' +
                            '<td>' + value.quantity + '</td>' +
                            '<td>' + convertToRupiah(value.package.price) + '</td>' +
                            '<td class="sub-total text-right">' + convertToRupiah(value
                                .package.price * value.quantity) + '</td>' +
                            '</tr>';

                        $('#tableDetail tbody').append(tr_list)
                    });
                });
                $('#modal').modal('show');

                setTimeout(() => {
                    let subTotal = $('.sub-total').text().split('Rp');
                    let total = 0;
                    subTotal.shift()
                    $.each(subTotal, function(index, val) {
                        total += convertToInt(val)
                    });

                    let new_tr = '<tr>' +
                        '<td colspan="8" class="font-italic font-weight-800 text-right">Total</td>' +
                        '<td class="font-italic font-weight-800 text-right">' + convertToRupiah(
                            total) + '</td>' +
                        '</tr>';
                    $('#tableDetail tbody').append(new_tr)
                }, 1000);
            });
        });
    </script>
@endpush
