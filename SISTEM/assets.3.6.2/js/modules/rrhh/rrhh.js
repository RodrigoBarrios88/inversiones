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
						
	function pageprint(){
		boton = document.getElementById("print");
		boton.className = "hidden";
		window.print();
		boton.className = "btn btn-default";
	}
	
	function Filas_Armamento() {
		filas = document.getElementById("cantarmas").value;
		if (filas !== "") {
			xajax_Grid_Filas_Armamento(filas);
		}
	}
	
	function Filas_Vehiculos() {
		filas = document.getElementById("cantvehiculos").value;
		if (filas !== "") {
			xajax_Grid_Filas_Vehiculos(filas);
		}
	}
	
	function Filas_Hijos(){
		filas = document.getElementById("canthijos").value;
		//Realiza una peticion de contenido a la contenido.php
		$.post("FILAShijos.php",{filas:filas}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#HijosContainer").html(data);
		});
		//abrirModal();
	}
	

	function Filas_Hermanos(){
		filas = document.getElementById("canthermanos").value;
		//Realiza una peticion de contenido a la contenido.php
		$.post("FILAShermanos.php",{filas:filas}, function(data){
		// Ponemos la respuesta de nuestro script en el DIV recargado
		$("#HermanosContainer").html(data);
		});
		//abrirModal();
	}
	
	function Filas_Faminst() {
		filas = document.getElementById("cantfaminst").value;
		if (filas !== "") {
			xajax_Grid_Filas_Faminst(filas);
		}
	}
	
	function Filas_Refsocial() {
		filas = document.getElementById("cantrefsocial").value;
		if (filas !== "") {
			xajax_Grid_Filas_Refsocial(filas);
		}
	}
	
	function Filas_Titulos() {
		filas = document.getElementById("canttitulos").value;
		if (filas !== "") {
			xajax_Grid_Filas_Titulos(filas);
		}
	}
	
	function Filas_Idiomas() {
		filas = document.getElementById("cantidiomas").value;
		if (filas !== "") {
			xajax_Grid_Filas_Idiomas(filas);
		}
	}
	
	function Filas_Otros_Cursos() {
		filas = document.getElementById("cantotroscursos").value;
		if (filas !== "") {
			xajax_Grid_Filas_Otros_Cursos(filas);
		}
	}
	
	
	function trasladar_datos_emergenia(tipo) {
		if (tipo != 1) {
			nom = document.getElementById("famnombre"+tipo).value;
			ape = document.getElementById("famapellido"+tipo).value;
			dir = document.getElementById("famdirec"+tipo).value;
			tel = document.getElementById("famtel"+tipo).value;
			cel = document.getElementById("famcel"+tipo).value;
			
			document.getElementById("emernombre").value = nom;
			document.getElementById("emerapellido").value = ape;
			document.getElementById("emerdirec").value = dir;
			document.getElementById("emertel").value = tel;
			document.getElementById("emercel").value = cel;
			//--
		}else{
			document.getElementById("emernombre").value = '';
			document.getElementById("emerapellido").value = '';
			document.getElementById("emerdirec").value = '';
			document.getElementById("emertel").value = '';
			document.getElementById("emercel").value = '';
			//--
		}
	}
	
	
	function Grabar(){
		//alert("entro...");
		//personal
		nom = document.getElementById("nom");
		ape = document.getElementById("ape");
		profesion = document.getElementById("profesion");
		religion = document.getElementById("religion");
		genero = document.getElementById("genero");
		ecivil = document.getElementById("ecivil");
		fecnac = document.getElementById("fecnac");
		edad = document.getElementById("edad"); //eliminar en cadena xajax
		depn = document.getElementById("depn");
		paisn = document.getElementById("paisn");
		dir1 = document.getElementById("dir1");
		tel1 = document.getElementById("tel1");
		depdp = document.getElementById("depdp");//eliminar en cadena xajax
		mundp = document.getElementById("mundp");
		dir2 = document.getElementById("dir2");
		tel2 = document.getElementById("tel2");
		depde = document.getElementById("depde");//eliminar en cadena xajax
		munde = document.getElementById("munde");
		sangre = document.getElementById("sangre");
		alergia = document.getElementById("alergia");
		cel = document.getElementById("cel");
		email = document.getElementById("email");
		//documentos
		dpi = document.getElementById("dpi");
		nit = document.getElementById("nit");
		pasa = document.getElementById("pasa");
		igss = document.getElementById("igss");
		tlicv = document.getElementById("tlicv");
		nlicv = document.getElementById("nlicv");
		nlicm = document.getElementById("nlicm");
		cantvehiculos = document.getElementById("cantvehiculos"); ///--- cantidad ---///
		/*licportacion = document.getElementById("licportacion");
		cantarmas = document.getElementById("cantarmas"); ///--- cantidad ---///
		feciniarma = document.getElementById("feciniarma");//fecha falsa
		fecfinarma = document.getElementById("fecfinarma");//fecha falsa*/
		//educacion
		primaria = document.getElementById("primaria");
		lugprimaria = document.getElementById("lugprimaria");
		secundaria = document.getElementById("secundaria");
		secuncarrera = document.getElementById("secuncarrera");
		lugsecundaria = document.getElementById("lugsecundaria");
		canttitulos = document.getElementById("canttitulos"); ///--- cantidad ---///
		cantidiomas = document.getElementById("cantidiomas"); ///--- cantidad ---///
		cantotroscursos = document.getElementById("cantotroscursos"); ///--- cantidad ---///
		//faminstia
		famnombre2 = document.getElementById("famnombre2");
		famapellido2 = document.getElementById("famapellido2");
		fampais2 = document.getElementById("fampais2");
		famreligion2 = document.getElementById("famreligion2");
		famdirec2 = document.getElementById("famdirec2");
		famtel2 = document.getElementById("famtel2");
		famcel2 = document.getElementById("famcel2");
		famprofe2 = document.getElementById("famprofe2");
		padrefecnac = document.getElementById("padrefecnac");
		padreedad = document.getElementById("padreedad");//eliminar en cadena xajax
		famnombre3 = document.getElementById("famnombre3");
		famapellido3 = document.getElementById("famapellido3");
		fampais3 = document.getElementById("fampais3");
		famreligion3 = document.getElementById("famreligion3");
		famdirec3 = document.getElementById("famdirec3");
		famtel3 = document.getElementById("famtel3");
		famcel3 = document.getElementById("famcel3");
		famprofe3 = document.getElementById("famprofe3");
		madrefecnac = document.getElementById("madrefecnac");
		madreedad = document.getElementById("madreedad");//eliminar en cadena xajax
		famnombre4 = document.getElementById("famnombre4");
		famapellido4 = document.getElementById("famapellido4");
		fampais4 = document.getElementById("fampais4");
		famreligion4 = document.getElementById("famreligion4");
		famdirec4 = document.getElementById("famdirec4");
		famtel4 = document.getElementById("famtel4");
		famcel4 = document.getElementById("famcel4");
		famprofe4 = document.getElementById("famprofe4");
		esposafecnac = document.getElementById("esposafecnac");
		esposaedad = document.getElementById("esposaedad");//eliminar en cadena xajax
		canthijos = document.getElementById("canthijos"); ///--- cantidad ---///
		canthermanos = document.getElementById("canthermanos"); ///--- cantidad ---///
		emergencia = document.getElementById("emergencia");
		emerdirec = document.getElementById("emerdirec");
		emernombre = document.getElementById("emernombre");
		emerapellido = document.getElementById("emerapellido");
		emertel = document.getElementById("emertel");
		emercel = document.getElementById("emercel");
		cantfaminst = document.getElementById("cantfaminst"); ///--- cantidad ---///
		//social
		cantrefsocial = document.getElementById("cantrefsocial"); ///--- cantidad ---///
		deportes = document.getElementById("deportes");
		//economica
		empleadoconyugue = document.getElementById("empleadoconyugue");
		ingresosconyugue = document.getElementById("ingresosconyugue");
		trabajoconyugue = document.getElementById("trabajoconyugue");
		cargasfam = document.getElementById("cargasfam");
		casa = document.getElementById("casa");
		costocasa = document.getElementById("costocasa");
		cuentasbanco = document.getElementById("cuentasbanco");
		bancos = document.getElementById("bancos");
		tarjetascred = document.getElementById("tarjetascred");
		bancostarjeta = document.getElementById("bancostarjeta");
		otrosingresos = document.getElementById("otrosingresos");
		montootros = document.getElementById("montootros");
		sueldo = document.getElementById("sueldo");
		descuentos = document.getElementById("descuentos");
		prestamos = document.getElementById("prestamos");
		saldo = document.getElementById("saldo");
		//penal
		detenido = document.getElementById("detenido");
		motivodetenido = document.getElementById("motivodetenido");
		dondedetenido = document.getElementById("dondedetenido");
		cuandodetenido = document.getElementById("cuandodetenido");
		porquedetenido = document.getElementById("porquedetenido");
		feclibertad = document.getElementById("feclibertad");
		arraigado = document.getElementById("arraigado");
		motivoarraigado = document.getElementById("motivoarraigado");
		dondearraigo = document.getElementById("dondearraigo");
		cuandoarraigo = document.getElementById("cuandoarraigo");
		//fecpenales = document.getElementById("fecpenales");
		//fecpoliciacos = document.getElementById("fecpoliciacos");
		//laboral anterior
		ultimoempleo = document.getElementById("ultimoempleo");
		telultimoempleo = document.getElementById("telultimoempleo");
		dirultimoempleo = document.getElementById("dirultimoempleo");
		pueultimoempleo = document.getElementById("pueultimoempleo");
		empultimoempleo = document.getElementById("empultimoempleo");
		sueldoultimoempleo = document.getElementById("sueldoultimoempleo");
		fecultimoempleo = document.getElementById("fecultimoempleo");
		//somatometrica
		tcamisa = document.getElementById("tcamisa");
		tpantalon = document.getElementById("tpantalon");
		tchumpa = document.getElementById("tchumpa");
		tbotas = document.getElementById("tbotas");
		tgorra = document.getElementById("tgorra");
		estatura = document.getElementById("estatura");
		peso = document.getElementById("peso");
		tez = document.getElementById("tez");
		ojos = document.getElementById("ojos");
		nariz = document.getElementById("nariz");
		//--
		
		if(dpi.value !== "" && nom.value !== "" && ape.value !== "" &&
			profesion.value !== "" && religion.value !== "" && genero.value !== "" && ecivil.value !== "" && fecnac.value !== "" && edad.value !== "" && depn.value !== "" &&
			paisn.value !== "" && dir1.value !== "" && tel1.value !== "" && depdp.value !== "" && mundp.value !== "" && dir2.value !== "" && tel2.value !== "" && depde.value !== "" &&
			munde.value !== "" && sangre.value !== "" && cel.value !== "" && email.value !== "" && cantvehiculos.value !== "" &&
			primaria.value !== "" && lugprimaria.value !== "" && canttitulos.value !== "" && cantidiomas.value !== "" && cantotroscursos.value !== "" &&
			canthijos.value !== "" && canthermanos.value !== "" && emergencia.value !== "" && emerdirec.value !== "" && emernombre.value !== "" && emerapellido.value !== "" &&
			cantfaminst.value !== "" && cantrefsocial.value !== "" && deportes.value !== "" && cargasfam.value !== "" && casa.value !== "" && costocasa.value !== "" &&
			cuentasbanco.value !== "" && tarjetascred.value !== "" && sueldo.value !== "" && descuentos.value !== "" && prestamos.value !== "" && detenido.value !== "" &&
			arraigado.value !== "" && tcamisa.value !== "" && tpantalon.value !== "" && tchumpa.value !== "" && tbotas.value !== "" && tgorra.value !== "" &&
			estatura.value !== "" && peso.value !== "" && tez.value !== "" && ojos.value !== "" && nariz.value !== ""){
			
			//// Vehiculos ////
			var arrtipoveh = new Array([]);
			var arrmarcaveh = new Array([]);
			var arrlineaveh = new Array([]);
			var arrmodeloveh = new Array([]);
			var arrtarjetaveh = new Array([]);
			var arrcolorveh = new Array([]);
			var arrchasisveh = new Array([]);
			var arrmotorveh = new Array([]);
			var arrplacasveh = new Array([]);
			var arrpaisveh = new Array([]);
			//alert(cantvehiculos.value);
			for(var i = 1; i <= parseInt(cantvehiculos.value); i++){
				tipoveh = document.getElementById("tipoveh"+i);
				marcaveh = document.getElementById("marcaveh"+i);
				lineaveh = document.getElementById("lineaveh"+i);
				modeloveh = document.getElementById("modeloveh"+i);
				tarjetaveh = document.getElementById("tarjetaveh"+i);
				colorveh = document.getElementById("colorveh"+i);
				chasisveh = document.getElementById("chasisveh"+i);
				motorveh = document.getElementById("motorveh"+i);
				placasveh = document.getElementById("placasveh"+i);
				paisveh = document.getElementById("paisveh"+i);
				//--
				if(tipoveh.value !=="" && marcaveh.value !=="" && lineaveh.value !=="" && modeloveh.value !=="" && tarjetaveh.value !=="" && colorveh.value !=="" && chasisveh.value !=="" && motorveh.value !=="" && placasveh.value !=="" && paisveh.value !== "") {
					arrtipoveh[i] = tipoveh.value;
					arrmarcaveh[i] = marcaveh.value;
					arrlineaveh[i] = lineaveh.value;
					arrmodeloveh[i] = modeloveh.value;
					arrtarjetaveh[i] = tarjetaveh.value;
					arrcolorveh[i] = colorveh.value;
					arrchasisveh[i] = chasisveh.value;
					arrmotorveh[i] = motorveh.value;
					arrplacasveh[i] = placasveh.value;
					arrpaisveh[i] = paisveh.value;
					tipoveh.className = "form-control";
					marcaveh.className = "form-control";
					lineaveh.className = "form-control";
					modeloveh.className = "form-control";
					tarjetaveh.className = "form-control";
					colorveh.className = "form-control";
					chasisveh.className = "form-control";
					motorveh.className = "form-control";
					placasveh.className = "form-control";
					paisveh.className = "form-control";
				}else{
					tipoveh.className = "form-danger";
					marcaveh.className = "form-danger";
					lineaveh.className = "form-danger";
					modeloveh.className = "form-danger";
					tarjetaveh.className = "form-danger";
					colorveh.className = "form-danger";
					chasisveh.className = "form-danger";
					motorveh.className = "form-danger";
					placasveh.className = "form-danger";
					paisveh.className = "form-danger";
					msj = '<h5>Faltan datos del modulo de vehiculos, indico '+cantvehiculos.value+' a ingresar...</h5><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					return;
				}
			}
			//// Armamento //// Usado solo para empresas que tienen personal de seguridad...
			/*var arrtipoarma = new Array([]);
			var arrmarcaarma = new Array([]);
			var arrcalarma = new Array([]);
			var arrnumarma = new Array([]);
			for(var i = 1; i <= parseInt(cantarmas.value); i++){
				tipoarma = document.getElementById("tipoarma"+i);
				marcaarma = document.getElementById("marcaarma"+i);
				calarma = document.getElementById("calarma"+i);
				numarma = document.getElementById("numarma"+i);
				if(tipoarma.value !=="" && marcaarma.value !=="" && calarma.value !=="" && numarma.value !== "") {
					arrtipoarma[i] = tipoarma.value;
					arrmarcaarma[i] = marcaarma.value;
					arrcalarma[i] = calarma.value;
					arrnumarma[i] = numarma.value;
					tipoarma.className = "form-control";
					marcaarma.className = "form-control";
					calarma.className = "form-control";
					numarma.className = "form-control";
				}else{
					tipoarma.className = "form-danger";
					marcaarma.className = "form-danger";
					calarma.className = "form-danger";
					numarma.className = "form-danger";
					msj = '<h5>Faltan datos del modulo de armamento, indico '+cantarmas.value+' a ingresar...</h5><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					return;
				}
			}*/  //Usado solo para empresas que tienen personal de seguridad...
			
			//// Titulos ////
			var arrnivelu = new Array([]);
			var arrtitulo = new Array([]);
			var arrunversidad = new Array([]);
			var arrpaistit = new Array([]);
			var arraniotit = new Array([]);
			var arrsemtit = new Array([]);
			var arrgraduadotit = new Array([]);
			for(var i = 1; i <= parseInt(canttitulos.value); i++){
				nivelu = document.getElementById("nivelu"+i);
				titulo = document.getElementById("titulo"+i);
				unversidad = document.getElementById("unversidad"+i);
				paistit = document.getElementById("paistit"+i);
				aniotit = document.getElementById("aniotit"+i);
				semtit = document.getElementById("semtit"+i);
				graduadotit = document.getElementById("graduadotit"+i);
				
				if(nivelu.value !== "" && titulo.value !== "" && unversidad.value !== "" && paistit.value !== "" && aniotit.value !== "" && semtit.value !== "" && graduadotit.value !== "") {
					arrnivelu[i] = nivelu.value;
					arrtitulo[i] = titulo.value;
					arrunversidad[i] = unversidad.value;
					arrpaistit[i] = paistit.value;
					arraniotit[i] = aniotit.value;
					arrsemtit[i] = semtit.value;
					arrgraduadotit[i] = graduadotit.value;
					nivelu.className = "form-control";
					titulo.className = "form-control";
					unversidad.className = "form-control";
					paistit.className = "form-control";
					aniotit.className = "form-control";
					semtit.className = "form-control";
					graduadotit.className = "form-control";
				}else{
					nivelu.className = "form-danger";
					titulo.className = "form-danger";
					unversidad.className = "form-danger";
					paistit.className = "form-danger";
					aniotit.className = "form-danger";
					semtit.className = "form-danger";
					graduadotit.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de tiutulos universitarios, indico '+canttitulos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Idiomas ////
			var arridioma = new Array([]);
			var arrhabla = new Array([]);
			var arrlee = new Array([]);
			var arrescribe = new Array([]);
			for(var i = 1; i <= parseInt(cantidiomas.value); i++){
				idioma = document.getElementById("idioma"+i);
				habla = document.getElementById("habla"+i);
				lee = document.getElementById("lee"+i);
				escribe = document.getElementById("escribe"+i);
				
				if(idioma.value !== "" && habla.value !== "" && lee.value !== "" && escribe.value !== "") {
					arridioma[i] = idioma.value;
					arrhabla[i] = habla.value;
					arrlee[i] = lee.value;
					arrescribe[i] = escribe.value;//--
					idioma.className = "form-control";
					habla.className = "form-control";
					lee.className = "form-control";
					escribe.className = "form-control";
				}else{
					idioma.className = "form-danger";
					habla.className = "form-danger";
					lee.className = "form-danger";
					escribe.className = "form-danger";//--
					
					swal("Ohoo!", 'Faltan datos del modulo de idiomas, indico '+cantidiomas.value+' a ingresar...', "error");
					return;
				}
			}
			
			//// Cursos Civiles ////
			var arrnivelciv = new Array([]);
			var arrotrocurso = new Array([]);
			var arrinstituto = new Array([]);
			var arrpaisotrocur = new Array([]);
			var arraniootrocur = new Array([]);
			for(var i = 1; i <= parseInt(cantotroscursos.value); i++){
				nivelciv = document.getElementById("nivelciv"+i);
				otrocurso = document.getElementById("otrocurso"+i);
				instituto = document.getElementById("instituto"+i);
				paisotrocur = document.getElementById("paisotrocur"+i);
				aniootrocur = document.getElementById("aniootrocur"+i);
				
				if(nivelciv.value !== "" && otrocurso.value !== "" && instituto.value !== "" && paisotrocur.value !== "" && aniootrocur.value !== "") {
					arrnivelciv[i] = nivelciv.value;
					arrotrocurso[i] = otrocurso.value;
					arrinstituto[i] = instituto.value;
					arrpaisotrocur[i] = paisotrocur.value;
					arraniootrocur[i] = aniootrocur.value;
					nivelciv.className = "form-control";
					otrocurso.className = "form-control";
					instituto.className = "form-control";
					paisotrocur.className = "form-control";
					aniootrocur.className = "form-control";
				}else{
					nivelciv.className = "form-danger";
					otrocurso.className = "form-danger";
					instituto.className = "form-danger";
					paisotrocur.className = "form-danger";
					aniootrocur.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de otros cursos, indico '+cantotroscursos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Hijos ////
			var arrnomhijo = new Array([]);
			var arrapehijo = new Array([]);
			var arrpaishijo = new Array([]);
			var arrreligionhijo = new Array([]);
			var arrfecnachijo = new Array([]);
			for(var i = 1; i <= parseInt(canthijos.value); i++){
				nomhijo = document.getElementById("nomhijo"+i);
				apehijo = document.getElementById("apehijo"+i);
				paishijo = document.getElementById("paishijo"+i);
				religionhijo = document.getElementById("religionhijo"+i);
				fecnachijo = document.getElementById("fecnachijo"+i);
				
				if(nomhijo.value !== "" && nomhijo.value !== "" && paishijo.value !== "" && religionhijo.value !== "" && fecnachijo.value !== "") {
					arrnomhijo[i] = nomhijo.value;
					arrapehijo[i] = apehijo.value;
					arrpaishijo[i] = paishijo.value;
					arrreligionhijo[i] = religionhijo.value;
					arrfecnachijo[i] = fecnachijo.value;
					nomhijo.className = "form-control";
					apehijo.className = "form-control";
					paishijo.className = "form-control";
					religionhijo.className = "form-control";
					fecnachijo.className = "form-control";
				}else{
					nomhijo.className = "form-danger";
					apehijo.className = "form-danger";
					paishijo.className = "form-danger";
					religionhijo.className = "form-danger";
					fecnachijo.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de hijos, indico '+canthijos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Hermanos ////
			var arrnomhermano = new Array([]);
			var arrapehermano = new Array([]);
			var arrpaishermano = new Array([]);
			var arrreligionhermano = new Array([]);
			var arrfecnachermano = new Array([]);
			for(var i = 1; i <= parseInt(canthermanos.value); i++){
				nomhermano = document.getElementById("nomhermano"+i);
				apehermano = document.getElementById("apehermano"+i);
				paishermano = document.getElementById("paishermano"+i);
				religionhermano = document.getElementById("religionhermano"+i);
				fecnachermano = document.getElementById("fecnachermano"+i);
				
				if(nomhermano.value !== "" && apehermano.value !== "" && paishermano.value !== "" && religionhermano.value !== "" && fecnachermano.value !== "") {
					arrnomhermano[i] = nomhermano.value;
					arrapehermano[i] = apehermano.value;
					arrpaishermano[i] = paishermano.value;
					arrreligionhermano[i] = religionhermano.value;
					arrfecnachermano[i] = fecnachermano.value;
					nomhermano.className = "form-control";
					apehermano.className = "form-control";
					paishermano.className = "form-control";
					religionhermano.className = "form-control";
					fecnachermano.className = "form-control";
				}else{
					nomhermano.className = "form-danger";
					apehermano.className = "form-danger";
					paishermano.className = "form-danger";
					religionhermano.className = "form-danger";
					fecnachermano.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de hermanos, indico '+canthermanos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Familiares en la Institucion ////
			var arrnomfaminst = new Array([]);
			var arrparenfaminst = new Array([]);
			var arrpuestofaminst = new Array([]);
			var arraniofaminst = new Array([]);
			for(var i = 1; i <= parseInt(cantfaminst.value); i++){
				nomfaminst = document.getElementById("nomfaminst"+i);
				parenfaminst = document.getElementById("parenfaminst"+i);
				puestofaminst = document.getElementById("puestofaminst"+i);
				aniofaminst = document.getElementById("aniofaminst"+i);
				
				if(nomfaminst.value !== "" && parenfaminst.value !== "" && puestofaminst.value !== "" && aniofaminst.value !== "") {
					arrnomfaminst[i] = nomfaminst.value;
					arrparenfaminst[i] = parenfaminst.value;
					arrpuestofaminst[i] = puestofaminst.value;
					arraniofaminst[i] = aniofaminst.value;
					nomfaminst.className = "form-control";
					parenfaminst.className = "form-control";
					puestofaminst.className = "form-control";
					aniofaminst.className = "form-control";
				}else{
					nomfaminst.className = "form-danger";
					parenfaminst.className = "form-danger";
					puestofaminst.className = "form-danger";
					aniofaminst.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de familiares que han trabajado para la institucion, indico '+cantfaminst.value+' filas a ingresar...', "error");
					return;
				}
			}
			//// Referencias Sociales ////
			var arrnomsocial = new Array([]);
			var arrdirsocial = new Array([]);
			var arrtelsocial = new Array([]);
			var arrtrabajosocial = new Array([]);
			var arrcargosocial = new Array([]);
			for(var i = 1; i <= parseInt(cantrefsocial.value); i++){
				nomsocial = document.getElementById("nomsocial"+i);
				dirsocial = document.getElementById("dirsocial"+i);
				telsocial = document.getElementById("telsocial"+i);
				trabajosocial = document.getElementById("trabajosocial"+i);
				cargosocial = document.getElementById("cargosocial"+i);
				
				if(nomsocial.value !== "" && dirsocial.value !== "" && telsocial.value !== "" && trabajosocial.value !== "" && cargosocial.value !== "") {
					arrnomsocial[i] = nomsocial.value;
					arrdirsocial[i] = dirsocial.value;
					arrtelsocial[i] = telsocial.value;
					arrtrabajosocial[i] = trabajosocial.value;
					arrcargosocial[i] = cargosocial.value;
					nomsocial.className = "form-control";
					dirsocial.className = "form-control";
					telsocial.className = "form-control";
					trabajosocial.className = "form-control";
					cargosocial.className = "form-control";
				}else{
					nomsocial.className = "form-danger";
					dirsocial.className = "form-danger";
					telsocial.className = "form-danger";
					trabajosocial.className = "form-danger";
					cargosocial.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de referencias sociales, indico '+cantrefsocial.value+' a ingresar...', "error");
					return;
				}
			}
				abrir();
				xajax_Grabar_Personal(dpi.value,nom.value,ape.value,nit.value,profesion.value,religion.value,
					pasa.value,igss.value,genero.value,ecivil.value,depn.value,paisn.value,fecnac.value,dir2.value,munde.value,tel2.value,dir1.value,
					mundp.value,tel1.value,sangre.value,alergia.value,cel.value,email.value,emernombre.value,emerapellido.value,emerdirec.value,
					emertel.value,emercel.value,tcamisa.value,tpantalon.value,tchumpa.value,tbotas.value,tgorra.value,
					estatura.value,peso.value,tez.value,ojos.value,nariz.value,tlicv.value,nlicv.value,nlicm.value,deportes.value,empleadoconyugue.value,ingresosconyugue.value,
					trabajoconyugue.value,cargasfam.value,casa.value,costocasa.value,cuentasbanco.value,bancos.value,tarjetascred.value,bancostarjeta.value,
					otrosingresos.value,montootros.value,sueldo.value,descuentos.value,prestamos.value,saldo.value,detenido.value,motivodetenido.value,
					dondedetenido.value,cuandodetenido.value,porquedetenido.value,feclibertad.value,arraigado.value,motivoarraigado.value,dondearraigo.value,
					cuandoarraigo.value,ultimoempleo.value,telultimoempleo.value,dirultimoempleo.value,pueultimoempleo.value,empultimoempleo.value,
					sueldoultimoempleo.value,fecultimoempleo.value,primaria.value,lugprimaria.value,secundaria.value,secuncarrera.value,lugsecundaria.value,
					famnombre2.value,famapellido2.value,fampais2.value,famreligion2.value,famdirec2.value,
					famtel2.value,famcel2.value,famprofe2.value,padrefecnac.value,famnombre3.value,famapellido3.value,fampais3.value,famreligion3.value,
					famdirec3.value,famtel3.value,famcel3.value,famprofe3.value,madrefecnac.value,famnombre4.value,famapellido4.value,fampais4.value,
					famreligion4.value,famdirec4.value,famtel4.value,famcel4.value,famprofe4.value,esposafecnac.value,arrnomhijo,arrapehijo,arrpaishijo,
					arrreligionhijo,arrfecnachijo,arrnomhermano,arrapehermano,arrpaishermano,arrreligionhermano,arrfecnachermano,arrnomfaminst,
					arrparenfaminst,arrpuestofaminst,arraniofaminst,arrtipoveh,arrmarcaveh,arrlineaveh,arrmodeloveh,arrtarjetaveh,arrcolorveh,arrchasisveh,arrmotorveh,
					arrplacasveh,arrpaisveh,arrnivelu,arrtitulo,arrunversidad,arrpaistit,arraniotit,arrsemtit,
					arrgraduadotit,arrnivelciv,arrotrocurso,arrinstituto,arrpaisotrocur,arraniootrocur,arridioma,
					arrhabla,arrlee,arrescribe,arrnomsocial,arrdirsocial,arrtelsocial,arrtrabajosocial,arrcargosocial,cantvehiculos.value,canttitulos.value,
					cantidiomas.value,cantotroscursos.value,canthijos.value,canthermanos.value,cantfaminst.value,cantrefsocial.value);
					
					
		}else{
			//personal
			if(nom.value == ""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(ape.value == ""){
				ape.className = "form-danger";
			}else{
				ape.className = "form-control";
			}
			if(profesion.value == ""){
				profesion.className = "form-danger";
			}else{
				profesion.className = "form-control";
			}
			if(religion.value == ""){
				religion.className = "form-danger";
			}else{
				religion.className = "form-control";
			}
			if(genero.value == ""){
				genero.className = "form-danger";
			}else{
				genero.className = "form-control";
			}
			if(ecivil.value == ""){
				ecivil.className = "form-danger";
			}else{
				ecivil.className = "form-control";
			}
			if(fecnac.value == ""){
				fecnac.className = "form-danger";
			}else{
				fecnac.className = "form-control";
			}
			if(edad.value == ""){
				edad.className = "form-danger";
			}else{
				edad.className = "form-control";
			}
			if(depn.value == ""){
				depn.className = "form-danger";
			}else{
				depn.className = "form-control";
			}
			if(paisn.value == ""){
				paisn.className = "form-danger";
			}else{
				paisn.className = "form-control";
			}
			if(dir1.value == ""){
				dir1.className = "form-danger";
			}else{
				dir1.className = "form-control";
			}
			if(tel1.value == ""){
				tel1.className = "form-danger";
			}else{
				tel1.className = "form-control";
			}
			if(depdp.value == ""){
				depdp.className = "form-danger";
			}else{
				depdp.className = "form-control";
			}
			if(mundp.value == ""){
				mundp.className = "form-danger";
			}else{
				mundp.className = "form-control";
			}
			if(dir2.value == ""){
				dir2.className = "form-danger";
			}else{
				dir2.className = "form-control";
			}
			if(tel2.value == ""){
				tel2.className = "form-danger";
			}else{
				tel2.className = "form-control";
			}
			if(depde.value == ""){
				depde.className = "form-danger";
			}else{
				depde.className = "form-control";
			}
			if(munde.value == ""){
				munde.className = "form-danger";
			}else{
				munde.className = "form-control";
			}
			if(sangre.value == ""){
				sangre.className = "form-danger";
			}else{
				sangre.className = "form-control";
			}
			if(cel.value == ""){
				cel.className = "form-danger";
			}else{
				cel.className = "form-control";
			}
			if(email.value == ""){
				email.className = "form-danger";
			}else{
				email.className = "form-control";
			}
			//documentos
			if(dpi.value == ""){
				dpi.className = "form-danger";
			}else{
				dpi.className = "form-control";
			}
			if(cantvehiculos.value == ""){
				cantvehiculos.className = "form-danger";
			}else{
				cantvehiculos.className = "form-control";
			}
			/*if(cantarmas.value == ""){
				cantarmas.className = "form-danger";
			}else{
				cantarmas.className = "form-control";
			}*/
			//educacion
			if(primaria.value == ""){
				primaria.className = "form-danger";
			}else{
				primaria.className = "form-control";
			}
			if(lugprimaria.value == ""){
				lugprimaria.className = "form-danger";
			}else{
				lugprimaria.className = "form-control";
			}
			if(canttitulos.value == ""){
				canttitulos.className = "form-danger";
			}else{
				canttitulos.className = "form-control";
			}
			if(cantidiomas.value == ""){
				cantidiomas.className = "form-danger";
			}else{
				cantidiomas.className = "form-control";
			}
			if(cantotroscursos.value == ""){
				cantotroscursos.className = "form-danger";
			}else{
				cantotroscursos.className = "form-control";
			}
			//puestofaminst
			if(canthijos.value == ""){
				canthijos.className = "form-danger";
			}else{
				canthijos.className = "form-control";
			}
			if(canthermanos.value == ""){
				canthermanos.className = "form-danger";
			}else{
				canthermanos.className = "form-control";
			}
			if(emergencia.value == ""){
				emergencia.className = "form-danger";
			}else{
				emergencia.className = "form-control";
			}
			if(emerdirec.value == ""){
				emerdirec.className = "form-danger";
			}else{
				emerdirec.className = "form-control";
			}
			if(emernombre.value == ""){
				emernombre.className = "form-danger";
			}else{
				emernombre.className = "form-control";
			}
			if(emerapellido.value == ""){
				emerapellido.className = "form-danger";
			}else{
				emerapellido.className = "form-control";
			}
			if(cantfaminst.value == ""){
				cantfaminst.className = "form-danger";
			}else{
				cantfaminst.className = "form-control";
			}
			//social
			if(cantrefsocial.value == ""){
				cantrefsocial.className = "form-danger";
			}else{
				cantrefsocial.className = "form-control";
			}
			if(deportes.value == ""){
				deportes.className = "form-danger";
			}else{
				deportes.className = "form-control";
			}
			//economica
			if(cargasfam.value == ""){
				cargasfam.className = "form-danger";
			}else{
				cargasfam.className = "form-control";
			}
			if(casa.value == ""){
				casa.className = "form-danger";
			}else{
				casa.className = "form-control";
			}
			if(costocasa.value == ""){
				costocasa.className = "form-danger";
			}else{
				costocasa.className = "form-control";
			}
			if(cuentasbanco.value == ""){
				cuentasbanco.className = "form-danger";
			}else{
				cuentasbanco.className = "form-control";
			}
			if(tarjetascred.value == ""){
				tarjetascred.className = "form-danger";
			}else{
				tarjetascred.className = "form-control";
			}
			if(sueldo.value == ""){
				sueldo.className = "form-danger";
			}else{
				sueldo.className = "form-control";
			}
			if(descuentos.value == ""){
				descuentos.className = "form-danger";
			}else{
				descuentos.className = "form-control";
			}
			if(prestamos.value == ""){
				prestamos.className = "form-danger";
			}else{
				prestamos.className = "form-control";
			}
			//penal
			if(detenido.value == ""){
				detenido.className = "form-danger";
			}else{
				detenido.className = "form-control";
			}
			if(arraigado.value == ""){
				arraigado.className = "form-danger";
			}else{
				arraigado.className = "form-control";
			}
			//somatometrica
			if(tcamisa.value == ""){
				tcamisa.className = "form-danger";
			}else{
				tcamisa.className = "form-control";
			}
			if(tpantalon.value == ""){
				tpantalon.className = "form-danger";
			}else{
				tpantalon.className = "form-control";
			}
			if(tchumpa.value == ""){
				tchumpa.className = "form-danger";
			}else{
				tchumpa.className = "form-control";
			}
			if(tbotas.value == ""){
				tbotas.className = "form-danger";
			}else{
				tbotas.className = "form-control";
			}
			if(tgorra.value == ""){
				tgorra.className = "form-danger";
			}else{
				tgorra.className = "form-control";
			}
			if(estatura.value == ""){
				estatura.className = "form-danger";
			}else{
				estatura.className = "form-control";
			}
			if(peso.value == ""){
				peso.className = "form-danger";
			}else{
				peso.className = "form-control";
			}
			if(tez.value == ""){
				tez.className = "form-danger";
			}else{
				tez.className = "form-control";
			}
			if(ojos.value == ""){
				ojos.className = "form-danger";
			}else{
				ojos.className = "form-control";
			}
			if(nariz.value == ""){
				nariz.className = "form-danger";
			}else{
				nariz.className = "form-control";
			}	
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
	function Modificar(){
		//alert("entro...");
		//personal
		nom = document.getElementById("nom");
		ape = document.getElementById("ape");
		profesion = document.getElementById("profesion");
		religion = document.getElementById("religion");
		genero = document.getElementById("genero");
		ecivil = document.getElementById("ecivil");
		fecnac = document.getElementById("fecnac");
		edad = document.getElementById("edad"); //eliminar en cadena xajax
		depn = document.getElementById("depn");
		paisn = document.getElementById("paisn");
		dir1 = document.getElementById("dir1");
		tel1 = document.getElementById("tel1");
		depdp = document.getElementById("depdp");//eliminar en cadena xajax
		mundp = document.getElementById("mundp");
		dir2 = document.getElementById("dir2");
		tel2 = document.getElementById("tel2");
		depde = document.getElementById("depde");//eliminar en cadena xajax
		munde = document.getElementById("munde");
		sangre = document.getElementById("sangre");
		alergia = document.getElementById("alergia");
		cel = document.getElementById("cel");
		email = document.getElementById("email");
		//documentos
		dpi = document.getElementById("dpi");
		nit = document.getElementById("nit");
		pasa = document.getElementById("pasa");
		igss = document.getElementById("igss");
		tlicv = document.getElementById("tlicv");
		nlicv = document.getElementById("nlicv");
		nlicm = document.getElementById("nlicm");
		cantvehiculos = document.getElementById("cantvehiculos"); ///--- cantidad ---///
		/*licportacion = document.getElementById("licportacion");
		cantarmas = document.getElementById("cantarmas"); ///--- cantidad ---///
		feciniarma = document.getElementById("feciniarma");//fecha falsa
		fecfinarma = document.getElementById("fecfinarma");//fecha falsa*/
		//educacion
		primaria = document.getElementById("primaria");
		lugprimaria = document.getElementById("lugprimaria");
		secundaria = document.getElementById("secundaria");
		secuncarrera = document.getElementById("secuncarrera");
		lugsecundaria = document.getElementById("lugsecundaria");
		canttitulos = document.getElementById("canttitulos"); ///--- cantidad ---///
		cantidiomas = document.getElementById("cantidiomas"); ///--- cantidad ---///
		cantotroscursos = document.getElementById("cantotroscursos"); ///--- cantidad ---///
		//faminstia
		famnombre2 = document.getElementById("famnombre2");
		famapellido2 = document.getElementById("famapellido2");
		fampais2 = document.getElementById("fampais2");
		famreligion2 = document.getElementById("famreligion2");
		famdirec2 = document.getElementById("famdirec2");
		famtel2 = document.getElementById("famtel2");
		famcel2 = document.getElementById("famcel2");
		famprofe2 = document.getElementById("famprofe2");
		padrefecnac = document.getElementById("padrefecnac");
		padreedad = document.getElementById("padreedad");//eliminar en cadena xajax
		famnombre3 = document.getElementById("famnombre3");
		famapellido3 = document.getElementById("famapellido3");
		fampais3 = document.getElementById("fampais3");
		famreligion3 = document.getElementById("famreligion3");
		famdirec3 = document.getElementById("famdirec3");
		famtel3 = document.getElementById("famtel3");
		famcel3 = document.getElementById("famcel3");
		famprofe3 = document.getElementById("famprofe3");
		madrefecnac = document.getElementById("madrefecnac");
		madreedad = document.getElementById("madreedad");//eliminar en cadena xajax
		famnombre4 = document.getElementById("famnombre4");
		famapellido4 = document.getElementById("famapellido4");
		fampais4 = document.getElementById("fampais4");
		famreligion4 = document.getElementById("famreligion4");
		famdirec4 = document.getElementById("famdirec4");
		famtel4 = document.getElementById("famtel4");
		famcel4 = document.getElementById("famcel4");
		famprofe4 = document.getElementById("famprofe4");
		esposafecnac = document.getElementById("esposafecnac");
		esposaedad = document.getElementById("esposaedad");//eliminar en cadena xajax
		canthijos = document.getElementById("canthijos"); ///--- cantidad ---///
		canthermanos = document.getElementById("canthermanos"); ///--- cantidad ---///
		emergencia = document.getElementById("emergencia");
		emerdirec = document.getElementById("emerdirec");
		emernombre = document.getElementById("emernombre");
		emerapellido = document.getElementById("emerapellido");
		emertel = document.getElementById("emertel");
		emercel = document.getElementById("emercel");
		cantfaminst = document.getElementById("cantfaminst"); ///--- cantidad ---///
		//social
		cantrefsocial = document.getElementById("cantrefsocial"); ///--- cantidad ---///
		deportes = document.getElementById("deportes");
		//economica
		empleadoconyugue = document.getElementById("empleadoconyugue");
		ingresosconyugue = document.getElementById("ingresosconyugue");
		trabajoconyugue = document.getElementById("trabajoconyugue");
		cargasfam = document.getElementById("cargasfam");
		casa = document.getElementById("casa");
		costocasa = document.getElementById("costocasa");
		cuentasbanco = document.getElementById("cuentasbanco");
		bancos = document.getElementById("bancos");
		tarjetascred = document.getElementById("tarjetascred");
		bancostarjeta = document.getElementById("bancostarjeta");
		otrosingresos = document.getElementById("otrosingresos");
		montootros = document.getElementById("montootros");
		sueldo = document.getElementById("sueldo");
		descuentos = document.getElementById("descuentos");
		prestamos = document.getElementById("prestamos");
		saldo = document.getElementById("saldo");
		//penal
		detenido = document.getElementById("detenido");
		motivodetenido = document.getElementById("motivodetenido");
		dondedetenido = document.getElementById("dondedetenido");
		cuandodetenido = document.getElementById("cuandodetenido");
		porquedetenido = document.getElementById("porquedetenido");
		feclibertad = document.getElementById("feclibertad");
		arraigado = document.getElementById("arraigado");
		motivoarraigado = document.getElementById("motivoarraigado");
		dondearraigo = document.getElementById("dondearraigo");
		cuandoarraigo = document.getElementById("cuandoarraigo");
		//fecpenales = document.getElementById("fecpenales");
		//fecpoliciacos = document.getElementById("fecpoliciacos");
		//laboral anterior
		ultimoempleo = document.getElementById("ultimoempleo");
		telultimoempleo = document.getElementById("telultimoempleo");
		dirultimoempleo = document.getElementById("dirultimoempleo");
		pueultimoempleo = document.getElementById("pueultimoempleo");
		empultimoempleo = document.getElementById("empultimoempleo");
		sueldoultimoempleo = document.getElementById("sueldoultimoempleo");
		fecultimoempleo = document.getElementById("fecultimoempleo");
		//somatometrica
		tcamisa = document.getElementById("tcamisa");
		tpantalon = document.getElementById("tpantalon");
		tchumpa = document.getElementById("tchumpa");
		tbotas = document.getElementById("tbotas");
		tgorra = document.getElementById("tgorra");
		estatura = document.getElementById("estatura");
		peso = document.getElementById("peso");
		tez = document.getElementById("tez");
		ojos = document.getElementById("ojos");
		nariz = document.getElementById("nariz");
		//--
		
		if(dpi.value !== "" && nom.value !== "" && ape.value !== "" &&
			profesion.value !== "" && religion.value !== "" && genero.value !== "" && ecivil.value !== "" && fecnac.value !== "" && edad.value !== "" && depn.value !== "" &&
			paisn.value !== "" && dir1.value !== "" && tel1.value !== "" && depdp.value !== "" && mundp.value !== "" && dir2.value !== "" && tel2.value !== "" && depde.value !== "" &&
			munde.value !== "" && sangre.value !== "" && cel.value !== "" && email.value !== "" && cantvehiculos.value !== "" &&
			primaria.value !== "" && lugprimaria.value !== "" && canttitulos.value !== "" && cantidiomas.value !== "" && cantotroscursos.value !== "" &&
			canthijos.value !== "" && canthermanos.value !== "" && emergencia.value !== "" && emerdirec.value !== "" && emernombre.value !== "" && emerapellido.value !== "" &&
			cantfaminst.value !== "" && cantrefsocial.value !== "" && deportes.value !== "" && cargasfam.value !== "" && casa.value !== "" && costocasa.value !== "" &&
			cuentasbanco.value !== "" && tarjetascred.value !== "" && sueldo.value !== "" && descuentos.value !== "" && prestamos.value !== "" && detenido.value !== "" &&
			arraigado.value !== "" && tcamisa.value !== "" && tpantalon.value !== "" && tchumpa.value !== "" && tbotas.value !== "" && tgorra.value !== "" &&
			estatura.value !== "" && peso.value !== "" && tez.value !== "" && ojos.value !== "" && nariz.value !== ""){
			
			//// Vehiculos ////
			var arrtipoveh = new Array([]);
			var arrmarcaveh = new Array([]);
			var arrlineaveh = new Array([]);
			var arrmodeloveh = new Array([]);
			var arrtarjetaveh = new Array([]);
			var arrcolorveh = new Array([]);
			var arrchasisveh = new Array([]);
			var arrmotorveh = new Array([]);
			var arrplacasveh = new Array([]);
			var arrpaisveh = new Array([]);
			//alert(cantvehiculos.value);
			for(var i = 1; i <= parseInt(cantvehiculos.value); i++){
				tipoveh = document.getElementById("tipoveh"+i);
				marcaveh = document.getElementById("marcaveh"+i);
				lineaveh = document.getElementById("lineaveh"+i);
				modeloveh = document.getElementById("modeloveh"+i);
				tarjetaveh = document.getElementById("tarjetaveh"+i);
				colorveh = document.getElementById("colorveh"+i);
				chasisveh = document.getElementById("chasisveh"+i);
				motorveh = document.getElementById("motorveh"+i);
				placasveh = document.getElementById("placasveh"+i);
				paisveh = document.getElementById("paisveh"+i);
				//--
				if(tipoveh.value !=="" && marcaveh.value !=="" && lineaveh.value !=="" && modeloveh.value !=="" && tarjetaveh.value !=="" && colorveh.value !=="" && chasisveh.value !=="" && motorveh.value !=="" && placasveh.value !=="" && paisveh.value !== "") {
					arrtipoveh[i] = tipoveh.value;
					arrmarcaveh[i] = marcaveh.value;
					arrlineaveh[i] = lineaveh.value;
					arrmodeloveh[i] = modeloveh.value;
					arrtarjetaveh[i] = tarjetaveh.value;
					arrcolorveh[i] = colorveh.value;
					arrchasisveh[i] = chasisveh.value;
					arrmotorveh[i] = motorveh.value;
					arrplacasveh[i] = placasveh.value;
					arrpaisveh[i] = paisveh.value;
					tipoveh.className = "form-control";
					marcaveh.className = "form-control";
					lineaveh.className = "form-control";
					modeloveh.className = "form-control";
					tarjetaveh.className = "form-control";
					colorveh.className = "form-control";
					chasisveh.className = "form-control";
					motorveh.className = "form-control";
					placasveh.className = "form-control";
					paisveh.className = "form-control";
				}else{
					tipoveh.className = "form-danger";
					marcaveh.className = "form-danger";
					lineaveh.className = "form-danger";
					modeloveh.className = "form-danger";
					tarjetaveh.className = "form-danger";
					colorveh.className = "form-danger";
					chasisveh.className = "form-danger";
					motorveh.className = "form-danger";
					placasveh.className = "form-danger";
					paisveh.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de vehiculos, indico '+cantvehiculos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Armamento //// Usado solo para empresas que tienen personal de seguridad...
			/*var arrtipoarma = new Array([]);
			var arrmarcaarma = new Array([]);
			var arrcalarma = new Array([]);
			var arrnumarma = new Array([]);
			for(var i = 1; i <= parseInt(cantarmas.value); i++){
				tipoarma = document.getElementById("tipoarma"+i);
				marcaarma = document.getElementById("marcaarma"+i);
				calarma = document.getElementById("calarma"+i);
				numarma = document.getElementById("numarma"+i);
				if(tipoarma.value !=="" && marcaarma.value !=="" && calarma.value !=="" && numarma.value !== "") {
					arrtipoarma[i] = tipoarma.value;
					arrmarcaarma[i] = marcaarma.value;
					arrcalarma[i] = calarma.value;
					arrnumarma[i] = numarma.value;
					tipoarma.className = "form-control";
					marcaarma.className = "form-control";
					calarma.className = "form-control";
					numarma.className = "form-control";
				}else{
					tipoarma.className = "form-danger";
					marcaarma.className = "form-danger";
					calarma.className = "form-danger";
					numarma.className = "form-danger";
					msj = '<h5>Faltan datos del modulo de armamento, indico '+cantarmas.value+' a ingresar...</h5><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					return;
				}
			}*/  //Usado solo para empresas que tienen personal de seguridad...
			
			//// Titulos ////
			var arrnivelu = new Array([]);
			var arrtitulo = new Array([]);
			var arrunversidad = new Array([]);
			var arrpaistit = new Array([]);
			var arraniotit = new Array([]);
			var arrsemtit = new Array([]);
			var arrgraduadotit = new Array([]);
			for(var i = 1; i <= parseInt(canttitulos.value); i++){
				nivelu = document.getElementById("nivelu"+i);
				titulo = document.getElementById("titulo"+i);
				unversidad = document.getElementById("unversidad"+i);
				paistit = document.getElementById("paistit"+i);
				aniotit = document.getElementById("aniotit"+i);
				semtit = document.getElementById("semtit"+i);
				graduadotit = document.getElementById("graduadotit"+i);
				
				if(nivelu.value !== "" && titulo.value !== "" && unversidad.value !== "" && paistit.value !== "" && aniotit.value !== "" && semtit.value !== "" && graduadotit.value !== "") {
					arrnivelu[i] = nivelu.value;
					arrtitulo[i] = titulo.value;
					arrunversidad[i] = unversidad.value;
					arrpaistit[i] = paistit.value;
					arraniotit[i] = aniotit.value;
					arrsemtit[i] = semtit.value;
					arrgraduadotit[i] = graduadotit.value;
					nivelu.className = "form-control";
					titulo.className = "form-control";
					unversidad.className = "form-control";
					paistit.className = "form-control";
					aniotit.className = "form-control";
					semtit.className = "form-control";
					graduadotit.className = "form-control";
				}else{
					nivelu.className = "form-danger";
					titulo.className = "form-danger";
					unversidad.className = "form-danger";
					paistit.className = "form-danger";
					aniotit.className = "form-danger";
					semtit.className = "form-danger";
					graduadotit.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de tiutulos universitarios, indico '+canttitulos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Idiomas ////
			var arridioma = new Array([]);
			var arrhabla = new Array([]);
			var arrlee = new Array([]);
			var arrescribe = new Array([]);
			for(var i = 1; i <= parseInt(cantidiomas.value); i++){
				idioma = document.getElementById("idioma"+i);
				habla = document.getElementById("habla"+i);
				lee = document.getElementById("lee"+i);
				escribe = document.getElementById("escribe"+i);
				
				if(idioma.value !== "" && habla.value !== "" && lee.value !== "" && escribe.value !== "") {
					arridioma[i] = idioma.value;
					arrhabla[i] = habla.value;
					arrlee[i] = lee.value;
					arrescribe[i] = escribe.value;//--
					idioma.className = "form-control";
					habla.className = "form-control";
					lee.className = "form-control";
					escribe.className = "form-control";
				}else{
					idioma.className = "form-danger";
					habla.className = "form-danger";
					lee.className = "form-danger";
					escribe.className = "form-danger";//--
					swal("Ohoo!", 'Faltan datos del modulo de idiomas, indico '+cantidiomas.value+' a ingresar...', "error");
					return;
				}
			}
			
			//// Cursos Civiles ////
			var arrnivelciv = new Array([]);
			var arrotrocurso = new Array([]);
			var arrinstituto = new Array([]);
			var arrpaisotrocur = new Array([]);
			var arraniootrocur = new Array([]);
			for(var i = 1; i <= parseInt(cantotroscursos.value); i++){
				nivelciv = document.getElementById("nivelciv"+i);
				otrocurso = document.getElementById("otrocurso"+i);
				instituto = document.getElementById("instituto"+i);
				paisotrocur = document.getElementById("paisotrocur"+i);
				aniootrocur = document.getElementById("aniootrocur"+i);
				
				if(nivelciv.value !== "" && otrocurso.value !== "" && instituto.value !== "" && paisotrocur.value !== "" && aniootrocur.value !== "") {
					arrnivelciv[i] = nivelciv.value;
					arrotrocurso[i] = otrocurso.value;
					arrinstituto[i] = instituto.value;
					arrpaisotrocur[i] = paisotrocur.value;
					arraniootrocur[i] = aniootrocur.value;
					nivelciv.className = "form-control";
					otrocurso.className = "form-control";
					instituto.className = "form-control";
					paisotrocur.className = "form-control";
					aniootrocur.className = "form-control";
				}else{
					nivelciv.className = "form-danger";
					otrocurso.className = "form-danger";
					instituto.className = "form-danger";
					paisotrocur.className = "form-danger";
					aniootrocur.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de otros cursos, indico '+cantotroscursos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Hijos ////
			var arrnomhijo = new Array([]);
			var arrapehijo = new Array([]);
			var arrpaishijo = new Array([]);
			var arrreligionhijo = new Array([]);
			var arrfecnachijo = new Array([]);
			for(var i = 1; i <= parseInt(canthijos.value); i++){
				nomhijo = document.getElementById("nomhijo"+i);
				apehijo = document.getElementById("apehijo"+i);
				paishijo = document.getElementById("paishijo"+i);
				religionhijo = document.getElementById("religionhijo"+i);
				fecnachijo = document.getElementById("fecnachijo"+i);
				
				if(nomhijo.value !== "" && nomhijo.value !== "" && paishijo.value !== "" && religionhijo.value !== "" && fecnachijo.value !== "") {
					arrnomhijo[i] = nomhijo.value;
					arrapehijo[i] = apehijo.value;
					arrpaishijo[i] = paishijo.value;
					arrreligionhijo[i] = religionhijo.value;
					arrfecnachijo[i] = fecnachijo.value;
					nomhijo.className = "form-control";
					apehijo.className = "form-control";
					paishijo.className = "form-control";
					religionhijo.className = "form-control";
					fecnachijo.className = "form-control";
				}else{
					nomhijo.className = "form-danger";
					apehijo.className = "form-danger";
					paishijo.className = "form-danger";
					religionhijo.className = "form-danger";
					fecnachijo.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de hijos, indico '+canthijos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Hermanos ////
			var arrnomhermano = new Array([]);
			var arrapehermano = new Array([]);
			var arrpaishermano = new Array([]);
			var arrreligionhermano = new Array([]);
			var arrfecnachermano = new Array([]);
			for(var i = 1; i <= parseInt(canthermanos.value); i++){
				nomhermano = document.getElementById("nomhermano"+i);
				apehermano = document.getElementById("apehermano"+i);
				paishermano = document.getElementById("paishermano"+i);
				religionhermano = document.getElementById("religionhermano"+i);
				fecnachermano = document.getElementById("fecnachermano"+i);
				
				if(nomhermano.value !== "" && apehermano.value !== "" && paishermano.value !== "" && religionhermano.value !== "" && fecnachermano.value !== "") {
					arrnomhermano[i] = nomhermano.value;
					arrapehermano[i] = apehermano.value;
					arrpaishermano[i] = paishermano.value;
					arrreligionhermano[i] = religionhermano.value;
					arrfecnachermano[i] = fecnachermano.value;
					nomhermano.className = "form-control";
					apehermano.className = "form-control";
					paishermano.className = "form-control";
					religionhermano.className = "form-control";
					fecnachermano.className = "form-control";
				}else{
					nomhermano.className = "form-danger";
					apehermano.className = "form-danger";
					paishermano.className = "form-danger";
					religionhermano.className = "form-danger";
					fecnachermano.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de hermanos, indico '+canthermanos.value+' a ingresar...', "error");
					return;
				}
			}
			//// Familiares en la Institucion ////
			var arrnomfaminst = new Array([]);
			var arrparenfaminst = new Array([]);
			var arrpuestofaminst = new Array([]);
			var arraniofaminst = new Array([]);
			for(var i = 1; i <= parseInt(cantfaminst.value); i++){
				nomfaminst = document.getElementById("nomfaminst"+i);
				parenfaminst = document.getElementById("parenfaminst"+i);
				puestofaminst = document.getElementById("puestofaminst"+i);
				aniofaminst = document.getElementById("aniofaminst"+i);
				
				if(nomfaminst.value !== "" && parenfaminst.value !== "" && puestofaminst.value !== "" && aniofaminst.value !== "") {
					arrnomfaminst[i] = nomfaminst.value;
					arrparenfaminst[i] = parenfaminst.value;
					arrpuestofaminst[i] = puestofaminst.value;
					arraniofaminst[i] = aniofaminst.value;
					nomfaminst.className = "form-control";
					parenfaminst.className = "form-control";
					puestofaminst.className = "form-control";
					aniofaminst.className = "form-control";
				}else{
					nomfaminst.className = "form-danger";
					parenfaminst.className = "form-danger";
					puestofaminst.className = "form-danger";
					aniofaminst.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de familiares que han trabajado para la institucion, indico '+cantfaminst.value+' filas a ingresar...', "error");
					return;
				}
			}
			//// Referencias Sociales ////
			var arrnomsocial = new Array([]);
			var arrdirsocial = new Array([]);
			var arrtelsocial = new Array([]);
			var arrtrabajosocial = new Array([]);
			var arrcargosocial = new Array([]);
			for(var i = 1; i <= parseInt(cantrefsocial.value); i++){
				nomsocial = document.getElementById("nomsocial"+i);
				dirsocial = document.getElementById("dirsocial"+i);
				telsocial = document.getElementById("telsocial"+i);
				trabajosocial = document.getElementById("trabajosocial"+i);
				cargosocial = document.getElementById("cargosocial"+i);
				
				if(nomsocial.value !== "" && dirsocial.value !== "" && telsocial.value !== "" && trabajosocial.value !== "" && cargosocial.value !== "") {
					arrnomsocial[i] = nomsocial.value;
					arrdirsocial[i] = dirsocial.value;
					arrtelsocial[i] = telsocial.value;
					arrtrabajosocial[i] = trabajosocial.value;
					arrcargosocial[i] = cargosocial.value;
					nomsocial.className = "form-control";
					dirsocial.className = "form-control";
					telsocial.className = "form-control";
					trabajosocial.className = "form-control";
					cargosocial.className = "form-control";
				}else{
					nomsocial.className = "form-danger";
					dirsocial.className = "form-danger";
					telsocial.className = "form-danger";
					trabajosocial.className = "form-danger";
					cargosocial.className = "form-danger";
					swal("Ohoo!", 'Faltan datos del modulo de referencias sociales, indico '+cantrefsocial.value+' a ingresar...', "error");
					return;
				}
			}
				abrir();
				xajax_Modificar_Personal(dpi.value,nom.value,ape.value,nit.value,profesion.value,religion.value,
					pasa.value,igss.value,genero.value,ecivil.value,depn.value,paisn.value,fecnac.value,dir2.value,munde.value,tel2.value,dir1.value,
					mundp.value,tel1.value,sangre.value,alergia.value,cel.value,email.value,emernombre.value,emerapellido.value,emerdirec.value,
					emertel.value,emercel.value,tcamisa.value,tpantalon.value,tchumpa.value,tbotas.value,tgorra.value,
					estatura.value,peso.value,tez.value,ojos.value,nariz.value,tlicv.value,nlicv.value,nlicm.value,deportes.value,empleadoconyugue.value,ingresosconyugue.value,
					trabajoconyugue.value,cargasfam.value,casa.value,costocasa.value,cuentasbanco.value,bancos.value,tarjetascred.value,bancostarjeta.value,
					otrosingresos.value,montootros.value,sueldo.value,descuentos.value,prestamos.value,saldo.value,detenido.value,motivodetenido.value,
					dondedetenido.value,cuandodetenido.value,porquedetenido.value,feclibertad.value,arraigado.value,motivoarraigado.value,dondearraigo.value,
					cuandoarraigo.value,ultimoempleo.value,telultimoempleo.value,dirultimoempleo.value,pueultimoempleo.value,empultimoempleo.value,
					sueldoultimoempleo.value,fecultimoempleo.value,primaria.value,lugprimaria.value,secundaria.value,secuncarrera.value,lugsecundaria.value,
					famnombre2.value,famapellido2.value,fampais2.value,famreligion2.value,famdirec2.value,
					famtel2.value,famcel2.value,famprofe2.value,padrefecnac.value,famnombre3.value,famapellido3.value,fampais3.value,famreligion3.value,
					famdirec3.value,famtel3.value,famcel3.value,famprofe3.value,madrefecnac.value,famnombre4.value,famapellido4.value,fampais4.value,
					famreligion4.value,famdirec4.value,famtel4.value,famcel4.value,famprofe4.value,esposafecnac.value,arrnomhijo,arrapehijo,arrpaishijo,
					arrreligionhijo,arrfecnachijo,arrnomhermano,arrapehermano,arrpaishermano,arrreligionhermano,arrfecnachermano,arrnomfaminst,
					arrparenfaminst,arrpuestofaminst,arraniofaminst,arrtipoveh,arrmarcaveh,arrlineaveh,arrmodeloveh,arrtarjetaveh,arrcolorveh,arrchasisveh,arrmotorveh,
					arrplacasveh,arrpaisveh,arrnivelu,arrtitulo,arrunversidad,arrpaistit,arraniotit,arrsemtit,
					arrgraduadotit,arrnivelciv,arrotrocurso,arrinstituto,arrpaisotrocur,arraniootrocur,arridioma,
					arrhabla,arrlee,arrescribe,arrnomsocial,arrdirsocial,arrtelsocial,arrtrabajosocial,arrcargosocial,cantvehiculos.value,canttitulos.value,
					cantidiomas.value,cantotroscursos.value,canthijos.value,canthermanos.value,cantfaminst.value,cantrefsocial.value);
					
					
		}else{
			//personal
			if(nom.value == ""){
				nom.className = "form-danger";
			}else{
				nom.className = "form-control";
			}
			if(ape.value == ""){
				ape.className = "form-danger";
			}else{
				ape.className = "form-control";
			}
			if(profesion.value == ""){
				profesion.className = "form-danger";
			}else{
				profesion.className = "form-control";
			}
			if(religion.value == ""){
				religion.className = "form-danger";
			}else{
				religion.className = "form-control";
			}
			if(genero.value == ""){
				genero.className = "form-danger";
			}else{
				genero.className = "form-control";
			}
			if(ecivil.value == ""){
				ecivil.className = "form-danger";
			}else{
				ecivil.className = "form-control";
			}
			if(fecnac.value == ""){
				fecnac.className = "form-danger";
			}else{
				fecnac.className = "form-control";
			}
			if(edad.value == ""){
				edad.className = "form-danger";
			}else{
				edad.className = "form-control";
			}
			if(depn.value == ""){
				depn.className = "form-danger";
			}else{
				depn.className = "form-control";
			}
			if(paisn.value == ""){
				paisn.className = "form-danger";
			}else{
				paisn.className = "form-control";
			}
			if(dir1.value == ""){
				dir1.className = "form-danger";
			}else{
				dir1.className = "form-control";
			}
			if(tel1.value == ""){
				tel1.className = "form-danger";
			}else{
				tel1.className = "form-control";
			}
			if(depdp.value == ""){
				depdp.className = "form-danger";
			}else{
				depdp.className = "form-control";
			}
			if(mundp.value == ""){
				mundp.className = "form-danger";
			}else{
				mundp.className = "form-control";
			}
			if(dir2.value == ""){
				dir2.className = "form-danger";
			}else{
				dir2.className = "form-control";
			}
			if(tel2.value == ""){
				tel2.className = "form-danger";
			}else{
				tel2.className = "form-control";
			}
			if(depde.value == ""){
				depde.className = "form-danger";
			}else{
				depde.className = "form-control";
			}
			if(munde.value == ""){
				munde.className = "form-danger";
			}else{
				munde.className = "form-control";
			}
			if(sangre.value == ""){
				sangre.className = "form-danger";
			}else{
				sangre.className = "form-control";
			}
			if(cel.value == ""){
				cel.className = "form-danger";
			}else{
				cel.className = "form-control";
			}
			if(email.value == ""){
				email.className = "form-danger";
			}else{
				email.className = "form-control";
			}
			//documentos
			if(dpi.value == ""){
				dpi.className = "form-danger";
			}else{
				dpi.className = "form-control";
			}
			if(cantvehiculos.value == ""){
				cantvehiculos.className = "form-danger";
			}else{
				cantvehiculos.className = "form-control";
			}
			/*if(cantarmas.value == ""){
				cantarmas.className = "form-danger";
			}else{
				cantarmas.className = "form-control";
			}*/
			//educacion
			if(primaria.value == ""){
				primaria.className = "form-danger";
			}else{
				primaria.className = "form-control";
			}
			if(lugprimaria.value == ""){
				lugprimaria.className = "form-danger";
			}else{
				lugprimaria.className = "form-control";
			}
			if(canttitulos.value == ""){
				canttitulos.className = "form-danger";
			}else{
				canttitulos.className = "form-control";
			}
			if(cantidiomas.value == ""){
				cantidiomas.className = "form-danger";
			}else{
				cantidiomas.className = "form-control";
			}
			if(cantotroscursos.value == ""){
				cantotroscursos.className = "form-danger";
			}else{
				cantotroscursos.className = "form-control";
			}
			//puestofaminst
			if(canthijos.value == ""){
				canthijos.className = "form-danger";
			}else{
				canthijos.className = "form-control";
			}
			if(canthermanos.value == ""){
				canthermanos.className = "form-danger";
			}else{
				canthermanos.className = "form-control";
			}
			if(emergencia.value == ""){
				emergencia.className = "form-danger";
			}else{
				emergencia.className = "form-control";
			}
			if(emerdirec.value == ""){
				emerdirec.className = "form-danger";
			}else{
				emerdirec.className = "form-control";
			}
			if(emernombre.value == ""){
				emernombre.className = "form-danger";
			}else{
				emernombre.className = "form-control";
			}
			if(emerapellido.value == ""){
				emerapellido.className = "form-danger";
			}else{
				emerapellido.className = "form-control";
			}
			if(cantfaminst.value == ""){
				cantfaminst.className = "form-danger";
			}else{
				cantfaminst.className = "form-control";
			}
			//social
			if(cantrefsocial.value == ""){
				cantrefsocial.className = "form-danger";
			}else{
				cantrefsocial.className = "form-control";
			}
			if(deportes.value == ""){
				deportes.className = "form-danger";
			}else{
				deportes.className = "form-control";
			}
			//economica
			if(cargasfam.value == ""){
				cargasfam.className = "form-danger";
			}else{
				cargasfam.className = "form-control";
			}
			if(casa.value == ""){
				casa.className = "form-danger";
			}else{
				casa.className = "form-control";
			}
			if(costocasa.value == ""){
				costocasa.className = "form-danger";
			}else{
				costocasa.className = "form-control";
			}
			if(cuentasbanco.value == ""){
				cuentasbanco.className = "form-danger";
			}else{
				cuentasbanco.className = "form-control";
			}
			if(tarjetascred.value == ""){
				tarjetascred.className = "form-danger";
			}else{
				tarjetascred.className = "form-control";
			}
			if(sueldo.value == ""){
				sueldo.className = "form-danger";
			}else{
				sueldo.className = "form-control";
			}
			if(descuentos.value == ""){
				descuentos.className = "form-danger";
			}else{
				descuentos.className = "form-control";
			}
			if(prestamos.value == ""){
				prestamos.className = "form-danger";
			}else{
				prestamos.className = "form-control";
			}
			//penal
			if(detenido.value == ""){
				detenido.className = "form-danger";
			}else{
				detenido.className = "form-control";
			}
			if(arraigado.value == ""){
				arraigado.className = "form-danger";
			}else{
				arraigado.className = "form-control";
			}
			//somatometrica
			if(tcamisa.value == ""){
				tcamisa.className = "form-danger";
			}else{
				tcamisa.className = "form-control";
			}
			if(tpantalon.value == ""){
				tpantalon.className = "form-danger";
			}else{
				tpantalon.className = "form-control";
			}
			if(tchumpa.value == ""){
				tchumpa.className = "form-danger";
			}else{
				tchumpa.className = "form-control";
			}
			if(tbotas.value == ""){
				tbotas.className = "form-danger";
			}else{
				tbotas.className = "form-control";
			}
			if(tgorra.value == ""){
				tgorra.className = "form-danger";
			}else{
				tgorra.className = "form-control";
			}
			if(estatura.value == ""){
				estatura.className = "form-danger";
			}else{
				estatura.className = "form-control";
			}
			if(peso.value == ""){
				peso.className = "form-danger";
			}else{
				peso.className = "form-control";
			}
			if(tez.value == ""){
				tez.className = "form-danger";
			}else{
				tez.className = "form-control";
			}
			if(ojos.value == ""){
				ojos.className = "form-danger";
			}else{
				ojos.className = "form-control";
			}
			if(nariz.value == ""){
				nariz.className = "form-danger";
			}else{
				nariz.className = "form-control";
			}	
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
	}
	
	
//////----------- UXILIARES -----------------//////////////////
	//calcular la edad de una persona
	//recibe la fecha como un string en formato espa\u00F1ol
	//devuelve un entero con la edad. Devuelve false en caso de que la fecha sea incorrecta o mayor que el dia actual
	function CalculaEdad(fecha,recibe){
		//alert(fecha);
		if(fecha !== ''){
			//calculo la fecha de hoy
			hoy = new Date()
			var array_fecha = fecha.split("/")
			var ano;
			ano = parseInt(array_fecha[2], 10);
			if (isNaN(ano))
				return false;
			var mes;
			mes = parseInt(array_fecha[1], 10);
			if (isNaN(mes))
				return false;
			var dia;
			dia = parseInt(array_fecha[0], 10);
			if (isNaN(dia))
				return false;
			edad = hoy.getFullYear() - ano;
			
			////// NOTA //////////
			// El mes trae un entero menos (ENERO es 0, FEBRERO es 1, MARZO es 2, etc.), hay que sumar +1
			// El dia trae un entero mas (1 es 2, 2 es 3, 3 es 4, etc.), hay que restar -1
			
			if ((hoy.getMonth() + 1 - mes) < 0) {
				edad = parseInt(edad) - 1;
				document.getElementById(recibe).value = edad+" a\u00F1os";
			}
			
			if ((hoy.getMonth() + 1 - mes) >= 0) {
				//alert(hoy.getUTCDate() + "-1 <= "+dia);
				if((hoy.getMonth() + 1 - mes) == 0){
					if((hoy.getUTCDate()) >= dia) {
						document.getElementById(recibe).value = edad+" a\u00F1os";
					}else{
						edad = parseInt(edad) - 1;
						document.getElementById(recibe).value = edad+" a\u00F1os";
					}
				}else{
					document.getElementById(recibe).value = edad+" a\u00F1os";
				}
			}
		
			document.getElementById(recibe).value = edad+" a\u00F1os";
		}else{
			msj="";
			document.getElementById(recibe).value = msj;
		}
		return true;
	}
	
	///////// Fotografia /////////////
	
	function FotoJs(){
		inpfile = document.getElementById("imagen");
		inpfile.click();
	}
	
	
	function Cargar(){
		var msj = '';
		doc = document.getElementById("imagen");
		if(doc.value !== ""){
			exdoc = comprueba_extension(doc.value);
			if(exdoc == 1){
				myform = document.forms.f1;
				myform.submit();
			}else{
				if(exdoc != 1){
					doc.className = "form-danger";
				}else{
					doc.className = "form-control";
				}
				swal("Ohoo!", "Este archivo no es extencion .jpg \u00F3 .png", "error");
			}		
		}else{
			if(doc.value ===""){
				doc.className = "form-danger";
			}else{
				doc.className = "form-control";
			}
			swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
		}
		
		
	}
	
	function comprueba_extension(archivo) {
		//mierror = "";
		if (!archivo) {
		  //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
		  // mierror = "No has seleccionado ningún archivo";
		  alert("No archivo");
		}else{
		  //recupero la extensi\u00F3n de este nombre de archivo
		  extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
		  //alert (extension);
		  //compruebo si la extensi\u00F3n está entre las permitidas
		  permitida = false;
			if (".jpg" == extension || ".jpeg" == extension || ".png" == extension) {
			 permitida = true;
			}
		  if (!permitida) {
			return 0;
		  }else{
			  //todo correcto!
			 return 1;
		  }
		}
		return 0;
	} 
	
