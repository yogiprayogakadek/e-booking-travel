<div class="main-header">
    <div class="logo">
        <a href="/">
            <img src="{{asset('assets/images/logo.png')}}" alt="" />
        </a>
    </div>

    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>

    @stack('search')

    <div style="margin: auto"></div>

    <div class="header-part-right">
        @can('customer')
        <div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="badge badge-primary">{{count(cart())}}</span>
                <i class="i-Cart-Quantity text-muted header-icon"></i>
            </div>
            <!-- Notification dropdown -->
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none ps" aria-labelledby="dropdownNotification" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                @forelse (cart() as $cart)
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <img src="{{asset($cart->associatedModel['image'])}}">
                        {{-- <i class="i-Speach-Bubble-6 text-primary mr-1"></i> --}}
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>{{$cart->name}}</span>
                            <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">{{date('d-m-Y')}}</span>
                        </p>
                        <p class="text-small text-muted m-0">Quantity: {{$cart->quantity}}</p>
                    </div>
                </div>
                @empty
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Speach-Bubble-6 text-primary mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span class="text-center">No data!</span>
                        </p>
                    </div>
                </div>
                @endforelse
            <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
        </div>
        @endcan
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                Welcome, <strong>{{auth()->user()->name}}</strong>!
                <img src="{{asset(auth()->user()->photo)}}" id="userDropdown" alt="" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" />

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{auth()->user()->name}}
                    </div>
                    {{-- <a class="dropdown-item">Account settings</a>
                    <a class="dropdown-item">Billing history</a> --}}
                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{route('logout')}}">Sign
                        out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
