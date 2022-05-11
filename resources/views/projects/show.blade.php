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
               <span class="mr-5">{{ __('Detalle de proyectos') }}</span>
               <a href={{ route('projects.index')}}>Regresar al listado de proyectos</a>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-md-8 col-sm-12 col-xs-12 ">
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <strong>Titulo:</strong>
                           {{ $project->title }}
                        </div>
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <strong>Descripcion:</strong>
                           {{ $project->description }}
                        </div>
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <strong>Tiempo estimado:</strong>
                           {{ $project->eta }}
                        </div>
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <strong>Diseñador a cargo:</strong>
                           {{ $designer->name }}
                        </div>
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <strong>Cliente:</strong>
                           {{ $client->name }}
                        </div>
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <strong>Estado:</strong>
                           {{ $project->estado  }}
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-12 col-xs-12 text-right">
                     @if ( $project->estado  != "Finalizado") 
                     @can('avance-create')
                     <a class="btn btn-primary" href="{{ route('avances.create',['project_id' => $project->id]) }}" ><i class="bi bi-pencil-square"></i>  Nuevo avance</a>
                     @endcan
                     @else
                     @if (!isset($data->file))
                     <a class="btn btn-primary" href="<?php echo url('/'); ?>/storage/zips/{{$project->final_file}}" ><i class="bi bi-pencil-square"></i>  Descargar Archivo</a>
                     @else
                     <p>Aun no hay un archivo final para descargar </p>
                     @endif
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12">
            <h2>Avances dentro del Proyecto</h2>
            <div class="card">
               <div class="card-header">
                  <span class="mr-5">{{ __('Listado de avances') }}</span>
               </div>
               <div class="card-body">
                  @if ($message = Session::get('success'))
                  <div class="alert alert-success" role="alert">
                     <p>{{ $message }}</p>
                  </div>
                  @endif
                  <div class="table-reponsive">
                     @if(count($avances) > 0)
                     <table class="table">
                        <thead>
                           <tr>
                              <td>#</td>
                              <td>Titulo</td>
                              <td>Descripcion</td>
                              <td class="text-center">Estado</td>
                              <td  class="text-center">Acciones</td>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($avances as $key => $avance)
                           <tr>
                              <td>{{ $avance->id }}</td>
                              <td>{{ $avance->name }}</td>
                              <td >{{ $avance->description }}</td>
                              <td>{{ $avance->estado }}</td>
                              <td  class="text-center">
                                 <a class="btn btn-info" href="{{ route('avances.show',$avance->id) }}"><i class="bi bi-eye"></i> Ver</a>
                                 @can('avance-edit')
                                 <a class="btn btn-primary" href="{{ route('avances.edit',$avance->id) }}"><i class="bi bi-pencil-square"></i>  Editar</a>
                                 @endcan
                                 @can('avance-edit')
                                 <button class="btn btn-primary" data-toggle="modal" data-target="#demoModal-{{ $client->id }}"><i class="bi bi-pencil-square"></i>  Enviar notificacion</button>
                                 <div class="modal fade" id="demoModal-{{ $client->id }}" tabindex="-1" role="dialog" aria- 
                                    labelledby="demoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="demoModalLabel" >Enviar notificacion a {{ $client->name }}</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria- 
                                                label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <form method="post" action="{{url('send')}}">
                                                @csrf
                                                <div class="form-group mb-2">
                                                   <label class="font-weight-bold">Correo a cual enviar </label>
                                                   <input style="pointer-events: none;" name="email" type="email" class="form-control" value="{{ $client->email }}" />
                                                </div>
                                                <div class="form-group mb-2">
                                                   <label class="font-weight-bold">Asunto del correo</label>
                                                   <input type="text" name="subject" class="form-control" value="Nuevo avance '{{ $avance->name }}'" />
                                                </div>
                                                <div class="form-group mb-2">
                                                   <label class="font-weight-bold">Mensaje a Enviar</label>
                                                   <textarea name="comment" class="form-control" rows="6">Hola estimado {{ $client->name }}, le saludamos de parte de TWM para comunicarle que hay un nuevo avance. Puede revisarlo en el siguiente enlace: {{ route('avances.show',$avance->id) }}</textarea>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                   <button type="submit" class="btn btn-primary">enviar Correo a {{ $client->email }}</button>
                                                </div>
                                             </form>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">Cerrar</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endcan
                                 @can('project-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['avances.destroy', $avance->id],'style'=>'display:inline']) !!}
                                 <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title='Delete'><i class="bi bi-trash"></i>  Borrar </button>
                                 <!--   {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} -->
                                 {!! Form::close() !!}
                                 @endcan
                              </td>
                           </tr>
                           <!-- Modal Example Start-->
                           @endforeach
                        </tbody>
                     </table>
                     <div> {{ $avances->links() }}</div>
                     @else
                     <p>No hay proyectos aun en la base de datos</p>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection