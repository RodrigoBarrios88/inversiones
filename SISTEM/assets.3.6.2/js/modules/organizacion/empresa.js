//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function Submit(){
				myform = document.forms.f1;
				myform.submit();
			}
						
			function Grabar(){
				nom = document.getElementById('nom');
				direc = document.getElementById("direc");
				tel1 = document.getElementById("tel1");
				tel2 = document.getElementById("tel2");
				contac = document.getElementById("contac");
				telc = document.getElementById("telc");
				mail = document.getElementById("mail");
				var ValMail = false;
				
				if(nom.value !=="" && direc.value !== "" && tel1.value !== "" && contac.value !== "" && mail.value !== ""){
					if(mail.value !== '' || mail.value !== ' ' || mail.value !== '  '){
						ValMail = validarEmail(mail.value);
					}else{
						ValMail = true;
					}
					if(ValMail === true){
						abrir();
						xajax_Grabar_Empresa(nom.value,direc.value,tel1.value,tel2.value,mail.value,contac.value,telc.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
					}else{
						mail.className = "form-warning";
						swal("Ohoo!", "Formato de e-mail invalido!", "warning");
					}	
				}else{
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(mail.value ===""){
						mail.className = "form-danger";
					}else{
						mail.className = "form-control";
					}
					if(direc.value ===""){
						direc.className = "form-danger";
					}else{
						direc.className = "form-control";
					}
					if(tel1.value ===""){
						tel1.className = "form-danger";
					}else{
						tel1.className = "form-control";
					}
					if(contac.value ===""){
						contac.className = "form-danger";
					}else{
						contac.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}
			
			function Modificar(){
				cod = document.getElementById('cod');
				nom = document.getElementById('nom');
				direc = document.getElementById("direc");
				tel1 = document.getElementById("tel1");
				tel2 = document.getElementById("tel2");
				contac = document.getElementById("contac");
				telc = document.getElementById("telc");
				mail = document.getElementById("mail");
				var ValMail = false;
				
				if(nom.value !=="" && direc.value !== "" && tel1.value !== "" && contac.value !== "" && mail.value !== ""){
					if(mail.value !== '' || mail.value !== ' ' || mail.value !== '  ' || mail.value !== null){
						ValMail = validarEmail(mail.value);
					}else{
						ValMail = true;
					}
					if(ValMail === true){
						abrir();
						xajax_Modificar_Empresa(cod.value,nom.value,direc.value,tel1.value,tel2.value,mail.value,contac.value,telc.value);
						//botones
						gra = document.getElementById("gra");
						mod = document.getElementById("mod");
						mod.className = 'btn btn-primary hidden';
						gra.className = 'btn btn-primary hidden';
					}else{
						mail.className = "form-warning";
						swal("Ohoo!", "Formato de e-mail invalido!", "warning");
					}	
				}else{
					if(nom.value ===""){
						nom.className = "form-danger";
					}else{
						nom.className = "form-control";
					}
					if(mail.value ===""){
						mail.className = "form-danger";
					}else{
						mail.className = "form-control";
					}
					if(direc.value ===""){
						direc.className = "form-danger";
					}else{
						direc.className = "form-control";
					}
					if(tel1.value ===""){
						tel1.className = "form-danger";
					}else{
						tel1.className = "form-control";
					}
					if(contac.value ===""){
						contac.className = "form-danger";
					}else{
						contac.className = "form-control";
					}
					if(telc.value ===""){
						telc.className = "form-danger";
					}else{
						telc.className = "form-control";
					}
					swal("Ohoo!", "Debe llenar los Campos Obligatorios...", "error");
				}
			}
			
			function validarEmail(valor) {
				var filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;	
				if (filtro.test(valor)){
					return true;
				} else {
					return false;
				}
			}
			
		//////------ Reportes -----------//////////
		
			function ReporteLista(){
				myform = document.forms.f1;
				myform.action ="REPlista.php";
				myform.submit();
			}
			
			