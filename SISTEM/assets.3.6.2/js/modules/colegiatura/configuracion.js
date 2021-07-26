//funciones javascript y validaciones
	function Limpiar(){
		swal({
			text: "\u00BFDesea Limpiar la p\u00E1gina?",
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
	
	function openBoleta(hashkey){
		window.open("../../CONFIG/BOLETAS/REPboleta.php?hashkey="+hashkey);
		window.location.reload();
	}
	
	function openBoletas(hashkey,grupo,division,periodo){
		window.open("../../CONFIG/BOLETAS/REPboletas.php?hashkey="+hashkey+"&grupo="+grupo+"&division="+division+"&periodo="+periodo);
		window.location.href="FRMprogramar.php?hashkey="+hashkey+"&periodo="+periodo;
	}
						
	function TablaConfiguracion(){
		grupo = document.getElementById("grupo");
		division = document.getElementById("division");
		monto = document.getElementById("monto");
		motivo = document.getElementById("motivo");
		periodo = document.getElementById("periodo");
		mes = document.getElementById("mes");
		dia = document.getElementById("dia");
		tipo = document.getElementById("tipo");
		cant = document.getElementById("cant");
		save = document.getElementById("save");
		
		if(grupo.value !=="" && division.value !=="" && monto.value !=="" && motivo.value !=="" && periodo.value !=="" && mes.value !=="" && dia.value !=="" && tipo.value !=="" && cant.value !==""){
			abrir();
			save.value = 1;
			Submit();
			btngrabar = document.getElementById("btngrabar");
			btngrabar.className = "btn btn-primary";
		}else{
			if(grupo.value ===""){
				grupo.className = "form-danger";
			}else{
				grupo.className = "form-control";
			}
			if(division.value ===""){
				division.className = "form-danger";
			}else{
				division.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(motivo.value ===""){
				motivo.className = "form-danger";
			}else{
				motivo.className = "form-control";
			}
			if(periodo.value ===""){
				periodo.className = "form-danger";
			}else{
				periodo.className = "form-control";
			}
			if(mes.value ===""){
				mes.className = "form-danger";
			}else{
				mes.className = "form-control";
			}
			if(dia.value ===""){
				dia.className = "form-danger";
			}else{
				dia.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(cant.value ===""){
				cant.className = "form-danger";
			}else{
				cant.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			btngrabar = document.getElementById("btngrabar");
			btngrabar.className = "btn btn-primary hidden";
			save.value = 0;
		}
	}
	
	
	
	function QuitarFilaConfig(fila){
		cant = document.getElementById("cant");
		vueltas = parseInt(cant.value);
		
		if(vueltas > 1){
			abrir();
			//--
			arrmonto = new Array([]);
			arrmotivo = new Array([]);
			arrperiodo = new Array([]);
			arrmes = new Array([]);
			arrdia = new Array([]);
			
			var C = 1;
			for(var i = 1; i <= vueltas; i++){
				if(i !== fila){
					arrmonto[C] = document.getElementById("monto"+i).value;
					arrmotivo[C] = document.getElementById("motivo"+i).value;
					arrperiodo[C] = document.getElementById("periodo"+i).value;
					arrmes[C] = document.getElementById("mes"+i).value;
					arrdia[C] = document.getElementById("dia"+i).value;
					C++;
				}
			}
			C--;
			//alert(arrmes);
			xajax_Quita_Fila_Config(arrmonto,arrmotivo,arrperiodo,arrmes,arrdia,C);
		}else{
			cerrar();
		}
		
	}
	
	
	function ConfirmGrabarConfiguracion(fila){
		swal({
			text: "\u00BFEsta seguro de Grabar esta Configuraci\u00F3n?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					GrabarConfiguracion();
					break;
				default:
				  return;
			}
		});
	}
	
	
	
	function GrabarConfiguracion(){
		grupo = document.getElementById("grupo");
		division = document.getElementById("division");
		tipo = document.getElementById("tipo");
		pensum = document.getElementById("pensum");
		nivel = document.getElementById("nivel");
		grado = document.getElementById("grado");
		//--
		cant = document.getElementById("cant");
		vueltas = parseInt(cant.value);
		
		
		if(grupo.value !=="" && division.value !=="" && tipo.value !=="" && pensum.value !=="" && nivel.value !=="" && cant.value !=="" ){
			if(vueltas >= 1){
				abrir();
				//--
				arrmonto = new Array([]);
				arrmotivo = new Array([]);
				arrperiodo = new Array([]);
				arrmes = new Array([]);
				arrdia = new Array([]);
				arranio = new Array([]);
				
				for(var i = 1; i <= vueltas; i++){
					arrmonto[i] = document.getElementById("monto"+i).value;
					arrmotivo[i] = document.getElementById("motivo"+i).value;
					arrperiodo[i] = document.getElementById("periodo"+i).value;
					arrmes[i] = document.getElementById("mes"+i).value;
					arrdia[i] = document.getElementById("dia"+i).value;
					arranio[i] = document.getElementById("anio"+i).value;
				}
			    //alert(arrmes);
				//alert(arranio);
				xajax_Grabar_Configuracion(grupo.value,division.value,tipo.value,pensum.value,nivel.value,grado.value,arrmonto,arrmotivo,arrperiodo,arrmes,arrdia,arranio,vueltas);
			}else{
				swal("Alto!", "No hay filas para grabar", "info");
				btngrabar = document.getElementById("btngrabar");
				btngrabar.className = "btn btn-primary hidden";
				save.value = 0;
			}
		}else{
			if(grupo.value ===""){
				grupo.className = "form-danger";
			}else{
				grupo.className = "form-control";
			}
			if(division.value ===""){
				division.className = "form-danger";
			}else{
				division.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			if(cant.value ===""){
				cant.className = "form-danger";
			}else{
				cant.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			btngrabar = document.getElementById("btngrabar");
			btngrabar.className = "btn btn-primary hidden";
			save.value = 0;
		}
		
	}
	
	
	function ModificarConfiguracion(){
		codigo = document.getElementById("codigo");
		grupo = document.getElementById("grupo");
		division = document.getElementById("division");
		monto = document.getElementById("monto");
		motivo = document.getElementById("motivo");
		periodo = document.getElementById("periodo");
		mes = document.getElementById("mes");
		dia = document.getElementById("dia");
		tipo = document.getElementById("tipo");
		pensum = document.getElementById("pensum");
		nivel = document.getElementById("nivel");
		grado = document.getElementById("grado");
		
		if(grupo.value !=="" && division.value !=="" && monto.value !=="" && motivo.value !=="" && mes.value !=="" && dia.value !=="" && tipo.value !=="" && pensum.value !=="" && nivel.value !==""){
			abrir();
			xajax_Modificar_Configuracion(codigo.value,grupo.value,division.value,tipo.value,pensum.value,nivel.value,grado.value,monto.value,motivo.value,periodo.value,mes.value,dia.value);
		}else{
			if(grupo.value ===""){
				grupo.className = "form-danger";
			}else{
				grupo.className = "form-control";
			}
			if(division.value ===""){
				division.className = "form-danger";
			}else{
				division.className = "form-control";
			}
			if(monto.value ===""){
				monto.className = "form-danger";
			}else{
				monto.className = "form-control";
			}
			if(motivo.value ===""){
				motivo.className = "form-danger";
			}else{
				motivo.className = "form-control";
			}
			if(periodo.value ===""){
				periodo.className = "form-danger";
			}else{
				periodo.className = "form-control";
			}
			if(mes.value ===""){
				mes.className = "form-danger";
			}else{
				mes.className = "form-control";
			}
			if(dia.value ===""){
				dia.className = "form-danger";
			}else{
				dia.className = "form-control";
			}
			if(tipo.value ===""){
				tipo.className = "form-danger";
			}else{
				tipo.className = "form-control";
			}
			if(nivel.value ===""){
				nivel.className = "form-danger";
			}else{
				nivel.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function ConfirmEliminarConfiguracion(codigo){
		swal({
			text: "\u00BFEsta seguro de Eliminar este registro de Configuraci\u00F3n?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Eliminar_Configuracion(codigo);
					break;
				default:
				  return;
			}
		});
	}
	
//////////////// BOLETAS DE COBRO //////////////////////


function TablaBoletas(){
		grupo = document.getElementById("grupo");
		boleta = document.getElementById("boleta");
		save = document.getElementById("save");
		
		if(grupo.value !==""){
			abrir();
			save.value = 1;
			Submit();
			btngrabar = document.getElementById("btngrabar");
			btngrabar.className = "btn btn-primary";
		}else{
			if(grupo.value ===""){
				grupo.className = "form-danger";
			}else{
				grupo.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
			btngrabar = document.getElementById("btngrabar");
			btngrabar.className = "btn btn-primary hidden";
			save.value = 0;
		}
	}
	
	
	function ConfirmProgramarBoletas(){
		swal({
			text: "\u00BFEsta seguro de Grabar esta Configuraci\u00F3n?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					ProgramarBoletas();
					break;
				default:
				  return;
			}
		});
	}
	
	
	
	function ProgramarBoletas(){
		periodo = document.getElementById("periodo");
		filas = document.getElementById("filas");
		vueltas = parseInt(filas.value);
		
		if(vueltas >= 1){
			abrir();
			//--
			arrdivision = new Array([]);
			arrgrupo = new Array([]);
			arralumno = new Array([]);
			arrcodalumno = new Array([]);
			arrmonto = new Array([]);
			arrdesc= new Array([]);
			arrmotdesc = new Array([]);
			arrmotivo = new Array([]);
			arrfecha = new Array([]);
				
			for(var i = 1; i <= vueltas; i++){
				arrdivision[i] = document.getElementById("division"+i).value;
				arrgrupo[i] = document.getElementById("grupo"+i).value;
				arralumno[i] = document.getElementById("cui").value;
				arrcodalumno[i] = document.getElementById("codint").value;
				arrmonto[i] = document.getElementById("monto"+i).value;
				arrdesc[i] = document.getElementById("desc"+i).value;
				arrmotdesc[i] = document.getElementById("motdesc"+i).value;
				arrmotivo[i] = document.getElementById("motivo"+i).value;
				arrfecha[i] = document.getElementById("fecha"+i).value;
			}
			//alert(arrmes);
			xajax_Programar_Boletas_Cobro(arrdivision,arrgrupo,arralumno,arrcodalumno,arrmonto,arrdesc,arrmotdesc,arrmotivo,arrfecha,periodo.value,vueltas);
		}else{
			swal("Alto!", "No hay filas para grabar...", "warning");
			btngrabar = document.getElementById("btngrabar");
			btngrabar.className = "btn btn-primary hidden";
			save.value = 0;
		}
	}