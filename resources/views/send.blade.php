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
 


        <form method="POST" action="/send">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="email">Email address</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp"
                    placeholder="Enter your email">
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="subject">Asunto</label>
                <input name="subject" type="text" class="form-control" id="name" aria-describedby="name" placeholder="Tu Asunto">
                <span class="text-danger">{{ $errors->first('subject') }}</span>

            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="exampleInputPassword1">Comment</label>
                <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="3"> </textarea>
                <span class="text-danger">{{ $errors->first('comment') }}</span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
