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
               <span class="mr-5">{{ __('Proyectos') }}</span>
              @can('project-edit') <a href={{ route('projects.create')}}>Añadir nuevo proyecto</a>@endcan
            </div>
            <div class="card-body">
               @if ($message = Session::get('success'))
               <div class="alert alert-success" role="alert">
                  <p>{{ $message }}</p>
               </div>
               @endif
               <div class="table-reponsive">
                  @if(count($projects) > 0)
                  <table class="table">
                     <thead>
                        <tr>
                           <td class="col d-none">#</td>
                           <td class="col-2">@sortablelink('title', 'Titulo')</td>
                           <td class="col-3 d-none">Descripcion</td>
                           <td class="text-center col-1">@sortablelink('estado', 'Estado')</td>
                           <td class="text-center col-2 d-none">@sortablelink('eta', 'Tiempo Estimado')</td>
                           <td  class="text-center col-4">Acciones</td>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($projects as $key => $project)
                        <tr>
                           <td class="d-none">{{ ++$i }}</td>
                           <td>{{ $project->title }}</td>
                           <td class="d-none">{{ $project->description }}</td>
                           <td class="text-center"><span class="{{ $project->estado }}">{{ $project->estado }}</span></td>
                           <td class="text-center d-none">{{ date('j/m/Y', strtotime($project->eta)) }}</td>
                           <td  class="text-center">
                              @can('project-show')
                              <a class="btn btn-info" href="{{ route('projects.show',$project->id) }}"><i class="bi bi-eye"></i> Revisar avances</a>
                              @endcan
                              @can('project-edit')
                              <a class="btn btn-primary" href="{{ route('projects.edit',$project->id) }}"><i class="bi bi-pencil-square"></i>  Editar</a>
                              @endcan
                              @can('project-delete')
                              {!! Form::open(['method' => 'DELETE','route' => ['projects.destroy', $project->id],'style'=>'display:inline']) !!}
                              <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title='Delete'><i class="bi bi-trash"></i> </button>
                              <!--   {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} -->
                              {!! Form::close() !!}
                              @endcan
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div> {!! $projects->appends(Request::except('page'))->render() !!}</div>
                  @else
                  <p>No hay proyectos aun en la base de datos</p>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection