//funciones javascript y validaciones
			function Set_Empresa(valor){
				suc = document.getElementById('suc');
				suc.value = valor;
			}
								
			function pageprint(){
				boton = document.getElementById("print");
				boton.className = "hidden";
				window.print();
				boton.className = "btn btn-default";
			}
			
			function Submit(){
				myform = document.forms.f1;
				myform.submit();
			}
						
			
		/////////////-- REPORTES--------------//////////////////
		
			function ReporteCierre(x){
				suc = document.getElementById("suc");
				
				if(suc.value !==""){
					myform = document.forms.f1;
					if(x == 1) {
						myform.action ="REPcierre.php";	
					}else if(x == 2) {
						myform.action ="EXCELcierre.php";	
					}
					myform.submit();
				}else{
					if(suc.value ===""){
						suc.className = "form-danger";
					}else{
						suc.className = "form-control";
					}
					abrir();
					msj = '<h5>Seleccione la Empresa donde realiza la acci&oacute;n...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
				