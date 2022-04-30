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
                    <span class="mr-5">{{ __('Roles') }}</span>
                    <a href={{ route('roles.create')}}>Añadir nuevo Rol</a>
                </div>

                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="table-reponsive">
                        @if($roles)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Nombre de Rol</td>
                                        <td colspan="2" class="text-center">Color</td>
                                        <td  class="text-center">Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $role->name }}</td>
                                        <td field-key='color'>{{ $role->color }}</td><td style="background:{{ $role->color }}"></td>
                                            <td  class="text-center">
                                            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}"><i class="bi bi-eye"></i> Ver</a>
                                                @can('role-edit')
                                                    <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}"><i class="bi bi-pencil-square"></i>  Editar</a>
                                                @endcan
                                                @can('role-delete')
                                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
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
                            <p>No hay users aun en la base de datos</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
