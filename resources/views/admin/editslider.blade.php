@extends('layout.appadmin')
@section('title')
    Edit Slider
@endsection

@section('content')
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Slider</h4>
                    {{-- add slider success message --}}
                    @if (Session::has('status_s_u'))
                        <div class="alert alert-success">
                            {{Session::get('status_s_u')}}
                        </div>
                    @endif
                    <form class="cmxform" action="{{url('/updateslider', $slider->id)}}" method="POST" id="commentForm"
                        enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            {{Form::label('', 'Description One', ['for' => 'cname'])}}
                            {{Form::text('desc_one', $slider->slider_desc1, ['class' => 'form-control', 'minlength' => '3'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Description Two', ['for' => 'cname'])}}
                            {{Form::text('desc_two', $slider->slider_desc2, ['class' => 'form-control', 'minlength' => '3'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Slider Image', ['for' => 'cname'])}}
                            {{Form::file('slider_image', ['class' => 'form-control'])}}
                        </div>
                        {{Form::submit('Update', ['class' => 'btn btn-primary'])}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="backend/js/bt-maxLength.js"></script>
@endsection
