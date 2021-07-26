//funciones javascript y validaciones
   
function Limpiar(){
   swal({
      text: "\u00BFDesea Limpiar la p\u00E1gina?, si a\u00FAn no a grabado perdera los datos escritos...",
      icon: "info",
      buttons: {
         cancel: "Cancelar",
         ok: { text: "Aceptar", value: true,},
      }
   }).then((value) => {
      switch (value) {
         case true:
            window.location.reload();
            break;
         default:
           return;
      }
   });
}	

function Submit(){
   myform = document.forms.f1;
   myform.submit();
}

function printTable(){
   contenedor = document.getElementById("result");
   loadingCogs(contenedor);
   /////////// POST /////////
   var http = new FormData();
   http.append("request","tabla");
   var request = new XMLHttpRequest();
   request.open("POST", "ajax_funct_segmentos.php");
   request.send(http);
   request.onreadystatechange = function(){
      //console.log( request );
      if(request.readyState != 4) return;
      if(request.status === 200){
         //console.log(request.responseText);
         resultado = JSON.parse(request.responseText);
         if(resultado.status !== true){
              //console.log( resultado );
              contenedor.innerHTML = '...';
              swal("Error", resultado.message , "error");
              return;
         }
         //tabla
         var data = resultado.tabla;
         contenedor.innerHTML = data;
         $('#dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
               {extend: 'copy'},
               {extend: 'csv'},
               {extend: 'excel', title: 'Tabla de Grupos'},
               {extend: 'pdf', title: 'Tabla de Grupos'},
               {extend: 'print',
                  customize: function (win){
                     $(win.document.body).addClass('white-bg');
                     $(win.document.body).css('font-size', '10px');
                     $(win.document.body).find('table')
                           .addClass('compact')
                           .css('font-size', 'inherit');
                  }, title: 'Tabla de Grupos'
               }
            ]
         });
      }
   };     
}

         
function Grabar(){
   nom = document.getElementById('nom');
   area = document.getElementById("area");
   if(nom.value !="" && area.value != ""){
     /////////// POST /////////
      var boton = document.getElementById('gra');
      var http = new FormData();
      http.append("request","grabarSegmento");
      http.append("nom", nom.value);
      http.append("area", area.value);
      var request = new XMLHttpRequest();
      request.open("POST", "ajax_funct_segmentos.php");
      request.send(http);
      request.onreadystatechange = function(){
         //console.log( request );
         if(request.readyState != 4) return;
         if(request.status === 200){
             resultado = JSON.parse(request.responseText);
            if(resultado.status !== true){
               swal("Error", resultado.message , "error").then((value) => { deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar'); });
               return;
            }
            //console.log( resultado );
            swal("Excelente!", resultado.message, "success").then((value) => {
               deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar');
               printTable('');
            });
         }
      }; 
   }else{
      if(nom.value ==""){
         nom.className = "form-danger";
      }else{
         nom.className = "form-control";
      }
      if(area.value ==""){
         area.className = "form-danger";
      }else{
         area.className = "form-control";
      }
      swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
   }
}

function Modificar(){
   cod = document.getElementById('cod');
   nom = document.getElementById('nom');
   area = document.getElementById("area");
   
   if(nom.value !="" && area.value != ""){
      /////////// POST /////////
      var boton = document.getElementById("mod");
      //loadingBtn(boton);
      var http = new FormData();
      http.append("request","modificarSegmento");
      http.append("codigo", cod.value);
      http.append("nom", nom.value);
      http.append("area", area.value);
      var request = new XMLHttpRequest();
      request.open("POST", "ajax_funct_segmentos.php");
      request.send(http);
      request.onreadystatechange = function(){
         //console.log( request );
         if(request.readyState != 4) return;
         if(request.status === 200){
         resultado = JSON.parse(request.responseText);
            if(resultado.status !== true){
               swal("Error", resultado.message , "error").then((value) => { deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar'); });
               return;
            }
            //console.log( resultado );
            swal("Excelente!", resultado.message, "success").then((value) => {
               cod.value = '';
               nom.value = '';
               area.value = '';
               deloadingBtn(boton,'<i class="fa fa-save"></i> Grabar');
               printTable('');
               
            });
         }
         //botones
         document.getElementById("gra").className = "btn btn-primary btn-sm";
         document.getElementById("mod").className = "btn btn-primary btn-sm hidden";
      }; 	
   }else{
      if(nom.value ==""){
         nom.className = "form-danger";
      }else{
         nom.className = "form-control";
      }
      if(area.value ==""){
         area.className = "form-danger";
      }else{
         area.className = "form-control";
      }
      swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
   }
}

function Buscar_Segmento(codigo,area){
   contenedor = document.getElementById("result");
   loadingCogs(contenedor);
   /////////// POST /////////
   var http = new FormData();
   http.append("request","buscarSegmento");
   http.append("codigo",codigo);
   http.append("area",area);
   var request = new XMLHttpRequest();
   request.open("POST", "ajax_funct_segmentos.php");
   request.send(http);
   request.onreadystatechange = function(){
      //console.log( request );
      if(request.readyState != 4) return;
      if(request.status === 200){
         resultado = JSON.parse(request.responseText);
         if(resultado.status !== true){
            swal("Error", resultado.message , "error");
            return;
         }
         var data = resultado.data;
         //console.log( data );
         //set
         document.getElementById("nom").value = data.nombre;
         document.getElementById("area").value = data.area;
         document.getElementById("cod").value = data.codigo;
         //tabla
         var tabla = resultado.tabla;
         contenedor.innerHTML = tabla;
         printTable();
         //botones
         document.getElementById("nom").focus(); 
         document.getElementById("gra").className = "btn btn-primary btn-sm hidden";
         document.getElementById("mod").className = "btn btn-primary btn-sm";
         //--
      }
   };     
}
function Deshabilita_Segmento(codigo,area){
   swal({
      text: "\u00BFEsta seguro de deshabilitar este segmento?, No podra ser usado con esta situaci\u00F3n...",
      icon: "warning",
      buttons: {
         cancel: "Cancelar",
         ok: { text: "Aceptar", value: true},
      }
   }).then((value) => {
      switch (value) {
         case true:
            Situacion_Segmento(codigo,area,0);
            break;
         default:
           return;
      }
   });
}

function Situacion_Segmento(codigo,area,situacion){
   /////////// POST /////////
   var http = new FormData();
   http.append("request","situacionSegmento");
   http.append("codigo",codigo);
   http.append("area",area);
   http.append("situacion",situacion);
   var request = new XMLHttpRequest();
   request.open("POST", "ajax_funct_segmentos.php");
   request.send(http);
   request.onreadystatechange = function(){
      //console.log( request );
      if(request.readyState != 4) return;
      if(request.status === 200){
         resultado = JSON.parse(request.responseText);
         if(resultado.status !== true){
            //console.log( resultado.sql );
            swal("Error", resultado.message , "error");
            return;
         }
         swal("Excelente!", "Registro eliminado satisfactorio!!!", "success");
         printTable();
      }
   };     
}

//////------ Reportes -----------//////////

function ReporteLista(){
   myform = document.forms.f1;
   myform.action ="REPlista.php";
   myform.submit();
}

