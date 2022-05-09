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
                    <span class="mr-5">{{ __('Detalle de avances') }}</span>
                    <a href="{{ url()->previous() }}">Regresar al listado de avances</a>
                </div>

                <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $avance->name }}
                        </div>
                    </div>
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $avance->description }}
                        </div>
                    </div>
                       <div class="col-xs-12 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>Preview:</strong>
                            @if($avance->file)
                            <div class="preview_inner" style="border: 1px solid;"><img src="<?php echo url('/'); ?>/storage/images/{{$avance->file}}"></div>
                            @endif
                        </div>


                    </div>
                    
                    <div class="col-xs-12 col-sm-3 col-md-3 form_check">
                        {!! Form::model($avance, ['method' => 'PATCH','route' => ['avances.update', $avance->id], 'enctype'=>'multipart/form-data' ]) !!}
                        <div class="form-group">
                            <strong>Opciones del cliente :</strong>
                            <select class="estado form-control" name="estado">
                                <option>Seleccionar una opcion</option>
                                <option value="Revisado" >Revisado</option>
                                <option value="cambio" >Solicitar cambios</option>
                            </select>
                        </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                        <button type="submit" class="btn btn-primary btn_rev">Indicar revisado y Ok</button>
                        <a href="#" class="btn btn-primary btn_com">Ir al ingreso de comentarios</a>
                    </div>
                    <div class="alert alert-success mt-2">
                        <strong>Nota:</strong>
                        <ul>
                            <li>Si no quiere solicitar un cambio y todo esta bien, escoja la opcion de revisado</li>
                            <li>Si quiere solicitar cambios escoja la opcion "Solicitar cambios" y lo dirigira a la seccion de comentarios</li>
                        </ul>
                    </div>
                        {!! Form::close() !!}
                    </div>

                    
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
