@extends('layout.appadmin')
@section('title')
    Create Product
@endsection

@section('content')
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create New Product</h4>
                    @if (Session::has('status_p_a'))
                        <div class="alert alert-success">
                            {{Session::get('status_p_a')}}
                        </div>
                    @endif
                    @if (Session::has('status_p_n'))
                        <div class="alert alert-danger">
                            {{Session::get('status_p_n')}}
                        </div>
                    @endif
                    {!!Form::open(['action' => 'App\Http\Controllers\ProductController@saveProduct', 'class' => 'cmxform', 
                    'method' => 'POST', 'id' => 'commentForm', 'enctype' => 'multipart/form-data'])!!}
                        {{csrf_field()}}
                        <div class="form-group">
                            {{Form::label('', 'Product Name', ['for' => 'cname'])}}
                            {{Form::text('product_name', '', ['class' => 'form-control', 'minlength' => '3'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Product Price', ['for' => 'cname'])}}
                            {{Form::number('product_price', '', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Product Category')}}
                            {{Form::select('product_category', $categories, null, ['placeholder' => 'Select Category', 'class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Product Image', ['for' => 'cname'])}}
                            {{Form::file('product_image', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Sale', ['for' => 'cname'])}}
                            <input type="checkbox" class="m-1" name="sale" />
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Percent', ['for' => 'cname'])}}
                            {{Form::number('percent', '', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Sale Price', ['for' => 'cname'])}}
                            {{Form::number('sale_price', '', ['class' => 'form-control'])}}
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
