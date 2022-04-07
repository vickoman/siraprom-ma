@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="mr-5">{{ __('List of users') }}</span>
                    <a href={{ route('users.create')}}>Add new user</a>
                </div>

                <div class="card-body">
                    <div class="table-reponsive">
                        @if($data)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Email</td>
                                        <td>Creado</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>
                                                <a href="{{ route('users.edit', $row->id)}}" class="btn btn-primary">Editar</a>
                                                <form method="POST" action="{{ route('users.destroy', $row->id)}}">
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        No hay users aun en la base de datos
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
