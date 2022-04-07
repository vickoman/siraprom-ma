@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="mr-5">{{ __('Creating user') }}</span>
                    <a href={{ route('users.index')}}>Back to the list</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="/users">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="nombres">Nombres:</label>
                            <input type="text" placeholder="Inserta los nombres" name="name" id="name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" placeholder="Email" name="email" id="email" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" placeholder="****" name="password" id="password" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
