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
								
			function Paso1(){
				abrir();
				cui = document.getElementById('cui');
				edadcolegio = document.getElementById('edadcolegio');
				//-- se adapto
				var adaptado = "";
				var adaptadosi = document.getElementById("adaptadosi");
				var adaptadono = document.getElementById("adaptadono");
				if(adaptadosi.checked){
					adaptado = 1;
				}else if(adaptadono.checked){
					adaptado = 0;
				}else{
					adaptado = "";
				}
				//--
				//-- es repitente
				var repitente = "";
				var repitentesi = document.getElementById("repitentesi");
				var repitenteno = document.getElementById("repitenteno");
				if(repitentesi.checked){
					repitente = 1;
				}else if(repitenteno.checked){
					repitente = 0;
				}else{
					repitente = "";
				}
				//--
				repitegrado = document.getElementById('repitegrado');
				colegiosanteriores = document.getElementById("colegiosanteriores");
				retiradopor = document.getElementById("retiradopor");
				porqueeste = document.getElementById("porqueeste");
				//-- tiene hermanos aqui
				var hermanosaqui = "";
				var hermanosaquisi = document.getElementById("hermanosaquisi");
				var hermanosaquino = document.getElementById("hermanosaquino");
				if(hermanosaquisi.checked){
					hermanosaqui = 1;
				}else if(hermanosaquino.checked){
					hermanosaqui = 0;
				}else{
					hermanosaqui = "";
				}
				//--
				estudiaronaqui = document.getElementById("estudiaronaqui");
				hermanos = document.getElementById("hermanos");
				lugarhermanos = document.getElementById("lugarhermanos");
				vivecon = document.getElementById("vivecon");
				
				if(edadcolegio.value !== "" && porqueeste.value !== "" && hermanos.value !== "" && lugarhermanos.value !== "" && vivecon.value !== ""){
					xajax_Paso1(cui.value,edadcolegio.value,adaptado,repitente,repitegrado.value,colegiosanteriores.value,retiradopor.value,porqueeste.value,hermanosaqui,estudiaronaqui.value,hermanos.value,lugarhermanos.value,vivecon.value);
				}else{
					if(edadcolegio.value ===""){
						edadcolegio.className = "form-danger";
					}else{
						edadcolegio.className = "form-control";
					}
					if(porqueeste.value ===""){
						porqueeste.className = "form-danger";
					}else{
						porqueeste.className = "form-control";
					}
					if(hermanos.value ===""){
						hermanos.className = "form-danger";
					}else{
						hermanos.className = "form-control";
					}
					if(lugarhermanos.value ===""){
						lugarhermanos.className = "form-danger";
					}else{
						lugarhermanos.className = "form-control";
					}
					if(vivecon.value ===""){
						vivecon.className = "form-danger";
					}else{
						vivecon.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Paso2(){
				abrir();
				cui = document.getElementById('cui');
				//-- fue planificado
				var planificado = "";
				var planificadosi = document.getElementById("planificadosi");
				var planificadono = document.getElementById("planificadono");
				if(planificadosi.checked){
					planificado = 1;
				}else if(planificadono.checked){
					planificado = 0;
				}else{
					planificado = "";
				}
				//--
				duracion = document.getElementById('duracion');
				//-- tuvo complicaciones
				var complicaciones = "";
				var complicacionessi = document.getElementById("complicacionessi");
				var complicacionesno = document.getElementById("complicacionesno");
				if(complicacionessi.checked){
					complicaciones = 1;
				}else if(complicacionesno.checked){
					complicaciones = 0;
				}else{
					complicaciones = "";
				}
				//--
                tipocomplicaciones = document.getElementById('tipocomplicaciones');
				//-- le sacaron rayos x
				var rayosx = "";
				var rayosxsi = document.getElementById("rayosxsi");
				var rayosxno = document.getElementById("rayosxno");
				if(rayosxsi.checked){
					rayosx = 1;
				}else if(rayosxno.checked){
					rayosx = 0;
				}else{
					rayosx = "";
				}
				//--
                //-- le sacaron rayos x
				var depresion = "";
				var depresionsi = document.getElementById("depresionsi");
				var depresionno = document.getElementById("depresionno");
				if(depresionsi.checked){
					depresion = 1;
				}else if(depresionno.checked){
					depresion = 0;
				}else{
					depresion = "";
				}
				//--
				otros = document.getElementById("otros");
				
				if(duracion.value !== ""){
					xajax_Paso2(cui.value,planificado,duracion.value,complicaciones,tipocomplicaciones.value,rayosx,depresion,otros.value);
				}else{
					if(duracion.value ===""){
						duracion.className = "form-danger";
					}else{
						duracion.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Paso3(){
				abrir();
				cui = document.getElementById('cui');
				tipo = document.getElementById('tipo');
				//-- uso anestesia     
				var anestesia = "";
				var anestesiasi = document.getElementById("anestesiasi");
				var anestesiano = document.getElementById("anestesiano");
				if(anestesiasi.checked){
					anestesia = 1;
				}else if(anestesiano.checked){
					anestesia = 0;
				}else{
					anestesia = "";
				}
				//--
				//-- fue inducido
				var inducido = "";
				var inducidosi = document.getElementById("inducidosi");
				var inducidono = document.getElementById("inducidono");
				if(inducidosi.checked){
					inducido = 1;
				}else if(inducidono.checked){
					inducido = 0;
				}else{
					inducido = "";
				}
				//-- usaron forceps
				var forceps = "";
				var forcepssi = document.getElementById("forcepssi");
				var forcepsno = document.getElementById("forcepsno");
				if(forcepssi.checked){
					forceps = 1;
				}else if(forcepsno.checked){
					forceps = 0;
				}else{
					forceps = "";
				}
				//--
                otro = document.getElementById("otro");
				
				if(tipo.value !== ""){
					xajax_Paso3(cui.value,tipo.value,anestesia,inducido,forceps,otro.value);
				}else{
					if(tipo.value ===""){
						tipo.className = "form-danger";
					}else{
						tipo.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Paso4(){
				abrir();
				cui = document.getElementById('cui');
				//-- tomo pecho     
				var pecho = "";
				var pechosi = document.getElementById("pechosi");
				var pechono = document.getElementById("pechono");
				if(pechosi.checked){
					pecho = 1;
				}else if(pechono.checked){
					pecho = 0;
				}else{
					pecho = "";
				}
				//--
				//-- tomo pacha    
				var pacha = "";
				var pachasi = document.getElementById("pachasi");
				var pachano = document.getElementById("pachano");
				if(pachasi.checked){
					pacha = 1;
				}else if(pachano.checked){
					pacha = 0;
				}else{
					pacha = "";
				}
				//-- vomitos
				var vomitos = "";
				var vomitossi = document.getElementById("vomitossi");
				var vomitosno = document.getElementById("vomitosno");
				if(vomitossi.checked){
					vomitos = 1;
				}else if(vomitosno.checked){
					vomitos = 0;
				}else{
					vomitos = "";
				}
				//--
                //-- colicos
				var colicos = "";
				var colicossi = document.getElementById("colicossi");
				var colicosno = document.getElementById("colicosno");
				if(colicossi.checked){
					colicos = 1;
				}else if(colicosno.checked){
					colicos = 0;
				}else{
					colicos = "";
				}
				//--
				
				if(cui.value !== ""){
					xajax_Paso4(cui.value,pecho,pacha,vomitos,colicos);
				}else{
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Paso5(){
				abrir();
				cui = document.getElementById('cui');
				cabeza = document.getElementById('cabeza');
				sento = document.getElementById('sento');
				camino = document.getElementById('camino');
				//-- gateo     
				var gateo = "";
				var gateosi = document.getElementById("gateosi");
				var gateono = document.getElementById("gateono");
				if(gateosi.checked){
					gateo = 1;
				}else if(gateono.checked){
					gateo = 0;
				}else{
					gateo = "";
				}
				//--
				//-- balanceo
				var balanceo = "";
				var balanceosi = document.getElementById("balanceosi");
				var balanceono = document.getElementById("balanceono");
				if(balanceosi.checked){
					balanceo = 1;
				}else if(balanceono.checked){
					balanceo = 0;
				}else{
					balanceo = "";
				}
				//-- babeo
				var babeo = "";
				var babeosi = document.getElementById("babeosi");
				var babeono = document.getElementById("babeono");
				if(babeosi.checked){
					babeo = 1;
				}else if(babeono.checked){
					babeo = 0;
				}else{
					babeo = "";
				}
				//--
                if(cabeza.value !== "" && sento.value !== "" && camino.value !== ""){
					xajax_Paso5(cui.value,cabeza.value,sento.value,camino.value,gateo,balanceo,babeo);
				}else{
					if(cabeza.value ===""){
						cabeza.className = "form-danger";
					}else{
						cabeza.className = "form-control";
					}
					if(sento.value ===""){
						sento.className = "form-danger";
					}else{
						sento.className = "form-control";
					}
					if(camino.value ===""){
						camino.className = "form-danger";
					}else{
						camino.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Paso6(){
				abrir();
				cui = document.getElementById('cui');
				dientes = document.getElementById('dientes');
				balbuceo = document.getElementById('balbuceo');
				palabras = document.getElementById('palabras');
                oraciones = document.getElementById('oraciones');
				//-- articula     
				var articula = "";
				var articulasi = document.getElementById("articulasi");
				var articulano = document.getElementById("articulano");
				if(articulasi.checked){
					articula = 1;
				}else if(articulano.checked){
					articula = 0;
				}else{
					articula = "";
				}
				//--
				//-- entiende
				var entiende = "";
				var entiendesi = document.getElementById("entiendesi");
				var entiendeno = document.getElementById("entiendeno");
				if(entiendesi.checked){
					entiende = 1;
				}else if(entiendeno.checked){
					entiende = 0;
				}else{
					entiende = "";
				}
				//--
                if(dientes.value !== "" && balbuceo.value !== "" && palabras.value !== "" && oraciones.value !== ""){
					xajax_Paso6(cui.value,dientes.value,balbuceo.value,palabras.value,oraciones.value,articula,entiende);
				}else{
					if(dientes.value ===""){
						dientes.className = "form-danger";
					}else{
						dientes.className = "form-control";
					}
					if(balbuceo.value ===""){
						balbuceo.className = "form-danger";
					}else{
						balbuceo.className = "form-control";
					}
					if(palabras.value ===""){
						palabras.className = "form-danger";
					}else{
						palabras.className = "form-control";
					}
					if(oraciones.value ===""){
						oraciones.className = "form-danger";
					}else{
						oraciones.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Paso7(){
				abrir();
				cui = document.getElementById('cui');
				//-- duerme     
				var duerme = "";
				var duermesi = document.getElementById("duermesi");
				var duermeno = document.getElementById("duermeno");
				if(duermesi.checked){
					duerme = 1;
				}else if(duermeno.checked){
					duerme = 0;
				}else{
					duerme = "";
				}
				//--
				//-- despierta
				var despierta = "";
				var despiertasi = document.getElementById("despiertasi");
				var despiertano = document.getElementById("despiertano");
				if(despiertasi.checked){
					despierta = 1;
				}else if(despiertano.checked){
					despierta = 0;
				}else{
					despierta = "";
				}
				//-- terror
				var terror = "";
				var terrorsi = document.getElementById("terrorsi");
				var terrorno = document.getElementById("terrorno");
				if(terrorsi.checked){
					terror = 1;
				}else if(terrorno.checked){
					terror = 0;
				}else{
					terror = "";
				}
				//-- insomnio     
				var insomnio = "";
				var insomniosi = document.getElementById("insomniosi");
				var insomniono = document.getElementById("insomniono");
				if(insomniosi.checked){
					insomnio = 1;
				}else if(insomniono.checked){
					insomnio = 0;
				}else{
					insomnio = "";
				}
				//--
				//-- crujido
				var crujido = "";
				var crujidosi = document.getElementById("crujidosi");
				var crujidono = document.getElementById("crujidono");
				if(crujidosi.checked){
					crujido = 1;
				}else if(crujidono.checked){
					crujido = 0;
				}else{
					crujido = "";
				}
				//--
                horas = document.getElementById('horas');
				duermecon = document.getElementById('duermecon');
				if(horas.value !== "" && duermecon.value !== ""){
					xajax_Paso7(cui.value,duerme,despierta,terror,insomnio,crujido,horas.value,duermecon.value);
				}else{
					if(horas.value ===""){
						horas.className = "form-danger";
					}else{
						horas.className = "form-control";
					}
					if(duermecon.value ===""){
						duermecon.className = "form-danger";
					}else{
						duermecon.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Paso8(){
				abrir();
				cui = document.getElementById('cui');
				//-- solo     
				var solo = "";
				var solosi = document.getElementById("solosi");
				var solono = document.getElementById("solono");
				if(solosi.checked){
					solo = 1;
				}else if(solono.checked){
					solo = 0;
				}else{
					solo = "";
				}
				//--
				//-- exceso
				var exceso = "";
				var excesosi = document.getElementById("excesosi");
				var excesono = document.getElementById("excesono");
				if(excesosi.checked){
					exceso = 1;
				}else if(excesono.checked){
					exceso = 0;
				}else{
					exceso = "";
				}
				//-- poco
				var poco = "";
				var pocosi = document.getElementById("pocosi");
				var pocono = document.getElementById("pocono");
				if(pocosi.checked){
					poco = 1;
				}else if(pocono.checked){
					poco = 0;
				}else{
					poco = "";
				}
				//-- obligado     
				var obligado = "";
				var obligadosi = document.getElementById("obligadosi");
				var obligadono = document.getElementById("obligadono");
				if(obligadosi.checked){
					obligado = 1;
				}else if(obligadono.checked){
					obligado = 0;
				}else{
					obligado = "";
				}
				//--
				//-- habitos
				var habitos = "";
				var habitossi = document.getElementById("habitossi");
				var habitosno = document.getElementById("habitosno");
				if(habitossi.checked){
					habitos = 1;
				}else if(habitosno.checked){
					habitos = 0;
				}else{
					habitos = "";
				}
				//--
                talla = document.getElementById('talla');
				peso = document.getElementById('peso');
				if(talla.value !== "" && peso.value !== ""){
					xajax_Paso8(cui.value,solo,exceso,poco,obligado,habitos,talla.value,peso.value);
				}else{
					if(talla.value ===""){
						talla.className = "form-danger";
					}else{
						talla.className = "form-control";
					}
					if(peso.value ===""){
						peso.className = "form-danger";
					}else{
						peso.className = "form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Paso9(){
				abrir();
				cui = document.getElementById('cui');
				//-- lentes
				var lentes = "";
				var lentessi = document.getElementById("lentessi");
				var lentesno = document.getElementById("lentesno");
				if(lentessi.checked){
					lentes = 1;
				}else if(lentesno.checked){
					lentes = 0;
				}else{
					lentes = "";
				}
				//--
				uso = document.getElementById('uso');
				//-- irritacion
				var irritacion = "";
				var irritacionsi = document.getElementById("irritacionsi");
				var irritacionno = document.getElementById("irritacionno");
				if(irritacionsi.checked){
					irritacion = 1;
				}else if(irritacionno.checked){
					irritacion = 0;
				}else{
					irritacion = "";
				}
				//-- secrecion
				var secrecion = "";
				var secrecionsi = document.getElementById("secrecionsi");
				var secrecionno = document.getElementById("secrecionno");
				if(secrecionsi.checked){
					secrecion = 1;
				}else if(secrecionno.checked){
					secrecion = 0;
				}else{
					secrecion = "";
				}
				//--
                //-- acerca
				var acerca = "";
				var acercasi = document.getElementById("acercasi");
				var acercano = document.getElementById("acercano");
				if(acercasi.checked){
					acerca = 1;
				}else if(acercano.checked){
					acerca = 0;
				}else{
					acerca = "";
				}
				//-- dolor
				var dolor = "";
				var dolorsi = document.getElementById("dolorsi");
				var dolorno = document.getElementById("dolorno");
				if(dolorsi.checked){
					dolor = 1;
				}else if(dolorno.checked){
					dolor = 0;
				}else{
					dolor = "";
				}
				//-- desviacion
				var desviacion = "";
				var desviacionsi = document.getElementById("desviacionsi");
				var desviacionno = document.getElementById("desviacionno");
				if(desviacionsi.checked){
					desviacion = 1;
				}else if(desviacionno.checked){
					desviacion = 0;
				}else{
					desviacion = "";
				}
				//--
				otro = document.getElementById("otro");
				
				if(cui.value !== ""){
					xajax_Paso9(cui.value,lentes,uso.value,irritacion,secrecion,acerca,dolor,desviacion,otro.value);
				}else{
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Paso10(){
				abrir();
				cui = document.getElementById('cui');
				//-- afecciones
				var afecciones = "";
				var afeccionessi = document.getElementById("afeccionessi");
				var afeccionesno = document.getElementById("afeccionesno");
				if(afeccionessi.checked){
					afecciones = 1;
				}else if(afeccionesno.checked){
					afecciones = 0;
				}else{
					afecciones = "";
				}
				//--
				cuales = document.getElementById('cuales');
				//-- esfuerzo
				var esfuerzo = "";
				var esfuerzosi = document.getElementById("esfuerzosi");
				var esfuerzono = document.getElementById("esfuerzono");
				if(esfuerzosi.checked){
					esfuerzo = 1;
				}else if(esfuerzono.checked){
					esfuerzo = 0;
				}else{
					esfuerzo = "";
				}
				//-- responde
				var responde = "";
				var respondesi = document.getElementById("respondesi");
				var respondeno = document.getElementById("respondeno");
				if(respondesi.checked){
					responde = 1;
				}else if(respondeno.checked){
					responde = 0;
				}else{
					responde = "";
				}
				//--
                //-- escucha
				var escucha = "";
				var escuchasi = document.getElementById("escuchasi");
				var escuchano = document.getElementById("escuchano");
				if(escuchasi.checked){
					escucha = 1;
				}else if(escuchano.checked){
					escucha = 0;
				}else{
					escucha = "";
				}
				
				if(cui.value !== ""){
					xajax_Paso10(cui.value,afecciones,cuales.value,esfuerzo,responde,escucha);
				}else{
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick="cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Paso11(){
				abrir();
				cant = parseInt(document.getElementById('total').value);
				var C = 1;
				if(cant > 0){
					var arrconduct = Array([]);
					for (var i = 1; i <= cant; i++){
						chk = document.getElementById('chk'+i);
						if(chk.checked){
							conduct = document.getElementById('chk'+i).value;
							arrconduct[C] = conduct;
							C++;
						}
					}
					C--;//le quita la ultima vuelta al contador...
					if(C > 0){
						xajax_Paso11(cui.value,arrconduct,C);
					}else{
						msj = '<h5>Seleccione al menos un caracter...</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
					}
				}else{
					msj = '<h5>No hay caracteres listados...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
				}	
			}