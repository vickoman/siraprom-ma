@extends('layouts.app')

@section('content')
  <!--  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
        <div class="col-md-9 ">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Hola {{ Auth::user()->name }}</h3>

                <div class="card-body">
               @if ($message = Session::get('success'))
               <div class="alert alert-success" role="alert">
                  <p>{{ $message }}</p>
               </div>
               @endif
 

        <form method="POST" action="{{ url('/reports') }}">
            @csrf
            <div class="container">
    <div class="row">
            <div class="col-md-6 form-group {{ $errors->has('origen') ? 'has-error' : '' }}">
                <label for="origen">Escoja un origen</label>
                <select class="form-control" name="origen">
                    <option value="">Escoja una opcion</option>
                    <option value="Proyectos">Proyectos</option>
                    <option value="Usuarios">Usuarios</option>
                </select>
                <span class="text-danger">{{ $errors->first('origen') }}</span>
            </div>
            <div class="col-md-3 form-group {{ $errors->has('origen') ? 'has-error' : '' }}">
                <label for="subject">Escoja la fecha inicial</label>
                <input id="fecha_inicio" name="fecha_inicio" type="text" class="form-control" id="fecha_inicio" aria-describedby="fecha_inicio" placeholder="Fecha Inicial">
                <span class="text-danger">{{ $errors->first('fecha_inicio') }}</span>
            </div>
            <div class="col-md-3 form-group {{ $errors->has('fecha_final') ? 'has-error' : '' }}">
                <label for="subject">Escoja la fecha final</label>
<input id="fecha_final" name="fecha_final" type="text" class="form-control" id="fecha_final" aria-describedby="fecha_final" placeholder="Fecha Final">
<span class="text-danger">{{ $errors->first('fecha_final') }}</span>
            </div>
            <div class="form-group col-md-12 mt-2">
            <button type="submit" class="btn btn-primary">Descargar</button>
            </div>

        </div>
        </div></form>
                </div>
            </div>



        </div>


    </div>
</div>

@endsection


