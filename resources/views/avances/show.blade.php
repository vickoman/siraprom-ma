
@extends('layouts.app')

@section('content')
<!--<script type='text/javascript'>

    jQuery(document).ready(function(){
  if( window.localStorage )
  {
    if( !localStorage.getItem('firstLoad') )
    {
      localStorage['firstLoad'] = true;
      window.location.reload();
    }  
    else
      localStorage.removeItem('firstLoad');
  }
    });

</script> -->
<script>
$(document).ready(function () {
    
    $( ".easy-edit" ).click(function( event ) {
  var $input = $('.easy-modal input.form-control'),
        $register = $('.easy-modal .easy-submit');
  $input.keyup(function () {
    var disable = false;

    $input.each(function () {
      if (!$(this).val()) {
        disable = true; 
        // terminate the .each loop
        return false;
      }
    });

    $register.prop('disabled', disable);
  });

});
});
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
        var url = $(".preview_inner img").attr("src");
        $(".preview_inner img").attr("src", url + `?v=${new Date().getTime()}`);
        $easyInstance.easypin.event( "get.coordinates", function($instance, data, params ) {
            console.log( data);
        });

        $( ".coords" ).click(function( event ) {
            var  estado= $(".estado").val();
            $easyInstance.easypin.fire( "get.coordinates", function(data) {
                const dataToSave = JSON.stringify(data);
                $.ajax({
                    url: '{{ route('save_comment') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: '{{$avance->id}}',
                        estado:estado,
                        data: Object.keys(data).length > 0 ? dataToSave : null
                    },
                    success: function(data) {
                        console.log(data);
            swal("Los comentarios fueron registrados con exito", {
                  icon: "success",
            });
                    }
                });
            });
        });

    });
</script>

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
                            <div class="preview_inner" style="border: 1px solid;">
                                <img src="<?php echo url('/'); ?>/storage/images/{{$avance->file}}" class="pin easypin-target" easypin-id="image-{{ $avance->id }}"  />
                            </div>
                            @endif
                        </div>
                       
                    </div>
                    
                    <div class="col-xs-12 col-sm-3 col-md-3 form_check">
                        {!! Form::model($avance, ['method' => 'PATCH','route' => ['avances.update', $avance->id], 'enctype'=>'multipart/form-data' ]) !!}
                        <div class="form-group">
                            <strong>Opciones del cliente :</strong>
                            <select class="estado form-control" name="estado">
                                <option>Seleccionar una opcion</option>
                                <option value="Revisado" {{ $avance->estado == "Revisado" ? 'selected':'' }}>Revisado</option>
                                <option value="Cambios Solicitados" {{ $avance->estado == "Cambios Solicitados" ? 'selected':'' }}>Solicitar Cambios</option>
                                <option value="Proyecto Finalizado" {{ $avance->estado == "Proyecto Finalizado" ? 'selected':'' }}>Finalizar Proyecto y Solicitar Archivos Finales</option>
                            </select>
                        </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                        <input class="coords btn  btn-primary btn_rev" type="button" value="Indicar revisado y Ok" />
                         <input class="coords btn  btn-primary btn_com" type="button" value="Guardar comentarios" />
                         <input class="coords btn  btn-primary btn_fin" type="button" value="Finalizar proyecto" />
                    </div>
                    <div class="alert alert-success mt-3">
                        <strong>Nota:</strong>
                        <ul>
                            <li>
                                Si todo esta correcto escoja la opcion <strong>"Revisado"</strong> 
                            </li>
                            <li>
                                Si desea solicitar cambios escoja la opcion <strong>Solicitar cambios</strong> y proceda a dar click en la imagen para agregar cambios
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" name="avance-{{$avance->id}}" id="avance-{{$avance->id}}" value='{{$avance->comentarios}}' />

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
        <h3 class="text-center">Escribir comentario</h3>
        <input type="text" class="form-control" name="content" placeholder="type">
        <br>
        <button type="button" class="btn btn-primary easy-submit">Guardar comentario</button>
    </form>
</div>
<div style="display:none;" width="130" shadow="true" popover="">
    <div style="width:100%;text-align:center;">{[content]}</div>
</div>
@section('javascript')
<?php 
         if(Auth::user()->hasRole('Disenador')){
             ?>
<script type="text/javascript">
    $(document).ready(function(){
    setTimeout(function() { 
         $(".preview_inner").addClass("blocked disenador_blocked");
         $(".preview_inner img").removeClass("pin easypin-target");
      });
});
</script>
             <?php
          }

 ?>


@stop
@endsection
