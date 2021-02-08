<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('backend/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/vendor.bundle.addons.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('backend/images/logo_2H_tech.png')}}" />
</head>
<body>
    <div class="container-scroller">
        @include('adminnav.admintopnav')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
            @include('adminnav.adminsidenav')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Start Content -->
                    @yield('content')
                    <!-- End Content -->
                </div>
                @include('include.adminfooter')
            </div>
        </div>
    </div>


    <script src="{{asset('backend/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('backend/js/vendor.bundle.addons.js')}}"></script>
    <script src="{{asset('backend/js/off-canvas.js')}}"></script>
    <script src="{{asset('backend/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('backend/js/template.js')}}"></script>
    <script src="{{asset('backend/js/settings.js')}}"></script>
    <script src="{{asset('backend/js/todolist.js')}}"></script>
    

    @yield('scripts')

</body>

</html>



