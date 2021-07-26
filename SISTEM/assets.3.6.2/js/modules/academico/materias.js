//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "&iquest;Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function Submit(){
				myform = document.forms.f1;
				myform.submit();
			}
								
			function pageprint(){
				boton = document.getElementById("print");
				boton.className = "hidden";
				window.print();
				boton.className = "btn btn-default";
			}
						
		//////////////////////// MATERIAS ///////////////////////////////
			function Combo_Nivel_Grado_Materia(){
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				if(pensum.value !==""){
					xajax_Nivel_Grado(pensum.value,nivel.value,'grado','divgrado',"Combo_Grado_Materia();");
				}
			}
			
			function Combo_Grado_Materia(){
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				grado = document.getElementById('grado');
				if(pensum.value !==""){
					xajax_Grado_Materia(pensum.value,nivel.value,grado.value,'materia','divmateria',"");
				}
			}
		
			function Grabar(){
				
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				grado = document.getElementById("grado");
				desc = document.getElementById('desc');
				dct = document.getElementById('dct');
				tipo = document.getElementById("tipo");
				cate = document.getElementById("cate");
				orden = document.getElementById("orden");
				
				if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && desc.value !=="" && dct.value !=="" && tipo.value !=="" && cate.value !=="" && orden.value !==""){
					abrir();
					xajax_Grabar_Materia(pensum.value,nivel.value,grado.value,tipo.value,cate.value,orden.value,desc.value,dct.value);
					//botones
					gra = document.getElementById("gra");
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary';
					gra.className = 'btn btn-primary hidden';
				}else{
					if(pensum.value ===""){
						pensum.className = "form-danger";
					}else{
						pensum.className = "form-control";
					}
					if(nivel.value ===""){
						nivel.className = "form-danger";
					}else{
						nivel.className = "form-control";
					}
					if(grado.value ===""){
						grado.className = "form-danger";
					}else{
						grado.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(dct.value ===""){
						dct.className = "form-danger";
					}else{
						dct.className = "form-control";
					}
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					if(cate.value ===""){
						cate.className = "form-danger";
					}else{
						cate.className = "form-control";
					}
					if(orden.value ===""){
						orden.className = "form-danger";
					}else{
						orden.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");
					
				}
			}
			
			function Modificar(){
				
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				grado = document.getElementById("grado");
				cod = document.getElementById("cod");
				desc = document.getElementById('desc');
				dct = document.getElementById('dct');
				tipo = document.getElementById("tipo");
				cate = document.getElementById("cate");
				orden = document.getElementById("orden");
				
				if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && desc.value !=="" && dct.value !=="" && tipo.value !=="" && cate.value !=="" && orden.value !==""){
					abrir();
					xajax_Modificar_Materia(pensum.value,nivel.value,grado.value,cod.value,tipo.value,cate.value,orden.value,desc.value,dct.value);
					//botones
					gra = document.getElementById("gra");
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary hidden';
					gra.className = 'btn btn-primary';
				}else{
					if(pensum.value ===""){
						pensum.className = "form-danger";
					}else{
						pensum.className = "form-control";
					}
					if(nivel.value ===""){
						nivel.className = "form-danger";
					}else{
						nivel.className = "form-control";
					}
					if(grado.value ===""){
						grado.className = "form-danger";
					}else{
						grado.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(dct.value ===""){
						dct.className = "form-danger";
					}else{
						dct.className = "form-control";
					}
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					if(cate.value ===""){
						cate.className = "form-danger";
					}else{
						cate.className = "form-control";
					}
					if(orden.value ===""){
						orden.className = "form-danger";
					}else{
						orden.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los campos obligatorios...", "error");				
				}
			}
			
			function Confirm_Elimina_Materia(pensum,nivel,grado,cod){
				swal({
					title: "Confirmaci\u00F3n",
					text: "\u00BFEsta seguro de deshabilitar esta Materia con todos sus registros?",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: "Aceptar"
					},
					dangerMode: false,
				}).then((willDelete) => {
					if(willDelete) {
						xajax_CambiaSit_Materia(pensum,nivel,grado,cod);
					}
				});
			}
			
			