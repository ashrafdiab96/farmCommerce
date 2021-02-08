@extends('layout.login')
@section('title')
    Signup
@endsection

@section('content')

    @if (Session::has('created'))
        <div class="alert alert-success">
            {{Session::get('created')}}
        </div>
    @endif
    @if (Session::has('notAgree'))
        <div class="alert alert-danger">
            {{Session::get('notAgree')}}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    {{$error}}
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{url('/createaccount')}}" method="POST" class="login100-form validate-form" enctype="multipart/form-data">
        @csrf
        <a href="{{url('/')}}">
            <span class="login100-form-logo">
                <i class="zmdi zmdi-landscape"></i>
            </span>
        </a>

        <span class="login100-form-title">Signup</span>

        <div class="wrap-input100 validate-input" data-validate = "Enter name">
            <input class="input100" type="text" name="name" placeholder="Full Name">
            <span class="focus-input100" data-placeholder="&#xf207;"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Enter username">
            <input class="input100" type="text" name="email" placeholder="Email">
            <span class="focus-input100" data-placeholder="&#xf112;"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Enter password">
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100" data-placeholder="&#xf191;"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Enter image">
            <input class="input100" type="file" name="image" placeholder="Password">
            {{-- <span class="focus-input100" data-placeholder="&#xf1c5;"></span> --}}
        </div>

        <div class="contact100-form-checkbox">
            <input class="input-checkbox100" id="ckb1" type="checkbox" name="agree" value="agree">
            <label class="label-checkbox100" for="ckb1">I agree to your terms</label>
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">Signup</button>
        </div>

        <div class="text-center mt-3">
            <a class="txt1" href="{{url('/login')}}">
                Already have an account ? Signin
            </a>
        </div>
    </form>

@endsection

