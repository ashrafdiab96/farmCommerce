<nav class="sidebar sidebar-offcanvas" id="sidebar">
<ul class="nav">
    <li class="nav-item">
    <a class="nav-link" href="{{url('/admin')}}">
        <i class="ti-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
    </a>
    </li>
    <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
        <i class="ti-clipboard menu-icon"></i>
        <span class="menu-title">Create</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="form-elements">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{url('/addcategory')}}">Add Category</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('/addproduct')}}">Add Product</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('/addslider')}}">Add Slider</a></li>
        </ul>
    </div>
    </li>
    <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
        <i class="ti-layout menu-icon"></i>
        <span class="menu-title">Views</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="tables">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{url('/categories')}}">Categories</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('/products')}}">Products</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('/sliders')}}">Sliders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('/orders')}}">Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('/clients')}}">Clients</a></li>
        </ul>
    </div>
    </li>
</ul>
</nav>
