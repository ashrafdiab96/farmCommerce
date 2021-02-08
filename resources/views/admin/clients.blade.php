@extends('layout.appadmin')
@section('title')
    Clients
@endsection

@section('content')
    {{-- Increment object to show the clients order --}}
    {{Form::hidden('', $increment = 1)}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Clients</h4>
            {{-- when client set or remove as admin --}}
            @if (Session::has('client_s'))
                <div class="alert alert-success">
                    {{Session::get('client_s')}}
                </div>
            @endif
            {{-- when client can't set or remove as admin --}}
            @if (Session::has('client_ns'))
                <div class="alert alert-danger">
                    {{Session::get('client_ns')}}
                </div>
            @endif
            {{-- when client deleted --}}
            @if (Session::has('client_d'))
                <div class="alert alert-success">
                    {{Session::get('client_d')}}
                </div>
            @endif
            {{-- when client can't deleted --}}
            @if (Session::has('client_nd'))
                <div class="alert alert-danger">
                    {{Session::get('client_nd')}}
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Client Name </th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{$increment}}</td>
                                        <td>{{$client->name}}</td>
                                        <td>{{$client->email}}</td>
                                        <td>
                                            @if ($client->is_admin == 0)
                                                <a href="{{url('/setadmin', $client->id)}}" class="btn btn-outline-success" onclick="return confirm('Do you want to set {{$client->name}} as admin')">Set Admin</a>
                                            @endif
                                            @if ($client->is_admin == 1)
                                                <a href="{{url('/removeadmin', $client->id)}}" class="btn btn-outline-warning" onclick="return confirm('Do you want to remove {{$client->name}} as admin')">Remove Admin</a>
                                            @endif
                                            <a href="{{url('/deleteclient', $client->id)}}" class="btn btn-outline-danger" onclick="return confirm('Do you want to delete {{$client->name}}')">Delete</a>
                                        </td>
                                    </tr>
                                    {{Form::hidden('', $increment = $increment + 1)}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="backend/js/data-table.js"></script>
@endsection
