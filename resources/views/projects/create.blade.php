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
                    <span class="mr-5">{{ __('Creando Nuevo proyecto') }}</span>
                    <a href={{ route('projects.index')}}>Ir a listado de proyectos</a>
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

                    {!! Form::open(array('route' => 'projects.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
                    <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Titulo del proyecto:</strong>
                            {!! Form::text('title', null, array('placeholder' => 'Titulo del Proyecto','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => "4", 'cols' => "52", 'placeholder' => 'Description del proyecto']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Tiempo Estimado de Entrega:</strong>
                            {!! Form::text('eta', null, ['class' => 'form-control datepicker', 'placeholder' => '']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Dise??ador:</strong>
                            <!-- {!! Form::text('designer', null, ['class' => 'form-control', 'placeholder' => 'search designer']) !!} -->
                            {!! Form::select('designer_id', $designers->pluck('name', 'id'), null, [ 'class' => 'form-control', 'placeholder' => 'Selecciona dise??ador responsable']) !!}
                            
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Cliente:</strong>
                            {!! Form::select('client_id', $clients->pluck('name', 'id'), null, [ 'class' => 'form-control', 'placeholder' => 'Selecciona cliente']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Estado del proyecto:</strong>
                            <select class="estado form-control" name="estado">
                                <option value="Nuevo">Nuevo</option>
                                <option value="En progreso">En progreso</option>
                                <option value="Finalizado">Finalizado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group final_cont">
                            <strong>Subir archivo Final del Proyecto</strong>
                            <input type="file" name="final_file" id="final_file" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
                    </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
