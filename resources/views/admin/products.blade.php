@extends('layout.appadmin')
@section('title')
    Products
@endsection

@section('content')
    {{Form::hidden('', $increment = 1)}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Products</h4>
            {{-- deleted success message --}}
            @if (Session::has('product_d'))
                <div class="alert alert-success">
                    {{Session::get('product_d')}}
                </div>
            @endif
            {{-- deleted Faild message --}}
            @if (Session::has('product_nd'))
                <div class="alert alert-danger">
                    {{Session::get('product_nd')}}
                </div>
            @endif
            {{-- updated success message --}}
            @if (Session::has('product_u'))
                <div class="alert alert-success">
                    {{Session::get('product_u')}}
                </div>
            @endif
            {{-- activated success message --}}
            @if (Session::has('product_a'))
                <div class="alert alert-success">
                    {{Session::get('product_a')}}
                </div>
            @endif
            {{-- activated failed message --}}
            @if (Session::has('product_na'))
                <div class="alert alert-success">
                    {{Session::get('product_na')}}
                </div>
            @endif
            {{-- deactivated success message --}}
            @if (Session::has('product_da'))
                <div class="alert alert-success">
                    {{Session::get('product_da')}}
                </div>
            @endif
            {{-- deactivated failed message --}}
            @if (Session::has('product_nda'))
                <div class="alert alert-success">
                    {{Session::get('product_nda')}}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{$increment}}</td>
                                        <td><img src ="product_images/{{$product->product_image}}" alt="" /></td>
                                        <td>{{$product->product_name}}</td>
                                        <td>$ {{$product->product_price}}</td>
                                        <td>{{$product->product_category}}</td>
                                        @if ($product->status == 1)
                                            <td><label class="badge badge-success">Activated</label></td>
                                        @else
                                            <td><label class="badge badge-danger">Unactivated</label></td>
                                        @endif
                                        <td>
                                            <a href="{{url('/editproduct', $product->id)}}" class="btn btn-outline-primary">Edit</a>
                                            <a href="{{url('/deleteproduct', $product->id)}}" class="btn btn-outline-danger" onclick="return confirm('Do you want to delete {{$product->product_name}}')">Delete</a>
                                            @if ($product->status == 1)
                                                <a href="{{url('deactivateproduct', $product->id)}}" class="btn btn-outline-warning">Deactivate</a>
                                            @else
                                                <a href="{{url('activateproduct', $product->id)}}" class="btn btn-outline-success">Activate</a>
                                            @endif
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
    <script src="{{asset('backend/js/data-table.js')}}"></script>
@endsection
