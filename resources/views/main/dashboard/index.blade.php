@extends('template.master')

@section('page-title', 'Dashboard')
@section('page-sub-title', 'Data')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-5 mx-auto">
            <div class="card card-profile-1 mb-4">
                <div class="card-body text-center">
                    <div class="avatar box-shadow-2 mb-3">
                        <img src="{{asset(auth()->user()->photo)}}" alt="">
                    </div>
                    <h5 class="m-0">{{auth()->user()->name}}</h5>
                    <p class="mt-0">{{ucfirst(auth()->user()->role)}}</p>
                    <p>Hello and welcome! Wishing you a wonderful day filled with positivity and joy. 😊</p>
                    <a href="{{auth()->user()->role == 'customer' ? route('customer.package.index') : route('package.index')}}">
                        <button class="btn btn-primary btn-rounded">Find best tourist</button>
                    </a>
                    <div class="card-socials-simple mt-4">
                        Aris Bali Explorer
                        {{-- <a href="">
                            <i class="i-Linkedin-2"></i>
                        </a>
                        <a href="">
                            <i class="i-Facebook-2"></i>
                        </a>
                        <a href="">
                            <i class="i-Twitter"></i>
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
