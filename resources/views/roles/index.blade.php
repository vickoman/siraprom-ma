@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="mr-5">{{ __('Roles') }}</span>
                    <a href={{ route('roles.create')}}>Add new Role</a>
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
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                                @can('role-edit')
                                                    <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                                @endcan
                                                @can('role-delete')
                                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
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
