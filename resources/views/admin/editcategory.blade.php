@extends('layout.appadmin')
@section('title')
    Edit Category
@endsection

@section('content')
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Category</h4>
                    @if (Session::has('status'))
                        <div class="alert alert-success">
                            {{Session::get('status')}}
                        </div>
                    @endif
                    @if (Session::has('status1'))
                        <div class="alert alert-danger">
                            {{Session::get('status1')}}
                        </div>
                    @endif
                    <form class="cmxform" id="commentForm" action="{{url('/updatecategory', $category->id)}}"  method="POST">
                    {{-- {!!Form::open(['action' => 'App\Http\Controllers\CategoryController@updateCategory.'$category->id'.', 'class' => 'cmxform', 'method' => 'POST', 'id' => 'commentForm'])!!} --}}
                        {{csrf_field()}}
                        <div class="form-group">
                            {{Form::label('', 'Product Category', ['for' => 'cname'])}}
                            {{Form::text('category_name', $category->category_name, ['class' => 'form-control', 'minlength' => '3'])}}
                        </div>
                        {{Form::submit('Update', ['class' => 'btn btn-primary'])}}
                    {{-- {!!Form::close()!!} --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="backend/js/form-validation.js"></script> --}}
    <script src="{{asset('backend/js/bt-maxLength.js')}}"></script>
@endsection
