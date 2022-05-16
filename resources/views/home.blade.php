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
                    {{ __('Has  sesión con éxito!') }}
                </div>
            </div>


<div class="row mt-3 px-3">

<div class="col-8  col-md-8 mb-4">
    <div class="row">
        <div class="bg-primary text-white p-3 mb-3">Indicadores usuarios</div>
    <!-- Total Usuarios -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Total Usuarios </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalUsers }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total de usuarios con el rol de Admin -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Usuarios Admin </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalUsersAdmin }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

   <!-- Total de Usuarios de rol Disenador -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Usuarios Disenador </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalUsersDisenador }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

       <!-- Total de Usuarios de rol cliente -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Usuarios Cliente </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalUsersCliente }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</div>
    <div class="col-xl-4 col-md-4 mb-4">
    
<canvas id="userChart" width="500" height="400"></canvas>

</div>

    <div class="col-xl-4 col-md-4 mb-4"> 
<canvas id="projectChart" width="500" height="400"></canvas>
</div>
<div class="col-8  col-md-8 mb-4">
    <div class="row">
                <div class="bg-success text-white p-3 mb-3">Indicadores Projects</div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Total Proyectos </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalProjects }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Proyectos Nuevos </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $ProyectosNuevos }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Proyectos en Progresos </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $ProyectosProgreso }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

        <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Proyectos Finalizados </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $ProyectosFinal }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>



<div class="col-8  col-md-8 mb-4">
    <div class="row">
                        <div class="bg-warning text-white p-3 mb-3">Indicadores Avances</div>

        <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> Total Avances </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalAvance }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

        <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> Nuevo Avances </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $AvancesNuevos }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

        <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> Avances Revisados </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $AvancesRevisados }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

        <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> Avances con cambios </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $AvancesCambios }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
</div>
<div class="col-xl-4 col-md-4 mb-4"> 
<canvas id="avanceChart" width="500" height="400"></canvas>
</div>


        </div>
    </div>
</div>
<script type="text/javascript">
 var userChart = document.getElementById("userChart");
var userData = {
    labels: [
        "Admin",
        "Disenador",
        "Clientes",

    ],
    datasets: [
        {
            data: [{{ $totalUsersAdmin }} , {{ $totalUsersDisenador }} , {{ $totalUsersCliente }} ],
            backgroundColor: [
                "#3C1148",
                "#F7CE1A",
                "#ffffff",
            ]
        }]
};
var pieChart = new Chart(userChart, {
  type: 'pie',
  data: userData
});


 var projectChart = document.getElementById("projectChart");
var projectData = {
    labels: [
        "Nuevo",
        "En Progreso",
        "Finalizado",

    ],
    datasets: [
        {
            data: [{{ $ProyectosNuevos }} , {{ $ProyectosProgreso }} , {{ $ProyectosFinal }} ],
            backgroundColor: [
                "#3C1148",
                "#F7CE1A",
                "#ffffff",
            ]
        }]
};
var pie2Chart = new Chart(projectChart, {
  type: 'pie',
  data: projectData
});


 var avanceChart = document.getElementById("avanceChart");
var avanceData = {
    labels: [
        "Admin",
        "Disenador",
        "Clientes",

    ],
    datasets: [
        {
            data: [{{ $totalUsersAdmin }} , {{ $totalUsersDisenador }} , {{ $totalUsersCliente }} ],
            backgroundColor: [
                "#3C1148",
                "#F7CE1A",
                "#ffffff",
            ]
        }]
};
var pie3Chart = new Chart(avanceChart, {
  type: 'pie',
  data: avanceData
});


</script>

@endsection
