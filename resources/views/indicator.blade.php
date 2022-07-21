@extends('layouts.app')
@section('content')
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
               <h2>Hola {{ Auth::user()->name }}</h2>
               <hr>
               Aqui se mostrara los indicadores o metricas de proyectos de manera general, si desea estadisticas por fecha determinada utilice los campos de abajo <br>
               <hr>
               <form class="alert alert-primary" method="POST" action="{{ url('/indicators') }}">
                  @csrf
                  <div class="row">
                     <div class="col-md-3 form-group {{ $errors->has('origen') ? 'has-error' : '' }}">
                        <input id="fecha_inicio" name="fecha_inicio" type="text" class="form-control" id="fecha_inicio" aria-describedby="fecha_inicio" placeholder="Escoja la Fecha Inicial">
                        <span class="text-danger">{{ $errors->first('fecha_inicio') }}</span>
                     </div>
                     <div class="col-md-3 form-group {{ $errors->has('fecha_final') ? 'has-error' : '' }}">
                        <input id="fecha_final" name="fecha_final" type="text" class="form-control" id="fecha_final" aria-describedby="fecha_final" placeholder="Escoja la Fecha Final">
                        <span class="text-danger">{{ $errors->first('fecha_final') }}</span>
                     </div>
                     <div class="form-group col-md-3">
                        <button type="submit" class="btn btn-primary">Filtrar</button><a href="indicators" class="btn btn-primary mx-2">Reiniciar</a>
                     </div>
                  </div>
               </form>
               <h2>Cantidad de proyectos por mes</h2>
               <?php 
                  $arr = array();
                  $arr_n=array(); 
                  foreach ($user_info1 as $useri1): 
                      $arr[] =$useri1->new_date;
                  endforeach; 
                  $unique_data = array_unique($arr);           
                   ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <?php                if ($unique_data) {
                     ?>
                  <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
                  <?php } else { ?>
                  <div class="alert alert-warning">
                     No existe valores entre las fechas indicadas por favor seleccionar otro rango
                  </div>
                  <?php } ?>
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
             <!--  {{$pro1->created_at}} - {{$pro1->updated_at}} - {{$pro1->total}}  - {{$pos_diff}} <br> -->
               <?php $arr_pr[] =$pro1->end_date;
                  endforeach; 
                    $unique_pr = array_unique($arr_pr);
                  
                      ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <?php  if ($unique_pr){ ?>
                  <div id="columnchart_prpr" style="width: 100%; height: 500px;"></div>
                  <?php } else { ?>
                  <div class="alert alert-warning">
                     No existe valores entre las fechas indicadas por favor seleccionar otro rango
                  </div>
                  <?php } ?>
               </div>
               <!--------------------------------->
               <h2>Tiempo que se demora el cliente en revisar y pedir cambios</h2>
               <?php 
                  $arr_rev = array();
                  foreach ($rev_cliente as $rev1): ?>
               <?php 
                  $earlier = new DateTime($rev1->created_at);
                  $later = new DateTime($rev1->updated_at);
                  $rev_diff = $earlier->diff($later)->format("%r%a"); //3
                  
                        if(($rev1->end_date==$rev1)){ echo $ru_pr[$i].=$ru_pr[$i]+$rev_diff; };
                   ?>
              <!-- {{$rev1->created_at}} - {{$rev1->updated_at}}  - {{$rev_diff}} <br> -->
               <?php $arr_rev[] =$rev1->end_date;
                  endforeach; 
                    $unique_rev = array_unique($arr_rev);
                      ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <?php                if ($unique_rev) {
                     ?>
                  <div id="columnchart_rev_cli" style="width: 100%; height: 500px;"></div>
                  <?php } else { ?>
                  <div class="alert alert-warning">
                     No existe valores entre las fechas indicadas por favor seleccionar otro rango
                  </div>
                  <?php } ?>
               </div>
               <!--------------------------------->
               <h2>Tiempo que se demora el disenador en subir cambios</h2>
               <?php 
                  $arr_rev_dis = array();
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
                  //  echo $pos_diff." - " .$new_arr[0][$i]['created_at']. " - ". $new_arr[0][$i2]['project_id']."<br>";
                        }
                    $i2++;   
                                     } 
                    }
                      ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <?php                if ($unique_rev_dis) {
                     ?>
                  <div id="columnchart_rev_dis" style="width: 100%; height: 500px;"></div>
                  <?php } else { ?>
                  <div class="alert alert-warning">
                     No existe valores entre las fechas indicadas por favor seleccionar otro rango
                  </div>
                  <?php } ?>
               </div>
               <!--------------------------------->
               <h2>Tiempo promedio  que se demora en subir el primer cambio desde que se inicia el proyecto</h2>
                                 <?php       

    if ($primer_cambio=="[]") {
        $count_cambio= "0 ";
        echo '<div class="alert alert-warning">
                     No existe valores entre las fechas indicadas por favor seleccionar otro rango
                  </div>';
    }
    else{
             $count_cambio= $primer_cambio['averga_in_days'];
         }
                   ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <div id="columnchart_pry_init_avance" style="width: 300px; height: 300px; line-height: 300px; border-radius: 50%; background: #3C1148; margin: auto; display: flex; justify-content: center; align-items: center; color: #f7ce1a">
                     <div class="tiempo_promedio_primer_avance" style=" font-family: 'Commic Sans'; font-style: normal; font-weight: 400;font-size: 96px; line-height: 77px;">{{$count_cambio}}</div>
                     <span class="tiempo_promedio_primer_avance_dlabel">Dias</span>
                  </div>

               </div>
               <!--------------------------------->
               <h2>Numero de cambios solicitados por mes durante el desarrollo de los proyectos</h2>
               <?php 
                  $arr_com = array();
                  $in=0;
                  foreach ($num_com as $num_c): ?>
               <?php 
                  ?>
               <!--{{$num_c->project_id}} - {{$num_c->start_date}} -  {{$num_c->end_date}}  <br> -->
               <?php
                  $arr_com[] =$num_c->end_date;
                     endforeach; 
                       $unique_com = array_unique($arr_com);
                         ?>
               <div class="col-xl-12 col-md-12 mb-12">
                  <?php                if ($unique_com) {
                     ?>
                  <div id="columnchart_num_cm" style="width: 100%; height: 500px;"></div>
                  <?php } else { ?>
                  <div class="alert alert-warning">
                     No existe valores entre las fechas indicadas por favor seleccionar otro rango
                  </div>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   jQuery(document).ready(function(){
   /*
      // Get Indicator from ajax
      $.ajax({
         url: '{{ route('tiempo_promedio_primer_avance') }}',
         type: 'POST',
         data: {
            "_token": "{{ csrf_token() }}",
         },
         success: function(data) {
            console.log(data);
            $('.tiempo_promedio_primer_avance').text(data);
            $('.tiempo_promedio_primer_avance_dlabel').text(data > 1 ? 'Dias' : 'Dia');
         },
         error: function(err) {
            console.log(err);
            $('.tiempo_promedio_primer_avance').text('Null');
            $('.tiempo_promedio_primer_avance_dlabel').text('');
         }
      });
   */
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
         },
         responsive:true,
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
       foreach ($unique_pr as $arr_pr){  
             $count_div=0;        
      $nu_pr[$i]=0;
          foreach ($promedio as $pro1):
      $earlier = new DateTime($pro1->created_at);
      $later = new DateTime($pro1->updated_at);
      $pos_diff = intval($earlier->diff($later)->format("%r%a")); //3
      if(($pro1->end_date==$arr_pr)){ 
        $nu_pr[$i]=($nu_pr[$i]+$pos_diff);
        $count_div++;
         }
      
      endforeach;
         //   if($i==0){$ver=1;}else{$ver=0;}
      //$val_pr=($nu_pr[$i])/($i+$ver);
          //  echo $count_div;
      $val_pr=($nu_pr[$i])/$count_div;
         echo "['".$arr_pr."',".$val_pr."],";    
      $i++;
      }
       ?>
       ]);
   
       var options_pr = {
         chart: {
           title: 'Promedio x mes',
         },
         responsive:true,
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
            $count_div=0;
             foreach ($rev_cliente as $rev1): 
                  $earlier = new DateTime($rev1->created_at);
                  $later = new DateTime($rev1->updated_at);
                  $rev_diff = $earlier->diff($later)->format("%r%a"); //3
      if(($rev1->end_date==$arr_rev)){ 
        $ru_pr[$i]=($ru_pr[$i]+$rev_diff); 
        $count_div++;
      };
      endforeach;
      $val_pr=($ru_pr[$i])/($count_div);
      //if($i==0){$ver=1;}else{$ver=0;}
         echo "['".$arr_rev."',".$val_pr."],";    
      $i++;
      }
       ?>
       ]);
   
       var options_pr = {
         chart: {
           title: 'Promedio x mes',
         },
         responsive:true,
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
         $count_div=0;
                       $i2=1;
                       for ($i=0; $i < count($rev_dis); $i++) { 
                           if($i2<count($rev_dis)){
                              $val=$new_arr[0][$i2]['project_id'];
                              $ru_dis[$i]=0;
                           if($new_arr[0][$i]['project_id']==$val){
         $earlier2 = new DateTime($new_arr[0][$i]['updated_at']);
         $later2 = new DateTime($new_arr[0][$i2]['created_at']);
         $rev_diff2 = intval($earlier2->diff($later2)->format("%r%a")); //3
         if(($new_arr[0][$i]['end_date']==$arr_rev_div)){
          $ru_dis[$ir]= $ru_dis[$ir]+$rev_diff2; 
          $count_div++;
      }
      
      } 
                       $i2++;   
                         } 
                       }
                       
         //if($ir==0){$ver=1;}else{$ver=1;}
         //$val_pr2=($ru_dis[$ir])/($ir+$ver);
         $val_pr2=($ru_dis[$ir])/($count_div);
           echo "['".$arr_rev_div."',".$val_pr2."],";   
      
         $ir++;
         
         }
         ?>
       ]);
   
       var options_pr = {
         chart: {
           title: 'Promedio x mes',
         },
         responsive:true,
       };
   
       var chart = new google.charts.Bar(document.getElementById('columnchart_rev_dis'));
   
       chart.draw(data_pr, google.charts.Bar.convertOptions(options_pr));
     }
   
   
   
   ////////////////////////////////////////////////////////////////////////////////////
   


     google.charts.load('current', {'packages':['bar']});
     google.charts.setOnLoadCallback(drawChart5);
   function drawChart5() {
       var data_pr = google.visualization.arrayToDataTable([
         ['Mes', 'Numero de comentarios por mes '],
   
   <?php 
      $i = 0;
             $su_com[]= (int) 0;
             $rev_diff2=0;
          foreach ($unique_com as $unique_cm){          
      $su_com[$i]=0;
      
                  foreach ($num_com as $num_c): ?>
               <?php 
      $var_com=substr_count($num_c->comentarios, 'lat');
            if(($num_c->end_date==$unique_cm)){ $su_com[$i]=($su_com[$i]+$var_com); };
       ?>
   
               <?php
      endforeach; 
      if($i==0){$ver=2;}else{$ver=1;}
      ?>
         //console.log(<?php echo $su_com[$i]; ?>);
         <?php
      //$val_sum2=($su_com[$i])/($i+$ver);
        echo "['".$unique_cm."',".$su_com[$i]."],";   
      
      $i++;
      }
       ?>
       ]);
   
       var options_pr = {
         chart: {
           title: 'Promedio x mes',
         },
         responsive:true,
       };
       var chart = new google.charts.Bar(document.getElementById('columnchart_num_cm'));
          chart.draw(data_pr, google.charts.Bar.convertOptions(options_pr));
     }
   
   });
</script>
@endsection
