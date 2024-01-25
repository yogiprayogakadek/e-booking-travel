@extends('template.master')

@section('page-title', 'Package')
@section('page-sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Add Package
                        </div>
                        {{-- @can('petugas') --}}
                            <div class="col-6 d-flex align-items-center">
                                <div class="m-auto"></div>
                                <a href="{{route('package.index')}}">
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="nav-icon fa fa-eye font-weight-bold"></i> View Data
                                    </button>
                                </a>
                            </div>
                        {{-- @endcan --}}
                    </div>
                </div>
                <form action="{{route('package.store')}}" method="POST" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Package Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="enter package name" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Package Price</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="enter package price" autocomplete="off" autofocus>
                        </div>
                        {{-- <div class="form-group">
                            <label for="">Package Total</label>
                            <input type="text" class="form-control" name="total" id="total" placeholder="enter package total" autocomplete="off" autofocus>
                        </div> --}}
                        <div class="form-group">
                            <label for="">Package Image</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="enter package image" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Package Address</label>
                            <textarea class="form-control" rows="5" name="address" id="name" placeholder="enter package address" autocomplete="off" autofocus></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Package Detail</label>
                            <textarea class="form-control" name="detail" rows="5" id="name" placeholder="enter package detail" autocomplete="off" autofocus></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

{!! JsValidator::formRequest('App\Http\Requests\PackageRequest', '#form') !!}

<script>
    $(document).ready(function () {
        @if(session('status'))
        Swal.fire(
            "{{session('title')}}",
            "{{session('message')}}",
            "{{session('status')}}",
        );
        @endif
    });
</script>
@endpush
