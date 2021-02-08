@extends('layout.login')
@section('title')
	login
@endsection

@section('content')

	@if (Session::has('created'))
        <div class="alert alert-success">
            {{Session::get('created')}}
        </div>
    @endif
	@if (Session::has('error'))
        <div class="alert alert-danger">
            {{Session::get('error')}}
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

	<form action="{{url('/accessaccount')}}" method="POST" class="login100-form validate-form">
		@csrf
		<a href="{{url('/')}}">
			<span class="login100-form-logo">
				<i class="zmdi zmdi-landscape"></i>
			</span>
		</a>

		<span class="login100-form-title p-b-5 p-t-15">Log in</span>

		<div class="wrap-input100 validate-input" data-validate = "Enter username">
			<input class="input100" type="text" name="email" placeholder="Email">
			<span class="focus-input100" data-placeholder="&#xf207;"></span>
		</div>

		<div class="wrap-input100 validate-input" data-validate="Enter password">
			<input class="input100" type="password" name="password" placeholder="Password">
			<span class="focus-input100" data-placeholder="&#xf191;"></span>
		</div>

		<div class="contact100-form-checkbox">
			<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
			<label class="label-checkbox100" for="ckb1">Remember me</label>
		</div>

		<div class="container-login100-form-btn">
			<button class="login100-form-btn">Login</button>
		</div>

		<div class="text-center mt-3">
			<a class="txt1" href="#">
				Forgot Password?
			</a>
		</div>

		<div class="text-center">
			<a class="txt1" href="{{url('/signup')}}">
				Don't have an account? Signup
			</a>
		</div>

	</form>
@endsection