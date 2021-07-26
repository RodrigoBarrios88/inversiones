/* Documento con validaciones numericas y alfabeticas para inputs
desarrollado por el Tte. de Artilleria Manuel Francisco sosa Azurdia
Farasi, Septiembre de 2011 */

//funcion para Numeros Enteros		
		function enterosExtremos(n){
				permitidos=/[^0-9]/;
				cadena = n.value;
				band = false;
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if(permitidos.test(letra)){
						cadena2 = cadena;
						cadena = cadena2.replace(letra,"");
						band = true;
					}
				}
				var cont = 0;
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if(letra === "-"){
						cont++;
						if(cont > 1){
							cadena2 = cadena;
							cadena = cadena2.substring(0,cadena.length-1);
							break;
						}
					}
				}
				if(band === true){
					n.value = cadena;
				}
		}
                

//funcion para Numeros Enteros		
		function enteros(n){
				permitidos=/[^0-9-]/;
				cadena = n.value;
				band = false;
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if(permitidos.test(letra)){
						cadena2 = cadena;
						cadena = cadena2.replace(letra,"");
						band = true;
					}
				}
				var cont = 0;
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if(letra === "-"){
						cont++;
						if(cont > 1){
							cadena2 = cadena;
							cadena = cadena2.substring(0,cadena.length-1);
							break;
						}
					}
				}
				if(band === true){
					n.value = cadena;
				}
		}
                
		
//funcion para Numeros decimales
		function decimales(n){
				permitidos=/[^0-9.-]/;
				cadena = n.value;
				band = false;
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if(permitidos.test(letra)){
						cadena2 = cadena;
						cadena = cadena2.replace(letra,"");
						band = true;
					}
				}
				var cont = 0;
				var cont2 = 0;
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if(letra === "."){
						cont++;
						if(cont > 1){
							cadena2 = cadena;
							cadena = cadena2.substring(0,cadena.length-1);
							break;
						}
					}
					if(letra === "-"){
						cont2++;
						if(cont2 > 1){
							cadena2 = cadena;
							cadena = cadena2.substring(0,cadena.length-1);
							break;
						}
					}
				}
				n.value = cadena;
		}

//funcion para ingreso de hora y minutos		
		function verifTime(n,m){
				permitidos=/[^0-9]/;
				cadena = n.value;
				band = false;
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if(permitidos.test(letra)){
						cadena2 = cadena;
						cadena = cadena2.replace(letra,"");
						band = true;
					}
				}
				n.value = cadena;
				if(band === false){
					if(m === 1){
						if((n.value > 23) || (n.value < 0)){
							msj = '<h5>El Rango numerico permitido para Horas es entre 0 y 12</h5><br><br>';
							msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
							document.getElementById('lblparrafo').innerHTML = msj;
							n.value="";
							abrir();
						}
					}else if(m === 2){
						if((n.value > 59) || (n.value < 0)){
							msj = '<h5>El Rango numerico permitido para Minutos es entre 0 y 59</h5><br><br>';
							msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
							document.getElementById('lblparrafo').innerHTML = msj;
							n.value="";
							abrir();
						}
					}else{
						msj = '<h5>Error de Declaraci&oacute;n en parametros....</h5><br><br>';
						msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
						document.getElementById('lblparrafo').innerHTML = msj;
						n.value="";
						abrir();
					}
				}
		}
		
//funcion para validar caracteres del texto y cantidad maxima de caracteres	
		function texto(n){
			cadena = n.value;
                        band = false;
                        puntoycoma = false;
			max = false;
			if(cadena.length <= 250){
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if((letra === "'") || (letra === '"') || (letra === '`') || (letra === 'à')|| (letra === 'è')|| (letra === 'ì')|| (letra === 'ò')|| (letra === 'ù')|| (letra === 'À')|| (letra === 'È')|| (letra === 'Ì')|| (letra === 'Ò')|| (letra === 'Ù')){
						cadena2 = cadena;
						cadena = cadena2.replace(letra,"");
						band = true;
					}
                                        if(letra === ";"){
                                                cadena2 = cadena;
						cadena = cadena2.replace(letra,". ");
                                                puntoycoma = true;
					}
				}
			}else{
				max = true;
			}
			if(max === false){
				if(band === true){
					abrir();
					msj = '<h5>No se permiten ingresar comillas simples o dobles, ni letras con tildes u otro caracter desconocido...</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					n.value = cadena;
				}
                                if(puntoycoma === true){
					n.value = cadena;
				}
			}else{
				abrir();
				msj = '<h5>El maximo de caracteres en este campo son 250...</h5><br><br>';
				msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				document.getElementById('lblparrafo').innerHTML = msj;
				cadena = cadena.substring(0,(cadena.length-1));
				n.value = cadena;
			}			
		}
                
                function textoLargo(n){
			cadena = n.value;
                        band = false;
                        puntoycoma = false;
			for (i=0;i<cadena.length;i++){
				letra = cadena.substring(i,i + 1);
				if((letra === "'") || (letra === '"') || (letra === '`') || (letra === 'à')|| (letra === 'è')|| (letra === 'ì')|| (letra === 'ò')|| (letra === 'ù')|| (letra === 'À')|| (letra === 'È')|| (letra === 'Ì')|| (letra === 'Ò')|| (letra === 'Ù')){
					cadena2 = cadena;
					cadena = cadena2.replace(letra,"");
					band = true;
				}
                                if(letra === ";"){
                                        cadena2 = cadena;
					cadena = cadena2.replace(letra,". ");
                                        puntoycoma = true;
				}
			}
			if(band === true){
				abrir();
				msj = '<h5>No se permiten ingresar comillas simples o dobles, ni letras con tildes u otro caracter desconocido...</h5><br><br>';
				msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				document.getElementById('lblparrafo').innerHTML = msj;
				n.value = cadena;
			}
                        if(puntoycoma === true){
				n.value = cadena;
			}
		}
		
//funcion para recibir solo letras	
		function letras(n){
				permitidos=/[^a-zA-Z]/;
				cadena = n.value;
				band = false;
				for (i=0;i<cadena.length;i++){
					letra = cadena.substring(i,i + 1);
					if(permitidos.test(letra)){
						cadena2 = cadena;
						cadena = cadena2.replace(letra,"");
						band = true;
					}
				}
				if(band === true){
					n.value = cadena;
				}
		}	
		

		
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////////////// METODOS PROPIOS ////////////////////////////////////////

		function ConfirmacionJs(Texto,Accion){
			msj = "<h5>"+Texto+"</h5><br><br>";
			msj+= '<button type="button" class="btn btn-primary" onclick = "'+Accion+'" ><span class="fa fa-check"></span> Aceptar</button> ';
			msj+= '<button type="button" class="btn btn-default" onclick = "cerrar()" ><span class="fa fa-times"></span> Cancelar</button> ';
			document.getElementById('lblparrafo').innerHTML = msj;
			abrir();
		}
				
		function AlertasJs(Texto,Accion){
			msj = "<h5>"+Texto+"</h5><br><br>";
			msj+= '<button type="button" class="btn btn-primary" onclick = "'+Accion+'" ><span class="fa fa-check"></span> Aceptar</button> ';
			document.getElementById('lblparrafo').innerHTML = msj;
			abrir();
		}
		
		function KeyEnter(inp,Accion){
			inp.onkeypress = function(e){
				if (!e) e = window.event;   // resolve event instance
				if (e.keyCode === '13'){
				  Accion();
				  return;
				}
		    }
		}
		
		function validarEmail(valor) {
			var filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;	
			if(valor.value === '' || valor.value === ' ' || valor.value === '  '){
				return true;
			}else{
				if (filtro.test(valor)){
					return true;
				} else {
					return false;
				}
			}
		}
		
		function MonedaTipoCambio(de,para,cuanto){
			var dato = parseFloat(de) * parseFloat(cuanto);
			    dato = parseFloat(dato)/parseFloat(para);
			    dato = parseFloat(dato) * 100;//-- inicia proceso de redondeo
				dato = Math.round(dato); //javascript redondea solo enteros (hay que multiplicar y dividir por 100 durante el redondeo)
				dato = parseFloat(dato)/100;//-- finaliza proceso de redondeo 
			return dato;
		}
		
		
		function RadioArray(nombre,num,cant){
			for (var i = 1; i <= cant; i++){
				radio = document.getElementById(nombre+i);
				//alert(i);
				if(num === i){
					radio.checked = true;
				}else{
					radio.checked = false;
				}
			}
			return false;
		}
		
		function Agrega_Ceros(dato){
			var len = dato.length ;
			switch(len){
				case 1: dato = "000"+dato; break;
				case 2: dato = "00"+dato; break;
				case 3: dato = "0"+dato; break;
			}
			return dato;
		}
                
                
                function tiene_numeros(texto){
                   var numeros="0123456789";             
                   for(i=0; i<texto.length; i++){
                      if (numeros.indexOf(texto.charAt(i),0)!==-1){
                         return 1;
                      }
                   }
                   return 0;
                }
                
                
                function tiene_letras(texto){
                   var letras="abcdefghyjklmnñopqrstuvwxyz";
                   texto = texto.toLowerCase();
                   for(i=0; i<texto.length; i++){
                      if (letras.indexOf(texto.charAt(i),0)!==-1){
                         return 1;
                      }
                   }
                   return 0;
                }
                
                
                function tiene_minusculas(texto){
                   var letras="abcdefghyjklmnñopqrstuvwxyz";
                   for(i=0; i<texto.length; i++){
                      if (letras.indexOf(texto.charAt(i),0)!==-1){
                         return 1;
                      }
                   }
                   return 0;
                }
                
                
                function tiene_mayusculas(texto){
                   var letras_mayusculas="ABCDEFGHYJKLMNñOPQRSTUVWXYZ";
                   for(i=0; i<texto.length; i++){
                      if (letras_mayusculas.indexOf(texto.charAt(i),0)!==-1){
                         return 1;
                      }
                   }
                   return 0;
                }

//////------ Check's de Listas -----------//////////
			
			function check_lista_multiple(nombre){
				chkbase = document.getElementById(nombre+"base");
				var filas = parseInt(document.getElementById(nombre+"rows").value);
				//alert(inicia+"-"+cuantos);
				if(chkbase.checked) {
					for(var i = 1; i <= filas; i++){
						document.getElementById(nombre+i).checked = true;
					}
				}else{
					for(var i = 1; i <= filas; i++){
						document.getElementById(nombre+i).checked = false;
					}
				}
			}
                
                
///////// VALIDAR INPUT FORMATO FECHA //////////////////////////////     
                function validaFechaDDMMAAAA(cadena){
                       
                       fec = cadena.split("/");
                       bandera = false;
                                dia = fec[0];
                                mes = fec[1];
                                anio = fec[2];
                                //--
                                anio = (isNaN(fec[2]))?0:anio;
                                //alert(dia+"/"+mes+"/"+anio);
                                if (dia !== "" && (parseInt(dia) < 1 || parseInt(dia) > 31 || dia.length > 2)) {
                                    bandera = true;
                                }
                                if (mes !== "" && (parseInt(mes) < 1 || parseInt(mes) > 12 || mes.length > 2)) {
                                    bandera = true;
                                }
                                if (anio !== "" && (parseInt(anio) < 1901 || parseInt(anio) > 2050 || anio.length !== 4)) {
                                    bandera = true;
                                }
                       if (bandera === true) {
                                return false;
                       }else{
                                return true;
                       }
                }
                
                
////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// FORMATOS DE MONEDA /////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////// para valor numerico /////////////////////////////////////////////

Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
   var n = this,
   decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
   decSeparator = decSeparator === undefined ? "." : decSeparator,
   thouSeparator = thouSeparator === undefined ? "" : thouSeparator,
   sign = n < 0 ? "-" : "",
   i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
   j = (j = i.length) > 3 ? j % 3 : 0;
   return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};

// Ejemplo
//var n = 12345;
//alert(n.formatMoney());

/////////////////////////////////////// para valor string /////////////////////////////////////////////

String.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
   var n = this,
   decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
   decSeparator = decSeparator === undefined ? "." : decSeparator,
   thouSeparator = thouSeparator === undefined ? "" : thouSeparator,
   sign = n < 0 ? "-" : "",
   i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
   j = (j = i.length) > 3 ? j % 3 : 0;
   return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};


// Ejemplo
//var n = '12345';
//alert(n.formatMoney());
		