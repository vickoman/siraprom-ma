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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $avance->description }}
                        </div>
                    </div>
                       <div class="col-xs-12 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>Preview:</strong>
                            @if($avance->file)
                            <div class="preview_inner pinParent" style="border: 1px solid;"><img src="<?php echo url('/'); ?>/storage/images/{{$avance->file}}" class="pin easypin-target" easypin-id="example_image1">
        <!-- dialog window -->
        <div class="easy-modal" style="display:none;" modal-position="free">
            Escriba el avance: <input name="content" type="text">
            <input type="button" value="Actualizar pin!" class="easy-submit btn btn-primary">
        </div>

        <!-- popover -->
        <div style="display:none;" width="130" shadow="true" popover>
            <div style="width:100%;text-align:center;">{[content]}</div>
        </div>
                            </div>
                            @endif
                        </div>

        <input class="coords btn  btn-primary" type="button" value="Guardar comentarios" />

                    </div>
                    
                    <div class="col-xs-12 col-sm-3 col-md-3 form_check">
                        {!! Form::model($avance, ['method' => 'PATCH','route' => ['avances.update', $avance->id], 'enctype'=>'multipart/form-data' ]) !!}
                        <div class="form-group">
                            <strong>Opciones del cliente :</strong>
                            <select class="estado form-control" name="estado">
                                <option value="">Seleccionar una opcion</option>
                                <option value="Revisado" >Revisado</option>
                                <option value="cambio" >Solicitar cambios</option>
                            </select>
                        </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                        <button type="submit" class="btn btn-primary btn_rev ">Indicar revisado y Ok</button>
                                           <div class="alert alert-success mt-2 btn_com d-none">
Ingrese los comentarios <strong><em>dando click en la imagen</em></strong> y luego guardelo  con el boton de abajo
                    </div> 
                        <a href="#" class="btn btn-primary btn_com">Guardar comentario</a>
                    </div>
                    <div class="alert alert-success mt-4">
                        <strong>Nota:</strong>
                        <ul>
                            <li>Si no quiere solicitar un cambio y todo esta bien, <strong>escoja la opcion de revisado</strong></li>
                            <br>
                            <li>Si quiere solicitar cambios <strong>escoja la opcion "Solicitar cambios"</strong> y lo dirigira a la seccion de comentarios</li>
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
@section('javascript')
  <script type="text/javascript">
    jQuery(document).ready(function($){

        var $easyInstance = $('.pin').easypin({
             markerSrc: '{{ URL::asset("images/marker.png") }}',
             editSrc: '{{ URL::asset("images/edit.png") }}',
             deleteSrc: '{{ URL::asset("images/remove.png") }}',
            init: '{"example_image1":{}}',
            done: function(element) {
                console.log(element);
                return true;
            }
        });

        $easyInstance.easypin.event( "get.coordinates", function($instance, data, params ) {

            console.log( data, params);

        });

        $( ".coords" ).click(function( event ) {
            $easyInstance.easypin.fire( "get.coordinates", {param1: 1, param2: 2, param3: 3}, function(data) {
                return JSON.stringify(data);
            });
        });

    });
 </script>
@stop
@endsection
