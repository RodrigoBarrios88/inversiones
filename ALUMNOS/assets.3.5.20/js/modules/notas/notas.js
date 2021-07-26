	/////////////// COMENTARIOS //////////////
	
	function promtComentario(cui,pensum,nivel,grado,materia,unidad){
		//Realiza una peticion de contenido a la contenido.php
		$.post("../promts/notas/comentarios_notas.php",{cui:cui,pensum:pensum,nivel:nivel,grado:grado,materia:materia,unidad:unidad}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
		});
		abrirModal();
	}
	
	
	function Tarjeta_Notas_Individual(alumno,pensum,nivel,grado,seccion,unidad,button){
	    console.log(alumno,pensum,nivel,grado,seccion,unidad,button);
		////---- Form 1 -----///
		tipo = '3';
		parcial = unidad;
		font = '6';
		anchocols = '18';
		papel = "Letter";
		orientacion = "P";
		titulo = "BOLETA DE RENDIMIENTO ACAD脡MICO";
		notaminima = '65';
		caraA = '1';
		caraB = '1';
        ///--- Form2 ---///
		pensum2 = document.getElementById('pensum2');
		nivel2 = document.getElementById('nivel2');
		grado2 = document.getElementById("grado2");
		seccion2 = document.getElementById("seccion2");
		tipo2 = document.getElementById("tipo2");
		parcial2 = document.getElementById("parcial2");
		font2 = document.getElementById("font2");
		anchocols2 = document.getElementById("anchocols2");
		papel2 = document.getElementById("papel2");
		orientacion2 = document.getElementById("orientacion2");
		titulo2 = document.getElementById("titulo2");
		notaminima2 = document.getElementById("notaminima2");
		caraA2 = document.getElementById("caraA2");
		caraB2 = document.getElementById("caraB2");
		alumno2 = document.getElementById("cui2");
		///---- Entrega de datos ---//////
		cui2.value = alumno;
		pensum2.value = pensum;
		nivel2.value = nivel;
		grado2.value = grado;
		seccion2.value = seccion;
		tipo2.value = tipo;
		parcial2.value = parcial;
		font2.value = font;
		anchocols2.value = anchocols;
		papel2.value = papel;
		orientacion2.value = orientacion;
		titulo2.value = titulo;
		notaminima2.value = notaminima;
		caraA2.value = caraA;
		caraB2.value = caraB;
		//alert(tipo.value);
        console.log(alumno2,pensum2,nivel2,grado2,seccion2,titulo2,parcial);
		if(pensum !=="" && nivel !=="" && grado !=="" && tipo !==""){
		    myform = document.forms.f2;
			myform.target ="_blank";
			if(tipo == '1') {
				if(parcial !==""){
					switch(button){
						case 1: myform.action ="../../CONFIG/NOTAS/REPtarjeta_notas_parciales.php"; break;
						case 2: myform.action ="../../CONFIG/NOTAS/EXCELtarjeta_notas_parciales.php"; break;
						case 3: myform.action ="FRMtarjeta_notas_parciales.php"; break;
					}
				}else{
					cerrar();
					parcial.className = "form-warning";
					swal("Ohoo!", "Seleccione la Unidad a listar...", "warning");
					return; //sale de la funcion
				}
			}else if (tipo == '3') {
				switch(button){
					case 1: myform.action ="../../CONFIG/NOTAS/REPtarjeta_notas_finales.php"; break;
					case 2: myform.action ="../../CONFIG/NOTAS/EXCELtarjeta_notas_finales.php"; break;
					case 3: myform.action ="FRMtarjeta_notas_finales.php"; break;
				}
			}
			abrir();
			myform.submit();
			myform.action ="";
			myform.target ="";
			cerrar();
		}

	}

	