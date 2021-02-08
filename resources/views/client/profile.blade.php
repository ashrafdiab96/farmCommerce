@extends('layout.app')
@section('title')
    {{$client->name}}
@endsection

@section('content')
<section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-2 justify-content-center">
                    <img class="rounded-circle img-fluid" style="border:2px solid #c9c9c9; padding: 7px; box-shadow:-2px 1px 19px -3px rgba(0,0,0,0.88);" src="{{asset('client_images/'.$client->image.'')}}">
                    <div class="mt-3">
                        <h3>{{$client->name}}</h3>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="table-responsive">
                        @if (Session::has('profile_u'))
                            <div class="alert alert-success">
                                {{Session::get('profile_u')}}
                            </div>
                        @endif
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th colspan="2">Your Profile Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">ID</td>
                                    <td>{{$client->id}}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Name</td>
                                    <td>{{$client->name}}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Email</td>
                                    <td>{{$client->email}}</td>
                                </tr>
                                {{-- <tr>
                                    <td scope="row">Password</td>
                                    <td><input class="form-control w-75" type="password" value="{{}}" disable></td>
                                </tr> --}}
                                <tr>
                                    <td colspan="2"><a href="{{url('/editprofile', $client->id)}}" class="btn btn-success text-white">Edit Profile</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
