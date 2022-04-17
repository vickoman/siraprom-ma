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
                    <span class="mr-5">{{ __('Lista de usuarios') }}</span>
                    <a href={{ route('users.create')}}>Añadir nuevo usuario</a>
                </div>

                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="table-reponsive">
                        @if($data)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Nombre</td>
                                        <td>Email</td>
                                        <td>Rol</td>
                                        <td class="text-center">Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $v)
                                                <span class="badge badge-success {{ $v }}" 
                                                style="background: {{$user->roles->first()->color}}">{{ $v }}</span>
                                                @endforeach
                                            @endif
                                            </td>
                                            <td class="text-center">
                                            @can('user-show')
                                            <a class="btn btn-info" href="{{ route('users.show',$user->id) }}"><i class="bi bi-eye"></i> Ver</a>
                                            @endcan
                                            @can('user-edit')
                                            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}"><i class="bi bi-pencil-square"></i>  Editar</a>
                                            @endcan
                                            @can('user-delete')
                                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                               <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" title='Delete'><i class="bi bi-trash"></i>  Borrar </button>
                                             <!--   {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!} -->
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
