//funciones javascript y validaciones
    
    function EDITAR(codigo,tipoclase,codprimario){
        if(tipoclase == "1" ){
            swal({
                title: "Editar",
                text: "Esta videoclase pertenece a un programacion recurrente desea editar toda la Programacion?",
                icon: "info",
                buttons: {
                    cancel: "cancerlar",
                    ok2: { text: "Todo", value: false,},
                    ok: { text: "Solo esta", value: true,},
                }
            }).then((value) => {
                switch (value) {
                    case true:
                        xajax_Buscar_Videoclase(codigo);
                        break;
                    case false:
                        xajax_Buscar_Videoclase_recurrente(codigo,codprimario);
                        break;
                    default:
                        
                      return;
                }
            });
        }else{
            xajax_Buscar_Videoclase(codigo);
        }
    }
    
    function ELIMINAR(codigo,tipoclase,codprimario){
        if(tipoclase == "1" ){
            swal({
                title: "Cancelar Videoclase",
                text: "Esta videoclase pertenece a un programacion recurrente desea cancelar toda la Programacion?",
                icon: "info",
                buttons: {
                    cancel: "Todo",
                    ok: { text: "Solo esta", value: true,},
                }
            }).then((value) => {
                switch (value) {
                    case true:
                        xajax_Situacion_Videoclase(codigo);
                        break;
                    default:
                        abrir();
                        xajax_Situacion_Videoclase_recurrente(codigo,codprimario);
                      return;
                }
            });
        }else{
            xajax_Situacion_Videoclase(codigo);
        }
    }    
        
    function Limpiar(){
        swal({
            title: "Limpiar Pantalla",
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
                        
    function TipoTarget(){
        target = document.getElementById('target');
        tipo = document.getElementById('tipotarget');
        
        if(target.value === "SELECT"){
            tipo.removeAttribute("disabled");
            if(target.value !== "" && tipo.value !== ""){
                xajax_Target_Grupos(target.value,tipo.value);
            }
        }else{
            tipo.value = "0";
            tipo.setAttribute("disabled","disabled");
            xajax_Target_Grupos(target.value,tipo.value);
        }
    }
    
    function plataforma(valor){
        link = document.getElementById("link");
        if(valor === "ASMS Videoclass"){
            link.setAttribute("disabled","disabled");
        }else{
            link.removeAttribute("disabled");
        }
    }

    function tipoclase(valor){
        tipo = document.getElementById("simpleini");
        tipo2 = document.getElementById("simplefin");
        dias = document.getElementById("dia");
        if(valor == "1"){
            tipo.className = "hidden";
            tipo2.className = "hidden";
            dia.className = "";
        }else{
            tipo.className="";
            tipo2.className="";
            dia.className = "hidden";
        }
    }    
    
    function Grabar(){
        target = document.getElementById('target');
        tipo = document.getElementById('tipotarget');
        nombre = document.getElementById('nombre');
        descripcion = document.getElementById("descripcion");
        plataforma = document.getElementById("plataforma");
        link = document.getElementById("link");
        fecini = document.getElementById('fecini');
        horini = document.getElementById('horini');
        fecfin = document.getElementById('fecfin');
        horfin = document.getElementById('horfin');
        tipoclass = document.getElementById('tipoclase');
        dias = document.getElementById('dias');
        if(tipoclass.value !== "1"){
            if(target.value !=="" && nombre.value !=="" && descripcion.value !== "" && fecini.value !== "" && horini.value !== "" && fecfin.value !== "" && horfin.value !== "" && plataforma.value !== ""){
            if (target.value !== "TODOS") {
                    var filas = parseInt(document.getElementById('gruposrows').value);
                    var arrgrupo = Array([]);
                    var cuantos = 0;
                    //alert(filas);
                    for(i = 1; i <= filas; i++){
                        chk = document.getElementById("grupos"+i);
                        if(chk.checked) {
                            arrgrupo[cuantos] = chk.value;
                            cuantos++;
                        }
                    }
                    if(cuantos > 0) {
                        abrir();
                        xajax_Grabar_Videoclase(nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,arrgrupo,cuantos,tipoclass.value,dias.value);
                    }else{
                        swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
                    }
            }else{
                abrir();
                var arrgrupo = Array([]);
                var cuantos = 0;
                var dias =0;
               // console.log( nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,arrgrupo,cuantos,tipoclass.value,dias);
                        xajax_Grabar_Videoclase(nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,arrgrupo,cuantos,tipoclass.value,dias.value);
            }
        }else{
            if(target.value ===""){
                target.className = "form-danger";
            }else{
                target.className = "form-control";
            }
            if(nombre.value ===""){
                nombre.className = "form-danger";
            }else{
                nombre.className = "form-control";
            }
            if(descripcion.value ===""){
                descripcion.className = "form-danger";
            }else{
                descripcion.className = "form-control";
            }
            if(fecini.value ===""){
                fecini.className = "form-danger";
            }else{
                fecini.className = "form-control";
            }
            if(horini.value ===""){
                horini.className = "form-danger";
            }else{
                horini.className = "form-control";
            }
            if(fecfin.value ===""){
                fecfin.className = "form-danger";
            }else{
                fecfin.className = "form-control";
            }
            if(horfin.value ===""){
                horfin.className = "form-danger";
            }else{
                horfin.className = "form-control";
            }
            if(plataforma.value ===""){
                plataforma.className = "form-danger";
            }else{
                plataforma.className = "form-control";
            }
            if(link.value ===""){
                link.className = "form-danger";
            }else{
                link.className = "form-control";
            }
            swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
        }    
        }else{
        
        if(target.value !=="" && nombre.value !=="" && descripcion.value !== ""  && horini.value !== ""  && horfin.value !== "" && plataforma.value !== ""&& dias.value !== ""){
            if (target.value === "SELECT") {
                    var filas = parseInt(document.getElementById('gruposrows').value);
                    var arrgrupo = Array([]);
                    var cuantos = 0;
                    //alert(filas);
                    for(i = 1; i <= filas; i++){
                        chk = document.getElementById("grupos"+i);
                        if(chk.checked) {
                            arrgrupo[cuantos] = chk.value;
                            cuantos++;
                        }
                    }
                    if(cuantos > 0) {
                        abrir();
                        xajax_Grabar_Videoclase(nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,arrgrupo,cuantos,tipoclass.value,dias.value);
                    }else{
                        swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
                    }
            }else{
                abrir();
                var arrgrupo = Array([]);
                var cuantos = 0;
                console.log( nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,arrgrupo,cuantos,dias.value );
                xajax_Grabar_Videoclase(nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,arrgrupo,cuantos,tipoclass.value,dias.value);
            }
        }else{
            if(target.value ===""){
                target.className = "form-danger";
            }else{
                target.className = "form-control";
            }
            if(dias.value ===""){
                dias.className = "form-danger";
            }else{
                dias.className = "form-control";
            }
            if(nombre.value ===""){
                nombre.className = "form-danger";
            }else{
                nombre.className = "form-control";
            }
            if(descripcion.value ===""){
                descripcion.className = "form-danger";
            }else{
                descripcion.className = "form-control";
            }
            if(horini.value ===""){
                horini.className = "form-danger";
            }else{
                horini.className = "form-control";
            }
            if(horfin.value ===""){
                horfin.className = "form-danger";
            }else{
                horfin.className = "form-control";
            }
            if(plataforma.value ===""){
                plataforma.className = "form-danger";
            }else{
                plataforma.className = "form-control";
            }
            if(link.value ===""){
                link.className = "form-danger";
            }else{
                link.className = "form-control";
            }
            swal("Ohoo!", "Debe llenar los Campos Obligatorios... sdfasfasfa", "error");
        }
        }
    }
    
    function Modificar(){
        codigo = document.getElementById('codigo');
        target = document.getElementById('target');
        tipo = document.getElementById('tipotarget');
        nombre = document.getElementById('nombre');
        descripcion = document.getElementById("descripcion");
        plataforma = document.getElementById("plataforma");
        link = document.getElementById("link");
        fecini = document.getElementById('fecini');
        horini = document.getElementById('horini');
        fecfin = document.getElementById('fecfin');
        horfin = document.getElementById('horfin');
        tipoclass = document.getElementById('tipoclase');
        dias = document.getElementById('dias');
        recurrente = document.getElementById('recurrente');
        //--
        evento = document.getElementById("evento");
        schedule = document.getElementById("schedule");
        partnerId = document.getElementById("partnerId");
     
            if(codigo.value !==""){
                if(target.value !=="" && nombre.value !=="" && descripcion.value !== "" && fecini.value !== "" && horini.value !== "" && fecfin.value !== "" && horfin.value !== "" && plataforma.value !== ""){
                    if (target.value === "SELECT") {
                        var filas = parseInt(document.getElementById('gruposrows').value);
                        var arrgrupo = Array([]);
                        var cuantos = 0;
                        //alert(filas);
                        for(i = 1; i <= filas; i++){
                            chk = document.getElementById("grupos"+i);
                            if(chk.checked) {
                                arrgrupo[cuantos] = chk.value;
                                cuantos++;
                            }
                        }
                        if(cuantos > 0) {
                            abrir();
                            xajax_Modificar_Videoclase(codigo.value,nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,evento.value,schedule.value,partnerId.value,arrgrupo,cuantos);
                        }else{
                            swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
                        }
                    }else{
                        abrir();
                        var arrgrupo = Array([]);
                        var cuantos = 0;
                        xajax_Modificar_Videoclase(codigo.value,nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,evento.value,schedule.value,partnerId.value,arrgrupo,cuantos);
                        console.log(codigo.value,nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,evento.value,schedule.value,partnerId.value,arrgrupo,cuantos);
                    }
                }else{
                    if(target.value ===""){
                        target.className = "form-danger";
                    }else{
                        target.className = "form-control";
                    }
                    if(nombre.value ===""){
                        nombre.className = "form-danger";
                    }else{
                        nombre.className = "form-control";
                    }
                    if(descripcion.value ===""){
                        descripcion.className = "form-danger";
                    }else{
                        descripcion.className = "form-control";
                    }
                    if(fecini.value ===""){
                        fecini.className = "form-danger";
                    }else{
                        fecini.className = "form-control";
                    }
                    if(horini.value ===""){
                        horini.className = "form-danger";
                    }else{
                        horini.className = "form-control";
                    }
                    if(fecfin.value ===""){
                        fecfin.className = "form-danger";
                    }else{
                        fecfin.className = "form-control";
                    }
                    if(horfin.value ===""){
                        horfin.className = "form-danger";
                    }else{
                        horfin.className = "form-control";
                    }
                    if(plataforma.value ===""){
                        plataforma.className = "form-danger";
                    }else{
                        plataforma.className = "form-control";
                    }
                    if(link.value ===""){
                        link.className = "form-danger";
                    }else{
                        link.className = "form-control";
                    }
                    swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
                }
            }else{
                swal("Ohoo!", "Si quiere crear una actividad nueva esta en la pantalla equivocada, aqu\u00ED solo puede actualizar las existentes.\nPara editar, seleccione la actividad que quiere modificar y realice los cambios...", "error");
            }
    }
    
    function Modificar_recurrente(){
        codigo = document.getElementById('codigo');
        target = document.getElementById('target');
        tipo = document.getElementById('tipotarget');
        nombre = document.getElementById('nombre');
        descripcion = document.getElementById("descripcion");
        plataforma = document.getElementById("plataforma");
        link = document.getElementById("link");
        fecini = document.getElementById('fecini');
        horini = document.getElementById('horini');
        fecfin = document.getElementById('fecfin');
        horfin = document.getElementById('horfin');
        tipoclass = document.getElementById('tipoclase');
        dias = document.getElementById('dias');
        recurrente = document.getElementById('recurrente');
        //--
        evento = document.getElementById("evento");
        schedule = document.getElementById("schedule");
        partnerId = document.getElementById("partnerId");

        if(codigo.value !==""){
            if(target.value !=="" && nombre.value !=="" && descripcion.value !== "" && fecini.value !== "" && horini.value !== "" && fecfin.value !== "" && horfin.value !== "" && plataforma.value !== "" && dias.value !== ""){
                if (target.value === "SELECT") {
                    var filas = parseInt(document.getElementById('gruposrows').value);
                    var arrgrupo = Array([]);
                    var cuantos = 0;
                    //alert(filas);
                    for(i = 1; i <= filas; i++){
                        chk = document.getElementById("grupos"+i);
                        if(chk.checked) {
                            arrgrupo[cuantos] = chk.value;
                            cuantos++;
                        }
                    }
                    if(cuantos > 0) {
                        abrir();
                        xajax_Modificar_Videoclase_recurrente(codigo.value,nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,evento.value,schedule.value,partnerId.value,arrgrupo,cuantos,tipoclass.value,dias.value,recurrente.value);
                    }else{
                        swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
                    }
                }else{
                    abrir();
                    var arrgrupo = Array([]);
                    var cuantos = 0;
                        xajax_Modificar_Videoclase_recurrente(codigo.value,nombre.value,descripcion.value,fecini.value,horini.value,fecfin.value,horfin.value,target.value,tipo.value,plataforma.value,link.value,evento.value,schedule.value,partnerId.value,arrgrupo,cuantos,tipoclass.value,dias.value,recurrente.value);
                }
            }else{
                if(target.value ===""){
                    target.className = "form-danger";
                }else{
                    target.className = "form-control";
                }
                if(dias.value ===""){
                    dias.className = "form-danger";
                }else{
                    dias.className = "form-control";
                }
                if(nombre.value ===""){
                    nombre.className = "form-danger";
                }else{
                    nombre.className = "form-control";
                }
                if(descripcion.value ===""){
                    descripcion.className = "form-danger";
                }else{
                    descripcion.className = "form-control";
                }
                if(fecini.value ===""){
                    fecini.className = "form-danger";
                }else{
                    fecini.className = "form-control";
                }
                if(horini.value ===""){
                    horini.className = "form-danger";
                }else{
                    horini.className = "form-control";
                }
                if(fecfin.value ===""){
                    fecfin.className = "form-danger";
                }else{
                    fecfin.className = "form-control";
                }
                if(horfin.value ===""){
                    horfin.className = "form-danger";
                }else{
                    horfin.className = "form-control";
                }
                if(plataforma.value ===""){
                    plataforma.className = "form-danger";
                }else{
                    plataforma.className = "form-control";
                }
                if(link.value ===""){
                    link.className = "form-danger";
                }else{
                    link.className = "form-control";
                }
                swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
            }
        }else{
            swal("Ohoo!", "Si quiere crear una actividad nueva esta en la pantalla equivocada, aqu\u00ED solo puede actualizar las existentes.\nPara editar, seleccione la actividad que quiere modificar y realice los cambios...", "error");
        }
    }

    function ModificarTarget(){
        target = document.getElementById('target');
        tipo = document.getElementById('tipotarget');
        
        if(target.value !==""){
            if (target.value === "SELECT") {
                    var filas = parseInt(document.getElementById('gruposrows').value);
                    var arrgrupos = "";
                    var cuantos = 0;
                    //alert(filas);
                    for(i = 1; i <= filas; i++){
                        chk = document.getElementById("grupos"+i);
                        if(chk.checked) {
                            arrgrupos+= chk.value+"|";
                            cuantos++;
                        }
                    }
                    if(cuantos > 0) {
                        abrir();
                        document.getElementById('gruposrows').value = cuantos; //actualiza solo la cantidad de chequeados
                        document.getElementById('chequeados').value = arrgrupos; //genera un string tipo array
                        Submit();
                    }else{
                        swal("Ohoo!", "Debe seleccionar almenos un (01) Grupo...", "warning");
                    }
            }else{
                Submit();
            }
        }else{
            if(target.value ===""){
                target.className = "form-danger";
            }else{
                target.className = "form-control";
            }
            swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
        }
    }
    
    
    function ConfirmEliminar(codigo){
        swal({
            title: "Cancelar Videoclase",
            text: "\u00BFDesea eliminar esta actividad del calendario?, No podra ser visualizada con esta situaci\u00F3n...",
            icon: "warning",
            buttons: {
                cancel: "Cancelar",
                ok: { text: "Aceptar", value: true},
            }
        }).then((value) => {
            switch (value) {
                case true:
                    abrir();
                    xajax_Situacion_Videoclase(codigo);
                    break;
                default:
                  return;
            }
        });
    }
    
    function ConfirmRecordatorio(codigo){
        swal({
            title: "\u00BFNotificar Recordatorio?",
            text: "\u00BFDesea notificar un recordatorio de esta actividad?",
            icon: "warning",
            buttons: {
                cancel: "Cancelar",
                ok: { text: "Aceptar", value: true},
            }
        }).then((value) => {
            switch (value) {
                case true:
                    abrir();
                    xajax_Recordatorio(codigo);
                    break;
                default:
                  return;
            }
        });
    }
    
    
    function Ver_Videoclase(codigo){    
        //Realiza una peticion de contenido a la contenido.php
        $.post("../promts/videoclase/videoclase.php",{codigo:codigo}, function(data){
        // Ponemos la respuesta de nuestro script en el DIV recargado
        $("#Pcontainer").html(data);
        });
        abrirModal();
    }
    
    


