<!-- Start main navbar -->
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="index.html">Vegefoods</a>
        <!-- Small screen display nav button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <!-- Nav body -->
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="{{url('/')}}" class="nav-link">Home</a></li>
                <li class="nav-item active"><a href="{{url('/shop')}}" class="nav-link">shop</a></li> 
                <li class="nav-item cta cta-colored"><a href="{{url('/cart')}}" class="nav-link">
                    <span class="icon-shopping_cart"></span>[{{Session::has('cart')?Session::get('cart')->totalQty:0}}]</a>
                </li>
                @if (Session::has('client'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{Session::get('client')->name}}
                        </a>
                        <ul class="dropdown-menu custom-dropdown" style="margin-top:-10px;" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{url('/showprofile', Session::get('client')->id)}}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{url('/logout')}}">logout</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item active"><a href="{{url('/login')}}" class="nav-link">login</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
 <!-- END nav -->
 