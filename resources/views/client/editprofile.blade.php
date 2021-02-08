@extends('layout.app')
@section('title')
    {{$client->name}}
@endsection

@section('content')

    {{-- updated success message --}}
    @if (Session::has('product_u'))
    <div class="alert alert-success">
        {{Session::get('product_u')}}
    </div>
    @endif
    <section class="ftco-section" style="background:#c9c9c9;">
        <div class="container h-100">
            <div class="row h-75 w-100">
                <div class="col d-flex justify-content-center align-items-center">
                    <form class="form w-50 p-5" action="{{url('/updateprofile', $client->id)}}" method="POST" style="background:#fff;"
                    enctype="multipart/form-data">
                        @csrf
                        <div>
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
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" name="name" value="{{$client->name}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{$client->email}}">
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success ">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
