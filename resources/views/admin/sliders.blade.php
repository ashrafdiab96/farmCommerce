@extends('layout.appadmin')
@section('title')
    Sliders
@endsection

@section('content')
    {{Form::hidden('', $increment = 1)}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Sliders</h4>
            {{-- deleted success message --}}
            @if (Session::has('status_s_a'))
                <div class="alert alert-success">
                    {{Session::get('status_s_a')}}
                </div>
            @endif
            {{-- deleted Faild message --}}
            @if (Session::has('slider_nd'))
                <div class="alert alert-danger">
                    {{Session::get('slider_nd')}}
                </div>
            @endif
            {{-- update slider success message --}}
            @if (Session::has('slider_u'))
                <div class="alert alert-success">
                    {{Session::get('slider_u')}}
                </div>
            @endif
             {{-- activated success message --}}
            @if (Session::has('slider_a'))
                <div class="alert alert-success">
                    {{Session::get('slider_a')}}
                </div>
            @endif
            {{-- activated failed message --}}
            @if (Session::has('slider_na'))
                <div class="alert alert-success">
                    {{Session::get('slider_na')}}
                </div>
            @endif
            {{-- deactivated success message --}}
            @if (Session::has('slider_da'))
                <div class="alert alert-success">
                    {{Session::get('slider_da')}}
                </div>
            @endif
            {{-- deactivated failed message --}}
            @if (Session::has('slider_nda'))
                <div class="alert alert-success">
                    {{Session::get('slider_nda')}}
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
                                    <th>Description 1</th>
                                    {{-- <th>Description 2</th> --}}
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $slider)
                                    <tr>
                                    <td>{{$increment}}</td>
                                    <td><img src="slider_images/{{$slider->slider_image}}" /></td>
                                    <td>{{$slider->slider_desc1}}</td>
                                    {{-- <td>{{$slider->slider_desc2}}</td> --}}
                                    <td>
                                        @if ($slider->status == 1)
                                            <label class="badge badge-success">Activated</label>
                                        @else
                                            <label class="badge badge-danger">Deactivated</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('/editslider', $slider->id)}}" class="btn btn-outline-primary">Edit</a>
                                        <a href="{{url('/deleteslider', $slider->id)}}" onclick="return confirm('Do you want to delete the slider')" class="btn btn-outline-danger">Delete</a>
                                        @if ($slider->status == 1)
                                            <a href="{{url('deactivateslider', $slider->id)}}" class="btn btn-outline-warning">Deactivate</a>
                                        @else
                                            <a href="{{url('activateslider', $slider->id)}}" class="btn btn-outline-success">Activate</a>
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
    <script src="backend/js/data-table.js"></script>
@endsection
