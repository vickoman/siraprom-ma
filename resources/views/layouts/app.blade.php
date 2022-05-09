<!doctype html>


<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Scripts -->
      <script src="{{ URL::asset('js/app.js') }}" defer></script>
      <script src="{{ URL::asset('js/custom.js') }}" defer></script>
      <link rel="icon" href="https://twm.ec/wp-content/uploads/2021/11/68914796_427655731202950_4963250347398135808_n-150x150.jpg" sizes="32x32">
      <link rel="icon" href="https://twm.ec/wp-content/uploads/2021/11/68914796_427655731202950_4963250347398135808_n-300x300.jpg" sizes="192x192">
      <link rel="apple-touch-icon" href="https://twm.ec/wp-content/uploads/2021/11/68914796_427655731202950_4963250347398135808_n-300x300.jpg">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
      <script src="{{ URL::asset('js/jquery.easypin.min.js') }}" defer></script>
      <!-- Fonts -->
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
      <!-- Styles -->
      <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
      <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
   </head>
   <body>
      <canvas id="canvas"></canvas>
      <div id="app" class="{{ Request::path() }}">
         <?php 
            if (Auth::check()) {
         ?>
         <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
               <a class="navbar-brand" href="{{ url('/') }}">
                  <!-- {{ config('app.name', 'Laravel') }}  -->
                  <img src="https://twm.ec/wp-content/uploads/2021/11/LOGOWEB-01.png">
               </a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Left Side Of Navbar -->
                  <ul class="navbar-nav me-auto">
                  </ul>
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ms-auto">
                     <!-- Authentication Links -->
                     @guest
                     @if (Route::has('login'))
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                     </li>
                     @endif
                     @if (Route::has('register'))
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                     </li>
                     @endif
                     @else
                     <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                           <a class="dropdown-item" href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                           {{ __('Logout') }}
                           </a>
                           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                           </form>
                        </div>
                     </li>
                     @endguest
                  </ul>
               </div>
            </div>
         </nav>
         <?php 
            }
            ?>
         <main class="py-4">
            @yield('content')
         </main>
      </div>
   </body>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
   <script src="https://unpkg.com/starback@2.0.1/dist/starback.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script>
      const canvas = document.getElementById('canvas')
      const starback = new Starback(canvas, {
         type: 'dot',
         quantity: 200,
         direction: 225,
         backgroundColor: ['#BFB5C1', '#BFB5C1'],
         randomOpacity: true,
         speed: 0.1,
         starSize: 1,
      })
   </script>
   <script type="text/javascript">
      $(".estado").change(function(){
            change_estado();
      });
      change_estado();
      function change_estado(){
         if($(".estado").val() == "Finalizado"){
            $(".final_cont").show();
         }else{
            $(".final_cont").hide();
         }
      }


      $(".form_check select").change(function(){
            change_estado2();
      });
      change_estado2();
      function change_estado2(){
         if($(".form_check select").val() == "Revisado"){
         $(".form_check .btn_rev").show();
         $(".form_check .btn_com").hide();
      }
      if($(".form_check select").val() == "cambio"){
         $(".form_check .btn_rev").hide();
         $(".form_check .btn_com").show();
      }
      }
   </script>
   <script type="text/javascript">
      $('.show_confirm').click(function(event) {
         var form =  $(this).closest("form");
         var name = $(this).data("name");
         event.preventDefault();
         swal({
            title: `Estas seguro de borrar este registro?`,
            text: "Si lo borras, no podras recuperalo.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["No, cancelar!", "Ok"],
         })

         .then((willDelete) => {
            if (willDelete) {
               swal("El registro a sido borrado", {
                  icon: "success",
            });
            form.submit();
            }
         });
      });
   </script>
   <script type="text/javascript">
      $('.datepicker').datepicker({
         format: 'yyyy-mm-dd',
         startDate: '0d'
      });
   </script>
   <script type='text/javascript'>
      //  Evitar click derecho
      //  document.oncontextmenu = function(){return false}
   </script>
   <script type="text/javascript">
      $(document).ready(function (e) {
         $('#file').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
               $('#preview img').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
         });
      });
   </script>
   @yield('javascript')
</html>

