$(document).ready(function (e) {
      //  Evitar click derecho
      //  document.oncontextmenu = function(){return false}


   // script para las particulas
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
//script para los estado de proyectos
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


//script para los estado de avances
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

//script para la confirmacion de la eliminacion de proyectos, roles, usuarios y avances
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

                  $('.datepicker').datepicker({
         format: 'yyyy-mm-dd',
         startDate: '0d'
      });


         $('#file').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
               $('#preview img').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
         });
});