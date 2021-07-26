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
		
			function GrabarMateria(){
				abrir();
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				grado = document.getElementById("grado");
				desc = document.getElementById('desc');
				dct = document.getElementById('dct');
				tipo = document.getElementById("tipo");
				
				if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && desc.value !=="" && dct.value !=="" && tipo.value !==""){
					xajax_Grabar_Materia(pensum.value,nivel.value,grado.value,tipo.value,desc.value,dct.value);
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
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function ModificarMateria(){
				abrir();
				pensum = document.getElementById('pensum');
				nivel = document.getElementById('nivel');
				grado = document.getElementById("grado");
				cod = document.getElementById("cod");
				desc = document.getElementById('desc');
				dct = document.getElementById('dct');
				tipo = document.getElementById("tipo");
				
				if(pensum.value !=="" && nivel.value !=="" && grado.value !=="" && desc.value !=="" && dct.value !=="" && tipo.value !==""){
					xajax_Modificar_Materia(pensum.value,nivel.value,grado.value,cod.value,tipo.value,desc.value,dct.value);
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
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Confirm_Elimina_Materia(pensum,nivel,grado,cod){
				abrir();
				msj = '<h5>Esta seguro de deshabilitar esta Materia con todos sus registros?</h5><br><br>';
				msj+= '<button type="button" class="btn btn-danger" onclick = "xajax_CambiaSit_Materia('+pensum+','+nivel+','+grado+','+cod+')" ><span class="fa fa-check"></span> Aceptar</button> ';
				msj+= '<button type="button" class="btn btn-info" onclick = "cerrar();" ><span class="fa fa-ban"></span> Cancelar</button> ';
				document.getElementById('lblparrafo').innerHTML = msj;
			}
			
			