@extends('layout.default')
@section('css')
    <style>
        a, a:hover {
            color: white;
        }

        .form-group.required label:after {
            content: " *";
            color: red;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="col-md-8 offset-md-2">
                    <hr/>
                    @if(isset($pdf_file))
                        {!! Form::model($pdf_file,['method'=>'put','files'=>true]) !!}
                    @else
                        {!! Form::open(['files'=>true]) !!}
                    @endif
                    <div class="form-group row">
                        {!! Form::label("pdf_file","PDF file",["class"=>"col-form-label col-md-3 col-lg-2"]) !!}
                        <div class="col-md-5">
                            {!! Form::file("pdf_file",["class"=>"form-control","style"=>"display:inline"]) !!}
                            <br/>
                        </div>
                    </div>
                    <div class="form-group row required">
                        {!! Form::label("description","Description",["class"=>"col-form-label col-md-3 col-lg-2"]) !!}
                        <div class="col-md-6">
                            {!! Form::text("description",null,["class"=>"form-control".($errors->has('description')?" is-invalid":""),"autofocus",'placeholder'=>'Description']) !!}
                            {!! $errors->first('description','<span class="invalid-feedback">:message</span>') !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::button("Upload",["type" => "submit","class"=>"btn
                        btn-primary"])!!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            @foreach($pdf_files as $pdf_file)
                <div class="col-md-4 col-lg-3" style="margin-bottom: 20px">
                    <div class="card">
                        <a href="{{url('uploads/'.$pdf_file->pdf_file)}}">
                            <img class="card-img-top"
                                 src="{{url($pdf_file->pdf_file? 'uploads/thumbnails/'.$pdf_file->pdf_file.'.jpg':'uploads/thumbnails/no_file.jpg')}}"
                                 alt="{{$pdf_file->description}}" width="100%" height="180px">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title text-center">{{ucwords($pdf_file->description)}}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <nav>
            <ul class="pagination justify-content-end">
                {{$pdf_files->links('vendor.pagination.bootstrap-4')}}
            </ul>
        </nav>
    </div>
@endsection
