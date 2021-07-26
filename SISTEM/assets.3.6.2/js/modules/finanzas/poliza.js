//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "¿Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			
			function Submit(){
				myform = document.forms.f1;
				myform.submit();
			}
								
		///////////////// POLIZA /////////////////////						
			function Grabar(){
				suc = document.getElementById('suc');
				doc = document.getElementById('doc');
				fecha = document.getElementById("fecha");
				desc = document.getElementById("desc");
				//--
				if(doc.value !=="" && fecha.value !== "" && desc.value !== ""){
					abrir();
					xajax_Grabar_Poliza(suc.value,doc.value,fecha.value,desc.value);
				}else{
					if(doc.value ===""){
						doc.className = "form-danger";
					}else{
						doc.className = "form-control";
					}
					if(fecha.value ===""){
						fecha.className = "form-danger";
					}else{
						fecha.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}
			
			
			function Modificar(){
				cod = document.getElementById('cod');
				suc = document.getElementById('suc');
				doc = document.getElementById('doc');
				fecha = document.getElementById("fecha");
				desc = document.getElementById("desc");
				//--
				if(doc.value !=="" && fecha.value !== "" && desc.value !== ""){
					abrir();
					xajax_Modificar_Poliza(cod.value,suc.value,doc.value,fecha.value,desc.value);
				}else{
					if(doc.value ===""){
						doc.className = "form-danger";
					}else{
						doc.className = "form-control";
					}
					if(fecha.value ===""){
						fecha.className = "form-danger";
					}else{
						fecha.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}
		
			function Deshabilita_Poliza(codigo){
				swal({
					text: "\u00BFEsta seguro de eliminar esta Poliza?, No podra ser usada con esta nueva situaci\u00F3n...",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							xajax_Situacion_Poliza(codigo);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
			
			
		///////////////// DETALLE /////////////////////			
			function SubReglones(){
				tipo = document.getElementById('tipo');
				partida = document.getElementById('par');
				if(tipo.value !==""){
					//Realiza una peticion de contenido a la contenido.php
					$.post("../promts/conta/buscar_reglones.php",{tipo:tipo.value,par:partida.value}, function(data){
						// Ponemos la respuesta de nuestro script en el DIV recargado
						$("#Pcontainer").html(data);
					});
					abrirModal();
				}else{
					tipo.className = "form-warning";
					swal("Ohoo!", "Debe Seleccionar al menos el tipo de partida contable...", "warning");
				}
			}
			
			function SeleccionaSubreglon(par,reg,subreg){
				xajax_Buscar_Subreglon(subreg,par,reg);
			}
			
			function GrabarDetalle(){
				poliza = document.getElementById('poliza');
				tipo = document.getElementById('tipo');
				clase = document.getElementById("clase");
				partida = document.getElementById("par");
				reglon = document.getElementById("reglon");
				subreglon = document.getElementById("subreglon");
				motivo = document.getElementById("motivo");
				mov = document.getElementById("mov");
				moneda = document.getElementById("moneda");
				monto = document.getElementById("monto");
				//--
				descreglon = document.getElementById("descreglon");
				descsubreglon = document.getElementById("descsubreglon");
				if(poliza.value !=="" && tipo.value !== "" && partida.value !== "" && reglon.value !== "" && subreglon.value !== "" && motivo.value !== "" && mov.value !== "" && monto.value !== "" && moneda.value !== ""){
					abrir();
					// manejo del texto del combo moneda
						var montext = moneda.options[moneda.selectedIndex].text;
					//-- extrae el simbolo de la moneda y tipo de cambio
						monchunk = montext.split("/");
						var tcambio = monchunk[2]; // Tipo de Cambio
						tcambio = tcambio.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
						tcambio = tcambio.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
					//--
					xajax_Grabar_Detalle_Poliza(poliza.value,tipo.value,clase.value,partida.value,reglon.value,subreglon.value,motivo.value,mov.value,monto.value,moneda.value,tcambio);
				}else{
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					if(partida.value ===""){
						partida.className = "form-danger";
					}else{
						partida.className = "form-control";
					}
					if(reglon.value ===""){
						descreglon.className = "form-danger";
					}else{
						descreglon.className = "form-control";
					}
					if(subreglon.value ===""){
						descsubreglon.className = "form-danger";
					}else{
						descsubreglon.className = "form-control";
					}
					if(motivo.value ===""){
						motivo.className = "form-danger";
					}else{
						motivo.className = "form-control";
					}
					if(mov.value ===""){
						mov.className = "form-danger";
					}else{
						mov.className = "form-control";
					}
					if(monto.value ===""){
						monto.className = "form-danger";
					}else{
						monto.className = "form-control";
					}
					if(moneda.value ===""){
						moneda.className = "form-danger";
					}else{
						moneda.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}
			
			
			function Delete_Detalle(codigo,poliza){
				swal({
					text: "\u00BFEsta seguro de eliminar este registro del detalle de poliza?",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							xajax_Delete_Poliza(codigo,poliza);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}