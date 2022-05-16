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
                    <span class="mr-5">{{ __('Creando Nuevo Avance') }}</span> 
                    <a href="{{ url()->previous() }}">Ir al avance Principal</a>
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

                    {!! Form::open(array('route' => 'avances.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
                    <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Id del Proyecto Principal:</strong> <?php echo $_GET['project_id'] ?>
                            <input type="hidden" readonly name="project_id" value="<?php echo $_GET['project_id'] ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre del avance:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Nombre del Avance','class' => 'form-control')) !!}
                            {!! Form::hidden('estado', null, array('placeholder' => 'estado del avance','class' => 'form-control', 'value' => 'Nuevo')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => "4", 'cols' => "52", 'placeholder' => 'Description del avance']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-7">
                        <div class="form-group">
                            <strong>Archivo del Avance:</strong><br>
                           <!-- {!! Form::file('file', null, ['class' => 'form-control file', 'placeholder' => '']) !!} -->
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5">
                        <div class="form-group">
                            <strong>Preview:</strong>
                            <div id="preview" class="preview">
                            <img src="" class="preview"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar avance</button>
                    </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
