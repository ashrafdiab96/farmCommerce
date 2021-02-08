@extends('layout.appadmin')
@section('title')
    Edit Product
@endsection

@section('content')
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Product</h4>
                    @if (Session::has('status_p_a'))
                        <div class="alert alert-success">
                            {{Session::get('status_p_e')}}
                        </div>
                    @endif
                    @if (Session::has('status_p_n'))
                        <div class="alert alert-danger">
                            {{Session::get('status_p_ne')}}
                        </div>
                    @endif
                    <form class="cmxform" action="{{url('/updateproduct', $product->id)}}" method="POST" id="commentForm"
                    enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            {{Form::label('', 'Product Name', ['for' => 'cname'])}}
                            {{Form::text('product_name', $product->product_name, ['class' => 'form-control', 'minlength' => '3'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Product Price', ['for' => 'cname'])}}
                            {{Form::number('product_price', $product->product_price, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Product Category')}}
                            {{Form::select('product_category', $categories, $product->product_category, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Product Image', ['for' => 'cname'])}}
                            {{Form::file('product_image', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Sale', ['for' => 'cname'])}}
                            <input type="checkbox" class="m-1" name="sale" {{$product->sale == 1 ? 'checked' : ''}} />
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Percent', ['for' => 'cname'])}}
                            {{Form::number('percent', $product->percent, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('', 'Sale Price', ['for' => 'cname'])}}
                            {{Form::number('sale_price', $product->sale_price, ['class' => 'form-control'])}}
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
