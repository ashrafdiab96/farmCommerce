@extends('layout.appadmin')
@section('title')
    Create Slider
@endsection

@section('content')
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create New Slider</h4>
                        {{-- ass slider success message --}}
                        @if (Session::has('status_s_a'))
                            <div class="alert alert-success">
                                {{Session::get('status_s_a')}}
                            </div>
                        @endif
                        {!!Form::open(['action' => 'App\Http\Controllers\SliderController@saveSlider', 'class' => 'cmxform', 
                        'method' => 'POST', 'id' => 'commentForm', 'enctype' => 'multipart/form-data'])!!}
                        {{csrf_field()}}
                        <div class="form-group">
                            {{Form::label('', 'Description One', ['for' => 'cname'])}}
                            {{Form::text('desc_one', '', ['class' => 'form-control', 'minlength' => '3'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Description Two', ['for' => 'cname'])}}
                            {{Form::text('desc_two', '', ['class' => 'form-control', 'minlength' => '3'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Slider Image', ['for' => 'cname'])}}
                            {{Form::file('slider_image', ['class' => 'form-control'])}}
                        </div>
                        {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                        {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="backend/js/bt-maxLength.js"></script>
@endsection
