@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-3 rounded-3">
            <div class="container-fluid">
                <div class="row flex-nowrap">
                    <div class="col-12 col-md-12 px-0 bg-light rounded-3 sidebar">
                        <div class="d-flex flex-column align-items-center align-items-sm-start pt-2 text-white min-vh-100">
                        @include('sidebar');
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <span class="mr-5">{{ __('Editando Proyecto') }}</span>
                    <a href={{ route('projects.index')}}>Regresar al listado de Proyectos</a>
                </div>

                <div class="card-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Lo siento!</strong> Hubo algunos problemas con tu entrada.<br><br>
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
                            <strong>Titulo:</strong>
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
                            {!! Form::text('eta', null, array('placeholder' => 'Tiempo estiimado del proyecto','class' => 'form-control datepicker')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <string>Diseñador:</string>
                            <select class ="form-control" id="designer_id" name="designer_id">
                            @foreach ($designers as $udesigner)
                                <option  value="{{ $udesigner->id}}" {{ $udesigner->id == $designer->id ? 'selected':'' }}>{{$udesigner->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <string>Cliente:</string>
                            <select class ="form-control" id="client_id" name="client_id">
                            @foreach ($clients as $uclient)
                                <option  value="{{ $uclient->id }}" >{{$uclient->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Enviar</button>
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
