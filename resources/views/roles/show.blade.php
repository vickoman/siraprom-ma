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
                    <span class="mr-5">{{ __('Detalles de Roles') }}</span>
                    <a href={{ route('roles.index')}}>Regresar al list</a>
                </div>

                <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $role->name }}
                        </div>
                    </div>
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Rol:</strong>
                            {{ $role->role }}
                        </div>
                    </div>
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Color:</strong>
                            {{ $role->color }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permisos:</strong>
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    <label class="label label-success">{{ $v->name }},</label>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
