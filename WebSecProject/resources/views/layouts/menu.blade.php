<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="navbar-brand" href="{{ url('/') }}">BiT</a>
            </li>
            @auth
                @if (auth()->user()->hasPermissionTo('products_for_customers'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('products_list')}}">Products</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.view') }}">Orders</a>
                    </li>
                @endif
                @if (auth()->user()->hasPermissionTo('show-products'))
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('seller.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('seller.manage') }}">Manage Products</a>
                    </li>
               @endif
               @if (auth()->user()->hasPermissionTo('manage_sellers'))
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.manage_seller') }}">Manage Sellers</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.manage_orders') }}">Manage Orders</a>
                    </li>
               @endif
               @if (auth()->user()->hasPermissionTo('show-users'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manager.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.manage') }}">Users</a>
                    </li>
                @endif
                @if (auth()->user()->hasPermissionTo('spatie_manage'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('spatie.manage') }}">Spatie</a>
                    </li>
                @endif
            @endauth
        </ul>
        <ul class="navbar-nav">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{route('profile')}}">{{auth()->user()->name}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('do_logout')}}">Logout</a>
                </li>
                @if (auth()->user()->hasPermissionTo('products_for_customers'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.view') }}" style="color: #ff5722; font-weight: bold;">
                            <i class="bi bi-cart"></i> Cart
                        </a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">Register</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>
