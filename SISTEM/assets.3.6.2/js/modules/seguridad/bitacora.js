//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "&iquest;Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
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
						
			function Buscar(){
				suc = document.getElementById('suc');
				usu = document.getElementById('usu');
				modu = document.getElementById('mod');
				acc = document.getElementById('acc');
				fini = document.getElementById('fini');
				ffin = document.getElementById('ffin');
				abrir();
				if(suc.value !=="" || usu.value !=="" || modu.value !== "" || acc.value !== ""  || (fini.value !== ""  && ffin.value !== "")){
					Submit();
					cerrar();
				}else{
					if(suc.value ===""){
						suc.className = " form-info";
						suc;
					}else{
						suc.className = " form-control";
						suc;
					}
					if(usu.value ===""){
						usu.className = " form-info";
						usu;
					}else{
						usu.className = " form-control";
						usu;
					}
					if(modu.value ===""){
						modu.className = " form-info";
						modu;
					}else{
						modu.className = " form-control";
						modu;
					}
					if(acc.value ===""){
						acc.className = " form-info";
						acc;
					}else{
						acc.className = " form-control";
						acc;
					}
					if(fini.value ===""){
						fini.className = " form-info";
						fini;
					}else{
						fini.className = " form-control";
						fini;
					}
					if(ffin.value ===""){
						ffin.className = " form-info";
						ffin;
					}else{
						ffin.className = " form-control";
						ffin;
					}
					msj = '<h5>Determinar almenos un criterio de busqueda (Usuario, Direci\u00F3n, M\u00F3dulo, Acci\u00F3n o Periodo de Fechas)</h5><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}
			}
									