@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="mr-5">{{ __('Editing  Project') }}</span>
                    <a href={{ route('projects.index')}}>Back to the list</a>
                </div>

                <div class="card-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif

                {!! Form::model($project, ['method' => 'PATCH','route' => ['projects.update', $project->id]]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Title:</strong>
                            {!! Form::text('title', null, array('placeholder' => 'Titulo del proyecto','class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {!! Form::text('description', null, array('placeholder' => 'Descripcion del proyecto','class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Tiempo estimado:</strong>
                            {!! Form::text('eta', null, array('placeholder' => 'Descripcion del proyecto','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <string>Diseñador:</string>
                            <select class ="form-control" id="designer_id" name="designer_id">
                            @foreach ($designers as $udesigner)
                                <option {{ $udesigner->id == $designer->id ? 'selected':'' }} value="{{ $udesigner->id}}">{{$udesigner->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <string>Cliente:</string>
                            <select class ="form-control" id="client_id" name="client_id">
                            @foreach ($clients as $uclient)
                                <option {{ $uclient->id == $client->id ? 'selected':'' }} value="{{ $uclient->id }}">{{$uclient->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
    <script>
        $('.colorpicker').colorpicker();
    </script>
@stop
@endsection
