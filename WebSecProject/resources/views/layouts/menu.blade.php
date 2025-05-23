<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="navbar-brand" href="./">BiT</a>
            </li>
            @auth
                @if (auth()->user()->hasRole('Customer'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('products_list')}}">Products</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.view') }}">Orders</a>
                    </li>
                @endif
                @if (auth()->user()->hasRole('Seller'))
                       <li class="nav-item">
                             <a class="nav-link" href="{{ route('seller.manage') }}">Manage Products</a>
                      </li>
               @endif
                  @if (auth()->user()->hasRole('Admin'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.manage') }}">Users</a>
                    </li>
                @endif
            @endauth
            {{-- <li class="nav-item">
                <a class="nav-link" href="./even">Even Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./prime">Prime Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./multable">Multiplication Table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('cryptography')}}">Cryptography</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('webcrypto')}}">Web Crypto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('products_list')}}">Products</a>
            </li>
            @can('show_users')
            <li class="nav-item">
                <a class="nav-link" href="{{route('users')}}">Users</a>
            </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link" href="{{route('bought_products')}}">Bought Products List</a>
            </li> --}}
        </ul>
        <ul class="navbar-nav">
            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{route('profile')}}">{{auth()->user()->name}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('do_logout')}}">Logout</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{route('login')}}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('register')}}">Register</a>
            </li>
            @endauth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cart.view') }}" style="color: #ff5722; font-weight: bold;">
                    <i class="bi bi-cart"></i> Cart
                </a>
            </li>
        </ul>
    </div>
</nav>
