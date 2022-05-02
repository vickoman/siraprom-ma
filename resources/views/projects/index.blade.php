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
                    <a href={{ route('projects.create')}}>Añadir nuevo proyecto</a>
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
                                        <td>#</td>
                                        <td>Titulo</td>
                                        <td>Descripcion</td>
                                        <td class="text-center">Estado</td>
                                        <td  class="text-center">Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $key => $project)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $project->title }}</td>
                                            <td >{{ $project->description }}</td>
                                            <td><span class="{{ $project->estado }}">{{ $project->estado }}</span></td>
                                            <td  class="text-center">
                                                @can('project-show')
                                            <a class="btn btn-info" href="{{ route('projects.show',$project->id) }}"><i class="bi bi-eye"></i> Revisar avances</a>
                                             @endcan
                                                @can('project-edit')
                                                    <a class="btn btn-primary" href="{{ route('projects.edit',$project->id) }}"><i class="bi bi-pencil-square"></i>  Editar</a>
                                                @endcan
                                                @can('project-delete')
                                                    {!! Form::open(['method' => 'DELETE','route' => ['projects.destroy', $project->id],'style'=>'display:inline']) !!}
                                                    <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title='Delete'><i class="bi bi-trash"></i>  Borrar </button>
                                                     <!--   {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} -->
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
