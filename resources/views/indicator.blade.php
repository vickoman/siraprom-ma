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
               <div class="col-xl-12 col-md-12 mb-12">
                  <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
               </div>
               <h2>Tiempo promedio de finalizacion de un proyecto por mes </h2>
               <?php 
                  $arr_pr = array();
                 foreach ($promedio as $pro1): ?>
               <?php 
                  $earlier = new DateTime($pro1->created_at);
                  $later = new DateTime($pro1->updated_at);
                  $pos_diff = $earlier->diff($later)->format("%r%a"); //3

                        if(($pro1->end_date==$pro1)){ echo $nu_pr[$i].=$nu_pr[$i]+$pos_diff; };
                   ?>

             <!--  {{$pro1->start_date}} - {{$pro1->end_date}} - {{$pro1->total}}  - {{$pos_diff}} <br>-->
               
               <?php $arr_pr[] =$pro1->end_date;
                  endforeach; 
                    $unique_pr = array_unique($arr_pr);
                      ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <div id="columnchart_prpr" style="width: 800px; height: 500px;"></div>
               </div>
               <h2>Tiempo que se demora el cliente en revisar y pedir cambios</h2>
               <?php 
                  $arr_pr = array();
                 foreach ($rev_cliente as $rev1): ?>
               <?php 
                  $earlier = new DateTime($rev1->created_at);
                  $later = new DateTime($rev1->updated_at);
                  $rev_diff = $earlier->diff($later)->format("%r%a"); //3

                        if(($rev1->end_date==$rev1)){ echo $ru_pr[$i].=$ru_pr[$i]+$rev_diff; };
                   ?>

             <!--  {{$rev1->start_date}} - {{$rev1->end_date}} - {{$rev1->total}}  - {{$rev_diff}} <br>-->
               
               <?php $arr_rev[] =$rev1->end_date;
                  endforeach; 
                    $unique_rev = array_unique($arr_rev);
                      ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <div id="columnchart_rev_cli" style="width: 800px; height: 500px;"></div>
               </div>
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
           //title: 'Test',
         }
       };
   
       var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
   
       chart.draw(data, google.charts.Bar.convertOptions(options));
     }
   
   
     google.charts.load('current', {'packages':['bar']});
     google.charts.setOnLoadCallback(drawChart2);
   function drawChart2() {
       var data_pr = google.visualization.arrayToDataTable([
         ['Mes', 'Promedio de dias que dura un proyecto por mes'],
   <?php 
      $i = 0;
          $nu_pr[]=(int) 0;
              $pr[]=0;
                  $fz[]=0;
       foreach ($unique_pr as $arr_pr){          
      $nu_pr[$i]=0;
          foreach ($promedio as $pro1):
     $earlier = new DateTime($pro1->created_at);
     $later = new DateTime($pro1->updated_at);
    $pos_diff = intval($earlier->diff($later)->format("%r%a")); //3
      if(($pro1->end_date==$arr_pr)){ $nu_pr[$i]=($nu_pr[$i]+$pos_diff); };
      endforeach;
    $val_pr=($nu_pr[$i])/($i+2);
         echo "['".$arr_pr."',".$val_pr."],";    
      $i++;
      }
       ?>
       ]);
   
       var options_pr = {
         chart: {
           title: 'Promedio x mes',
         }
       };
   
       var chart = new google.charts.Bar(document.getElementById('columnchart_prpr'));
   
       chart.draw(data_pr, google.charts.Bar.convertOptions(options_pr));
     }
   

   ////////////////////////////////////////////////////////////////////////////////////

     google.charts.load('current', {'packages':['bar']});
     google.charts.setOnLoadCallback(drawChart3);
   function drawChart3() {
       var data_pr = google.visualization.arrayToDataTable([
         ['Mes', 'Promedio de dias que dura un proyecto por mes'],
   <?php 
      $i = 0;
          $ru_pr[]=(int) 0;
       foreach ($unique_rev as $arr_rev){          
      $ru_pr[$i]=0;

             foreach ($rev_cliente as $rev1): 
                  $earlier = new DateTime($rev1->created_at);
                  $later = new DateTime($rev1->updated_at);
                  $rev_diff = $earlier->diff($later)->format("%r%a"); //3
                        if(($rev1->end_date==$rev1)){ echo $ru_pr[$i].=$ru_pr[$i]+$rev_diff; };
      if(($rev1->end_date==$arr_rev)){ $ru_pr[$i]=($ru_pr[$i]+$rev_diff); };
      endforeach;
      if($i==0){$ver=2;}else{$ver=1;}
    $val_pr=($ru_pr[$i])/($i+$ver);
         echo "['".$arr_rev."',".$val_pr."],";    
      $i++;
      }
       ?>
       ]);
   
       var options_pr = {
         chart: {
           title: 'Promedio x mes',
         }
       };
   
       var chart = new google.charts.Bar(document.getElementById('columnchart_rev_cli'));
   
       chart.draw(data_pr, google.charts.Bar.convertOptions(options_pr));
     }
   });
</script>
@endsection
