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
						
	function GrabarTipo(){
		cod = document.getElementById('cod');
		desc = document.getElementById('desc');
		obs = document.getElementById("obs");
		
		if(desc.value !=="" && obs.value !== ""){
			abrir();
			xajax_Grabar_Tipo_Nomina(desc.value,obs.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(obs.value ===""){
				obs.className = "form-danger";
			}else{
				obs.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	function ModificarTipo(){
		cod = document.getElementById('cod');
		desc = document.getElementById('desc');
		obs = document.getElementById("obs");
		
		if(cod.value !== "" && desc.value !=="" && obs.value !== ""){
			abrir();
			xajax_Modificar_Tipo_Nomina(cod.value,desc.value,obs.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(obs.value ===""){
				obs.className = "form-danger";
			}else{
				obs.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	

	function Deshabilita_Tipo_Nomina(codigo){
		swal({
			text: "\u00BFEsta seguro de inhabilitar este Tipo de Nomina?, No podr\u00E1 ser listado con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Tipo_Nomina(codigo,0);
					break;
				default:
				  return;
			}
		});
	}
	
	
//////////////////////// NOMINA ////////////////////////////////////////

	function GrabarNomina(){
		tipo = document.getElementById('tipo');
		clase = document.getElementById('clase');
		titulo = document.getElementById('titulo');
		desde = document.getElementById('desde');
		hasta = document.getElementById('hasta');
		periodo = document.getElementById('periodo');
		obs = document.getElementById("obs");
		
		if(tipo.value !=="" && clase.value !== "" && titulo.value !== "" && desde.value !== "" && hasta.value !== "" && periodo.value !== ""){
			abrir();
			xajax_Grabar_Nomina(tipo.value,clase.value,titulo.value,desde.value,hasta.value,periodo.value,obs.value);
		}else{
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
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(desde.value ===""){
				desde.className = "form-danger";
			}else{
				desde.className = "form-control";
			}
			if(hasta.value ===""){
				hasta.className = "form-danger";
			}else{
				hasta.className = "form-control";
			}
			if(periodo.value ===""){
				periodo.className = "form-danger";
			}else{
				periodo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarNomina(){
		cod = document.getElementById('cod');
		tipo = document.getElementById('tipo');
		clase = document.getElementById('clase');
		titulo = document.getElementById('titulo');
		desde = document.getElementById('desde');
		hasta = document.getElementById('hasta');
		periodo = document.getElementById('periodo');
		obs = document.getElementById("obs");
		
		if(tipo.value !=="" && clase.value !== "" && titulo.value !== "" && desde.value !== "" && hasta.value !== "" && periodo.value !== ""){
			abrir();
			xajax_Modificar_Nomina(cod.value,tipo.value,clase.value,titulo.value,desde.value,hasta.value,periodo.value,obs.value);
		}else{
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
			if(titulo.value ===""){
				titulo.className = "form-danger";
			}else{
				titulo.className = "form-control";
			}
			if(desde.value ===""){
				desde.className = "form-danger";
			}else{
				desde.className = "form-control";
			}
			if(hasta.value ===""){
				hasta.className = "form-danger";
			}else{
				hasta.className = "form-control";
			}
			if(periodo.value ===""){
				periodo.className = "form-danger";
			}else{
				periodo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
//////////////////////// ASIGNACION PERSONAL - TIPO NOMINA ////////////////////////////////////////		
	
	function Asigna_Personal_Tipo(){
		filas =  document.getElementById("xasignarrows").value;
		//--
		tipo = document.getElementById('tipo');
		if(filas > 0) {
			if(tipo.value) {
				arrdpi = new Array([]);
				var cuantos = 0;
				for(i = 1; i <= filas; i++){
					chk = document.getElementById("xasignar"+i);
					if(chk.checked) {
						arrdpi[cuantos] = chk.value;
						cuantos++;
					}
				}
				if(cuantos > 0) {
					abrir();
					//alert(maestro.value+","+area.value);
					xajax_Graba_Personal_Tipo_Nomina(tipo.value,arrdpi,cuantos);
				}else{
					swal("Ups!", "Debe seleccionar almenos una (01) Persona...", "warning");
				}
			}else{
				swal("Ups!", "Debe Seleccionar el Tipo de Nomina donde estas personas se van a listar...", "warning");
			}	
		}else{
			swal("Ups!", "Debe seleccionar almenos una (01) Persona...", "info");
		}
	}
	
	
	
	function Quitar_Personal_Tipo(){
		filas =  document.getElementById("asignadosrows").value;
		tipo = document.getElementById('tipo');
		
		if(filas > 0) {
			if(tipo.value) {
				arrdpi = new Array([]);
				var cuantos = 0;
				for(i = 1; i <= filas; i++){
					chk = document.getElementById("asignados"+i);
					if(chk.checked) {
						arrdpi[cuantos] = chk.value;
						cuantos++;
					}
				}
				if(cuantos > 0) {
					abrir();
					xajax_Quitar_Personal_Tipo_Nomina(tipo.value,arrdpi,cuantos);
				}else{
					swal("Ups!", "Debe seleccionar almenos una (01) Persona...", "warning");
				}
			}else{
				swal("Ups!", "Debe Seleccionar el Tipo de Nomina donde estas personas se van a listar...", "warning");
			}	
		}else{
			swal("Ups!", "Debe seleccionar almenos una (01) Persona...", "info");
		}
	}
	
	function Desasignar_Materia_Seccion_Tipo_Nomina(pensum,nivel,grado,seccion,materia,maestro){
		swal({
			text: "\u00BFEsta seguro de desasignar al maestro de esta secci\u00F3n?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Delete_Materia_Seccion_Tipo_Nomina(pensum,nivel,grado,seccion,materia,maestro);
					break;
				default:
				  return;
			}
		});
	}
	
	
///////////////// CONFIGURACION DE HORAS ////////////////////	
	function GrabarHoras(){
		dpi = document.getElementById('dpi');
		cantreg = document.getElementById('cantreg');
		montoreg = document.getElementById('montoreg');
		cantext = document.getElementById('cantext');
		montoext = document.getElementById('montoext');
		mon = document.getElementById("moneda");
		
		if(cantreg.value !=="" && montoreg.value !== "" && mon.value !== "" && montoext.value !== ""){
			abrir();
			xajax_Grabar_Configuracion_Horas(dpi.value,cantreg.value,montoreg.value,cantext.value,montoext.value,mon.value);
		}else{
			if(cantreg.value ===""){
				cantreg.className = "form-danger";
			}else{
				cantreg.className = "form-control";
			}
			if(montoreg.value ===""){
				montoreg.className = "form-danger";
			}else{
				montoreg.className = "form-control";
			}
			if(montoext.value ===""){
				montoext.className = "form-danger";
			}else{
				montoext.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	

///////////////// Horas ////////////////////
	function GrabaHorasLaboradas(nomina,fila){
		fila = parseInt(fila);
		if(fila > 0){
			cui = document.getElementById('personal'+fila);
			phoras = document.getElementById('phoras'+fila);
			horas = document.getElementById('horas'+fila);
			pextras = document.getElementById('pextras'+fila);
			extras = document.getElementById('extras'+fila);
			moneda = document.getElementById('moneda'+fila);
			tcambio = document.getElementById('tcambio'+fila);
			if(horas.value !=="" && extras.value !==""){
				xajax_Graba_Horas_Laboradas(nomina,cui.value,horas.value,phoras.value,extras.value,pextras.value,moneda.value,tcambio.value);
			}
		}
	}
	
	
	function QuitarHorasLaboradas(nomina,fila){
		fila = parseInt(fila);
		if(fila > 0){
			cui = document.getElementById('personal'+fila).value;
			xajax_Quitar_Horas_Laboradas(nomina,cui);
		}
	}
	

///////////////// CONFIGURACION DE BONOS REGULARES ////////////////////	
	function GrabarBono(){
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Grabar_Bono_Regular(dpi.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarBono(){
		cod = document.getElementById('cod');
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Modificar_Bono_Regular(cod.value,dpi.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Bono(codigo,cui){
		swal({
			text: "\u00BFEsta seguro de inhabilitar esta bonificaci\u00F3n?, No podr\u00E1 ser asignada con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Bono_Regular(codigo,cui);
					break;
				default:
				  return;
			}
		});
	}
	
	
///////////////// CONFIGURACION DE DESCUENTOS REGULARES ////////////////////	
	function GrabarDescuento(){
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Grabar_Descuento_Regular(dpi.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarDescuento(){
		cod = document.getElementById('cod');
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Modificar_Descuento_Regular(cod.value,dpi.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Descuento_Regular(codigo,cui){
		swal({
			text: "\u00BFEsta seguro de inhabilitar esta bonificaci\u00F3n?, No podr\u00E1 ser asignada con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Descuento_Regular(codigo,cui);
					break;
				default:
				  return;
			}
		});
	}
	
	
///////////////// BONOS EMERGENTES ////////////////////	
	function GrabarBonoEmergente(){
		nomina = document.getElementById('nomina');
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Grabar_Bono_Emergente(nomina.value,dpi.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarBonoEmergente(){
		cod = document.getElementById('cod');
		nomina = document.getElementById('nomina');
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Modificar_Bono_Emergente(nomina.value,dpi.value,cod.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Bono_Emergente(nomina,cui,codigo){
		swal({
			text: "\u00BFEsta seguro de inhabilitar esta bonificaci\u00F3n?, No podr\u00E1 ser asignada con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Bono_Emergente(nomina,cui,codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	///////////////// COMISIONES ////////////////////	
	function GrabarComision(){
		nomina = document.getElementById('nomina');
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Grabar_Comision(nomina.value,dpi.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarComision(){
		cod = document.getElementById('cod');
		nomina = document.getElementById('nomina');
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Modificar_Comision(nomina.value,dpi.value,cod.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Comision(nomina,cui,codigo){
		swal({
			text: "\u00BFEsta seguro de inhabilitar esta comici\u00F3n?, No podr\u00E1 ser asignada con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Comision(nomina,cui,codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
///////////////// DESCUENTOS EMERGENTES ////////////////////	
	function GrabarDescuentoEmergente(){
		nomina = document.getElementById('nomina');
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Grabar_Descuento_Emergente(nomina.value,dpi.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ModificarDescuentoEmergente(){
		cod = document.getElementById('cod');
		nomina = document.getElementById('nomina');
		dpi = document.getElementById('dpi');
		monto = document.getElementById('monto');
		mon = document.getElementById("mon");
		tcambio = document.getElementById("tcambio");
		desc = document.getElementById("desc");
		
		if(desc.value !=="" && monto.value !== "" && mon.value !== "" && tcambio.value !== ""){
			abrir();
			xajax_Modificar_Descuento_Emergente(nomina.value,dpi.value,cod.value,monto.value,mon.value,tcambio.value,desc.value);
		}else{
			if(desc.value ===""){
				desc.className = "form-danger";
			}else{
				desc.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(mon.value ===""){
				mon.className = "form-danger";
			}else{
				mon.className = "form-control";
			}
			if(tcambio.value ===""){
				tcambio.className = "form-danger";
			}else{
				tcambio.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Deshabilita_Descuento(nomina,cui,codigo){
		swal({
			text: "\u00BFEsta seguro de inhabilitar este descuento?, No podr\u00E1 ser asignada con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Descuento_Emergente(nomina,cui,codigo);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Situacion_Revision(nomina){
		swal({
			text: "\u00BFEsta seguro de solicitar revisi\u00F3n de esta nomina?, No podr\u00E1 editar ning\u00F3n dato con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Nomina(nomina,2);
					break;
				default:
				  return;
			}
		});
	}
	
	function Situacion_Regresar(nomina){
		swal({
			text: "\u00BFEsta seguro de regresar de esta nomina \u00F3 solicitar modificaciones?",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Nomina(nomina,1);
					break;
				default:
				  return;
			}
		});
	}
	
	function Situacion_Aprobacion(nomina){
		swal({
			text: "\u00BFEsta seguro de aprobar de esta nomina? No podr\u00E1 ser regresada a edici\u00F3n, ni rechazarla con esta situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Nomina(nomina,3);
					break;
				default:
				  return;
			}
		});
	}
	
	
	function Situacion_Pagar(nomina){
		swal({
			text: "\u00BFEsta seguro de cambiar la situaci\u00F3n esta nomina a pagada? No podr\u00E1 ser regresada a otra situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Nomina(nomina,4);
					break;
				default:
				  return;
			}
		});
	}
	
	function Situacion_Desechar(nomina){
		swal({
			text: "\u00BFEsta seguro de 'desechar' esta nomina? No podr\u00E1 ser regresada a otra situaci\u00F3n...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Situacion_Nomina(nomina,0);
					break;
				default:
				  return;
			}
		});
	}
	
///////////////////////////////////////// DATOS DE PLANILLA ///////////////////////////////////////////

	function ver_horas_laboradas(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/horas_laboradas.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ver_monto_horas_laboradas(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/monto_laboradas.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ver_bonificacion_horas_laboradas(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/bonificacion_laboradas.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ver_horas_extras(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/horas_extras.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ver_monto_horas_extras(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/monto_extras.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ver_bonificacion_horas_extras(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/bonificacion_extras.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function ver_bonificaciones(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/bonificaciones.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ver_comisiones(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/comisiones.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	function ver_descuentos(nomina,personal){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/planilla/descuentos.php",{nomina:nomina,personal:personal}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	
	
	