<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <div class="navigation-left">
            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('dashboard.index') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashoard</span>
                </a>
                <div class="triangle"></div>
            </li>
            @can('admin')
            <li class="nav-item {{ Request::is('customer') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('customer.index') }}">
                    <i class="nav-icon i-Administrator"></i>
                    <span class="nav-text">Customers</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ Str::contains(request()->url(), 'package') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('package.index') }}">
                    <i class="nav-icon i-Administrator"></i>
                    <span class="nav-text">Packages</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ Request::is('order') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('order.index') }}">
                    <i class="nav-icon i-Window"></i>
                    <span class="nav-text">Order</span>
                </a>
                <div class="triangle"></div>
            </li>
            @endcan
            @can('customer')
            <li class="nav-item {{ Request::is('customer/package') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('customer.package.index') }}">
                    <i class="nav-icon i-Administrator"></i>
                    <span class="nav-text">Packages</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ Request::is('customer/cart') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('customer.cart.index') }}">
                    <i class="nav-icon i-Cart-Quantity"></i>
                    <span class="nav-text">Cart</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ Request::is('customer/order') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('customer.order.index') }}">
                    <i class="nav-icon i-Window"></i>
                    <span class="nav-text">Order</span>
                </a>
                <div class="triangle"></div>
            </li>
            @endcan
            {{--<li class="nav-item {{ Str::contains(request()->url(), 'medicine') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('medicine.index') }}">
                    <i class="nav-icon i-Medicine-2"></i>
                    <span class="nav-text">Medicine</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ Str::contains(request()->url(), 'batch') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('batch.index') }}">
                    <i class="nav-icon i-Bar-Chart-3"></i>
                    <span class="nav-text">Batch</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ Str::contains(request()->url(), 'outgoing') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('outgoing.index')}}">
                    <i class="nav-icon i-Medicine-3"></i>
                    <span class="nav-text">Outgoing</span>
                </a>
                <div class="triangle"></div>
            </li> --}}
        </div>
    </div

    <div class="sidebar-overlay"></div>
</div>
