@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="mr-5">{{ __('Editing user') }}</span>
                    <a href={{ route('users.index')}}>Back to the list</a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="/users/{{ $user->id }}">
                        <input name="_method" type="hidden" value="PUT"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="nombres">Nombres:</label>
                            <input type="text" placeholder="Inserta los nombres" name="name" id="name" value="{{ $user->name }}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" placeholder="Email" name="email" id="email" value="{{ $user->email }}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" />
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
