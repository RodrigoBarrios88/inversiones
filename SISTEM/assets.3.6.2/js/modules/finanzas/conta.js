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
								
		///////////////// PARTIDAS /////////////////////						
			function Grabar(){
				cod = document.getElementById('cod');
				nom = document.getElementById('nom');
				tipo = document.getElementById("tipo");
				clase = document.getElementById("clase");
				//--
				if(nom.value !=="" && tipo.value !== "" && clase.value !== ""){
					abrir();
					xajax_Grabar_Partida(cod.value,nom.value,tipo.value,clase.value);
				}else{
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					if(clase.value ===""){
						clase.className = "form-danger";
					}else{
						clase.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}
		
			function Deshabilita_Partida(codigo){
				swal({
					text: "\u00BFEsta seguro de deshabilitar esta Partida?, No podra ser usada con esta situaci\u00F3n...",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							abrir();
							xajax_Situacion_Partida(codigo,0);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
			function Habilita_Partida(codigo){
				swal({
					text: "\u00BFEsta seguro de habilitar esta Partida?",
					icon: "info",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							abrir();
							xajax_Situacion_Partida(codigo,1);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}

		
		///////////////// CLASIFICACION /////////////////////						
			function GrabarClase(){
				cod = document.getElementById('cod');
				nom = document.getElementById('nom');
				tipo = document.getElementById("tipo");
				//--
				if(nom.value !=="" && tipo.value !== ""){
					abrir();
					xajax_Grabar_Clase(cod.value,nom.value,tipo.value);
				}else{
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}
		
			function Deshabilita_Clase(codigo){
				swal({
					text: "\u00BFEsta seguro de deshabilitar esta Clasificaci\u00F3n de Partida?, No podra ser usada con esta situaci\u00F3n...",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							abrir();
							xajax_Situacion_Clase(codigo,0);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
			function Habilita_Clase(codigo){
				swal({
					text: "\u00BFEsta seguro de habilitar esta Clasificaci\u00F3n de Partida?",
					icon: "info",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							abrir();
							xajax_Situacion_Clase(codigo,1);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
			
		///////////////// REGLONES /////////////////////							
			function GrabarReglon(){
				cod = document.getElementById('cod');
				dct = document.getElementById('dct');
				dlg = document.getElementById('dlg');
				tipo = document.getElementById("tipo");
				par = document.getElementById("par");
				//--		   
				if(dct.value !=="" && dlg.value !=="" && tipo.value !== "" && par.value !== ""){
					abrir();
					xajax_Grabar_Reglon(cod.value,par.value,dct.value,dlg.value);
				}else{
					if(dct.value ===""){
						dct.className = "form-danger";
					}else{
						dct.className = "form-control";
					}
					if(dlg.value ===""){
						dlg.className = "form-danger";
					}else{
						dlg.className = "form-control";
					}
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					if(par.value ===""){
						par.className = "form-danger";
					}else{
						par.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}			
			
			function Deshabilita_Reglon(cod,par){
				swal({
					text: "\u00BFEsta seguro de deshabilitar este Regl\u00F3n?, No podra ser usada con esta situaci\u00F3n...",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							xajax_Situacion_Reglon(cod,par,0);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
			function Habilita_Reglon(cod,par){
				swal({
					text: "\u00BFEsta seguro de habilitar este Regl\u00F3n?",
					icon: "info",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							xajax_Situacion_Reglon(cod,par,1);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
		///////////////// SUB-REGLONES /////////////////////							
			function GrabarSubreglon(){
				cod = document.getElementById('cod');
				reglon = document.getElementById('reglon');
				desc = document.getElementById('desc');
				tipo = document.getElementById("tipo");
				par = document.getElementById("par");
				//--		   
				if(reglon.value !=="" && desc.value !=="" && tipo.value !== "" && par.value !== ""){
					abrir();
					xajax_Grabar_Subreglon(cod.value,par.value,reglon.value,desc.value);
				}else{
					if(reglon.value ===""){
						reglon.className = "form-danger";
					}else{
						reglon.className = "form-control";
					}
					if(desc.value ===""){
						desc.className = "form-danger";
					}else{
						desc.className = "form-control";
					}
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					if(par.value ===""){
						par.className = "form-danger";
					}else{
						par.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}			
			
			function Deshabilita_Subreglon(cod,par,reglon){
				swal({
					text: "\u00BFEsta seguro de deshabilitar este Subregl\u00F3n?, No podra ser usada con esta situaci\u00F3n...",
					icon: "warning",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							abrir();
							xajax_Situacion_Subreglon(cod,par,reglon,0);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			
			function Habilita_Subreglon(cod,par,reglon){
				swal({
					text: "\u00BFEsta seguro de habilitar este Subregl\u00F3n?, No podra ser usada con esta situaci\u00F3n...",
					icon: "info",
					buttons: {
						cancel: "Cancelar",
						ok: { text: "Aceptar", value: true,},
					}
				}).then((value) => {
					switch (value) {
						case true:
							abrir();
							xajax_Situacion_Subreglon(cod,par,reglon,1);
							break;
						default:
						  swal("", "Acci\u00F3n Cancelada...", "info");
					}
				});
			}
			