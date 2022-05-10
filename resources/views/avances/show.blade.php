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
                            <div class="preview_inner" style="border: 1px solid;"><img src="<?php echo url('/'); ?>/storage/images/{{$avance->file}}" class="pin" easypin-id="image-{{ $avance->id }}"  /></div>
                            @endif
                        </div>
                        <input class="coords btn  btn-primary" type="button" value="Guardar comentarios" />
                    </div>
                    
                    <div class="col-xs-12 col-sm-3 col-md-3 form_check">
                        {!! Form::model($avance, ['method' => 'PATCH','route' => ['avances.update', $avance->id], 'enctype'=>'multipart/form-data' ]) !!}
                        <div class="form-group">
                            <strong>Opciones del cliente :</strong>
                            <select class="estado form-control" name="estado">
                                <option>Seleccionar una opcion</option>
                                <option value="Revisado" >Revisado</option>
                                <option value="cambio" >solicitar Cambio</option>
                            </select>
                        </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                        <button type="submit" class="btn btn-primary btn_rev">Indicar revisado y Ok</button>
                        <a href="javascript:void(0)" class="btn btn-primary btn_com">Ir al ingreso de comentarios</a>
                    </div>
                    <input type="hidden" name="avance-{{$avance->id}}" id="avance-{{$avance->id}}" value="{{$avance->comentarios}}" />

                        {!! Form::close() !!}
                    </div>

                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="easy-modal" style="display:none;" modal-position="free">
    <form>
        <h3>type name of hero</h3>
        <input type="text" class="form-control" name="content" placeholder="type">
        <br>
        <button type="button" class="btn btn-primary easy-submit">Guardar comentario</button>
    </form>
</div>
<div style="display:none;" width="130" shadow="true" popover="">
    <div style="width:100%;text-align:center;">{[content]}</div>
</div>
@section('javascript')
<script>
    $(document).ready(function(){
        var $easyInstance = $('.pin').easypin({
            init: $('#avance-{{$avance->id}}').val() || null,
            modalWidth: 300,
            markerSrc: '{{ URL::asset("images/marker.png") }}',
            editSrc: '{{ URL::asset("images/edit.png") }}',
            deleteSrc: '{{ URL::asset("images/remove.png") }}',
            done: function(element) {
                if($('input[name="content"]', element).val() != '') {
                    return true;
                }
                return false;
            }
        });
        $easyInstance.easypin.event( "get.coordinates", function($instance, data, params ) {
            console.log( data);
        });
        $( ".coords" ).click(function( event ) {
            $easyInstance.easypin.fire( "get.coordinates", function(data) {
                const dataToSave = JSON.stringify(data);
                $.ajax({
                    url: '{{ route('save_comment') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: '{{$avance->id}}',
                        data: Object.keys(data).length > 0 ? dataToSave : null
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            });
        });
    });
</script>
@stop
@endsection
