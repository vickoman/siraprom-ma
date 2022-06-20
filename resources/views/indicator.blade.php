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
               <h2>Tiempo que se demora el disenador en subir cambios</h2>
               <?php 
                  $arr_pr = array();
                        $ired = 0;
                  foreach ($rev_dis as $red1): ?>
               <?php 
                  $earlier = new DateTime($red1->created_at);
                  $later = new DateTime($red1->updated_at);
                  $rev_diff = $earlier->diff($later)->format("%r%a"); //3
                  
                        if(($red1->end_date==$red1)){  $ru_pr[$ired].=$ru_pr[$ired]+$rev_diff; };
                        
                   ?>
               <!-- {{$red1->created_at}} - {{$red1->updated_at}} - {{$red1->total}} - {{$red1->project_id}} - {{$rev_diff}} <br> -->
               <?php $arr_rev_dis[] =$red1->end_date;
                  endforeach; 
                  $new_arr[]=json_decode(json_encode($rev_dis), true);
                    $unique_rev_dis = array_unique($arr_rev_dis);
                  //   print_r($unique_rev_dis);
                   // echo sizeof($rev_dis); 
                    $i2=1;
                    for ($i=0; $i < count($rev_dis); $i++) { 
                        if($i2<count($rev_dis)){
                            //echo $new_arr[0][$i]['project_id']."<br>";
                           $val=$new_arr[0][$i2]['project_id'];
                        if($new_arr[0][$i]['project_id']==$val){
                        //echo $new_arr[0][$i]['created_at']."-".$new_arr[0][$i]['updated_at']."-".$new_arr[0][$i]['project_id']."<br>";
                  $earlier = new DateTime($new_arr[0][$i]['updated_at']);
                  $later = new DateTime($new_arr[0][$i2]['created_at']);
                  $pos_diff = intval($earlier->diff($later)->format("%r%a")); //3
                  echo $pos_diff." - " .$new_arr[0][$i]['created_at']. " - ". $new_arr[0][$i2]['project_id']."<br>";
                        }
                    $i2++;   
                                     } 
                    }
                      ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <div id="columnchart_rev_dis" style="width: 800px; height: 500px;"></div>
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
                     //   if(($rev1->end_date==$rev1)){ echo $ru_pr[$i].=$ru_pr[$i]+$rev_diff; };
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
   
   
   ////////////////////////////////////////////////////////////////////////////////////
   
     google.charts.load('current', {'packages':['bar']});
     google.charts.setOnLoadCallback(drawChart4);
   function drawChart4() {
       var data_pr = google.visualization.arrayToDataTable([
         ['Mes', 'Tiempo que se demora un disenador en subir un avance'],
   
   <?php 
      $i = 0;
      $ir=0;
             $ru_dis[]= (int) 0;
             $rev_diff2=0;
          foreach ($unique_rev_dis as $arr_rev_div){          
         
                       $i2=1;
                       for ($i=0; $i < count($rev_dis); $i++) { 
                           if($i2<count($rev_dis)){
                              $val=$new_arr[0][$i2]['project_id'];
                              $ru_dis[$i]=0;
                           if($new_arr[0][$i]['project_id']==$val){
         $earlier2 = new DateTime($new_arr[0][$i]['updated_at']);
         $later2 = new DateTime($new_arr[0][$i2]['created_at']);
       $rev_diff2 = intval($earlier2->diff($later2)->format("%r%a")); //3
         if(($new_arr[0][$i]['end_date']==$arr_rev_div)){ $ru_dis[$ir]= $ru_dis[$ir]+$rev_diff2; }

      } 
      // $ru_dis[$i]."<br>";
                       $i2++;   
                         } 
                       }
                       
         if($ir==0){$ver=2;}else{$ver=1;}
         $val_pr2=($ru_dis[$ir])/($ir+$ver);
           echo "['".$arr_rev_div."',".$val_pr2."],";   
      
         $ir++;
         
         }
         
         
         
         
          ?>
       ]);
   
       var options_pr = {
         chart: {
           title: 'Promedio x mes',
         }
       };
   
       var chart = new google.charts.Bar(document.getElementById('columnchart_rev_dis'));
   
       chart.draw(data_pr, google.charts.Bar.convertOptions(options_pr));
     }
   
   
   
   
   });
</script>
@endsection
