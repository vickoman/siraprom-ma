@extends('layouts.app')
@section('content')
<!--  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
               Aqui se mostrara los indicadores o metricas de proyectos de manera general, si desea estadisticas por fecha determinada utilice los campos de abajo <br>
               <h2>Cantidad de proyectos por mes</h2>
               <!-- <?php foreach ($user_info1 as $useri1): ?>
                  {{$useri1->estado}} - {{$useri1->total}}  - {{$useri1->new_date}}<br>
                  
                  <?php endforeach ?>-->
               <div class="col-xl-12 col-md-12 mb-12">
                  <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
               </div>
               <br><br>
               <?php foreach ($user_info as $useri): ?>
               {{$useri->estado}} - {{$useri->total}} - {{$useri->new_date}} <br>
               <?php endforeach ?>
               <div class="col-xl-12 col-md-12 mb-12"> </div>
            </div>
            <?php 
               $arr = array();
               $arr_n=array(); 
               foreach ($user_info1 as $useri1): 
                   $arr[] =$useri1->new_date;
               endforeach; 
               $unique_data = array_unique($arr);
               
                ?>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   jQuery(document).ready(function(){
     google.charts.load('current', {'packages':['bar']});
     google.charts.setOnLoadCallback(drawChart);
   function drawChart() {
       var data = google.visualization.arrayToDataTable([
         ['Mes', 'Nuevo', 'En progreso', 'Finalizado'],
   <?php 
      $i = 0;
          $nu[]=0;
              $pr[]=0;
                  $fz[]=0;
       foreach ($unique_data as $arr){          
      $nu[$i]=0;
      $pr[$i]=0;
      $fz[$i]=0;
        foreach ($user_info1 as $useri1):
      
      if(($useri1->new_date==$arr) and ($useri1->estado=="Nuevo")){$nu[$i]=$useri1->total; };
      if(($useri1->new_date==$arr) and ($useri1->estado=="En progreso")){ $pr[$i]=$useri1->total; };
      if(($useri1->new_date==$arr) and ($useri1->estado=="Finalizado")){$fz[$i]=$useri1->total; };
      endforeach;
      
         echo "['".$arr."',".$nu[$i].", ".$pr[$i].", ".$fz[$i]."],";    
      $i++;
      }
       ?>
       ]);
   
       var options = {
         chart: {
           title: 'Test',
         }
       };
   
       var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
   
       chart.draw(data, google.charts.Bar.convertOptions(options));
     }
   
   
   });
</script>
<!--<script type="text/javascript"></script>
   <?php 
      $arr = array();
      $arr_n=array(); 
      foreach ($user_info1 as $useri1): 
          $arr[] =$useri1->new_date;
      endforeach; 
      $unique_data = array_unique($arr);
       foreach ($unique_data as $arr1){
          foreach ($user_info1 as $useri1){ 
      if($useri1->new_date==$arr1){ 
          if($useri1->estado=='Nuevo' ) { 
              $arr_n[]=$useri1->new_date;
           }else { 
              $arr_n[]="0";
          }
      }
      print_r($arr_n);
       ?>
   <?php
      }
       }
      
      ?>
   
   
   <script type="text/javascript">
    var projectChart = document.getElementById("projectChart");
   
   var projectData = {
   
       labels: [<?php foreach ($unique_data as $arr1): ?>"{{$arr1}}",<?php endforeach ?>],
   
       datasets: [
           {
   
               label: 'Nuevo',
               data: [ 
   
               <?php foreach ($user_info1 as $useri1): ?><?php if($useri1->estado=='Nuevo') { ?>{{$useri1->total}},<?php }else { echo "0,"; } ?><?php endforeach ?>
               ],
               //data: [<?php foreach ($unique_data as $arr1): ?>
                   <?php foreach ($user_info1 as $useri1): ?><?php if($useri1->new_date==$arr1){ if($useri1->estado=='Nuevo' ) { ?>{{$useri1->total}},<?php }else { echo "0,";}} ?><?php endforeach ?>
               <?php endforeach ?>
               ],
               backgroundColor: [
                   "#3C1148",
               ]
           },
           {
   
               label: 'En Progreso',
               data: [<?php foreach ($user_info1 as $useri1): ?><?php if($useri1->estado=='En progreso') { ?>{{$useri1->total}},<?php }else { echo "0,"; } ?><?php endforeach ?>],
               backgroundColor: [
                   "#F7CE1A",
               ]
           },
           {
   
               label: 'Finalizado',
               data: [ <?php foreach ($user_info1 as $useri1): ?><?php if($useri1->estado=='Finalizado') { ?>{{$useri1->total}},<?php }else { echo "0,"; } ?><?php endforeach ?> ],
               backgroundColor: [
                   "#f00fff",
               ]
           }
           ]
   };
   var pie2Chart = new Chart(projectChart, {
     type: 'bar',
     data: projectData,
    options: {
       responsive: true,
    }
   
   
   
   });
   
   
   
   
    var projectChart2 = document.getElementById("projectChart2");
   
   var projectData2 = {
       labels: [
           "Nuevo",
           "En Progreso",
           "Finalizado",
   
       ],
       datasets: [
           {
   
               label: 'Contidad de proyectos en total',
               data: [ <?php foreach ($user_info as $useri): ?>
                   {{$useri->total}},<?php endforeach ?> ],
               backgroundColor: [
                   "#3C1148",
                   "#F7CE1A",
                   "#ffffff",
               ]
           }]
   };
   var pie2Chart2 = new Chart(projectChart2, {
     type: 'line',
     data: projectData2
   });
   
   
   </script>
   -->
@endsection
