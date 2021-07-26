<?php
require_once ("ClsConex.php");

class ClsBanco extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
//---------- Bancos ---------//
    function get_banco($cod,$dct = '',$dlg = '',$pai = '',$sit = ''){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT * ";
		$sql.= " FROM fin_banco, mast_paises";
		$sql.= " WHERE ban_pais = pai_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND ban_codigo = $cod"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND ban_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND ban_desc_lg like '%$dlg%'"; 
		}
		if(strlen($pai)>0) { 
			  $sql.= " AND ban_pais = $pai"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ban_situacion = $sit"; 
		}
		$sql.= " ORDER BY ban_pais ASC, ban_codigo ASC, ban_situacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_banco($cod,$dct = '',$dlg = '',$pai = '',$sit = ''){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM fin_banco, mast_paises";
		$sql.= " WHERE ban_pais = pai_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND ban_codigo = $cod"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND ban_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND ban_desc_lg like '%$dlg%'"; 
		}
		if(strlen($pai)>0) { 
			  $sql.= " AND ban_pais = $pai"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ban_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_banco($cod,$dct,$dlg,$pai){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
		$sql = "INSERT INTO fin_banco VALUES($cod,'$dct','$dlg',$pai,1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_banco($cod,$dct,$dlg,$pai){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
		$sql = "UPDATE fin_banco SET ";
		$sql.= "ban_desc_ct = '$dct',"; 
		$sql.= "ban_desc_lg = '$dlg',"; 
		$sql.= "ban_pais = $pai"; 
		
		$sql.= " WHERE ban_codigo = $cod; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_banco($cod,$sit){
		
		$sql = "UPDATE fin_banco SET ";
		$sql.= "ban_situacion = $sit"; 
				
		$sql.= " WHERE ban_codigo = $cod; "; 	
		
		return $sql;
	}
	
	function comprueba_sit_banco($ban) {
		
		$sql = "SELECT COUNT(cueb_codigo) as total";
		$sql.= " FROM fin_cuenta_banco";
		$sql.= " WHERE cueb_banco = $ban"; 	
		$sql.= " AND cueb_situacion = 1; "; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$cant = $row["total"];
				if($cant > 0){
					return true;
				}
			}
		}
		//echo $sql;
		return false;
	}
		
	function max_banco() {
		
        $sql = "SELECT max(ban_codigo) as max ";
		$sql.= " FROM fin_banco";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
//---------- Cuentas de Bancos ---------//
    function get_cuenta_banco($codigo,$ban = '',$num = '',$tip = '',$mon = '',$pai = '',$sit = '',$suc = '') {
		$num = trim($num);
		
        $sql= "SELECT *, CONCAT(cueb_ncuenta, ' / ', cueb_nombre) as cueb_numero_nombre ";
		$sql.= " FROM fin_cuenta_banco, fin_banco, mast_paises, fin_moneda, fin_tipo_cuenta, mast_sucursal";
		$sql.= " WHERE ban_pais = pai_id";
		$sql.= " AND cueb_banco = ban_codigo";
		$sql.= " AND cueb_sucursal = suc_id";
		$sql.= " AND cueb_tipo_cuenta = tcue_codigo";
		$sql.= " AND cueb_moneda = mon_id";
		if(strlen($codigo)>0) { 
			  $sql.= " AND cueb_codigo IN($codigo)"; 
		}
		if(strlen($ban)>0) { 
			  $sql.= " AND ban_codigo = $ban"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND cueb_sucursal = $suc"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND cueb_ncuenta = '$num'"; 
		}
		if(strlen($tip)>0) { 
			  $sql.= " AND cueb_tipo_cuenta = $tip"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND cueb_moneda = $mon"; 
		}
		if(strlen($pai)>0) { 
			  $sql.= " AND ban_pais = $pai"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cueb_situacion = $sit"; 
		}
		$sql.= " ORDER BY ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, cueb_situacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_cuenta_banco($codigo,$ban = '',$num = '',$tip = '',$mon = '',$pai = '',$sit = '',$suc = '') {
		$num = trim($num);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM fin_cuenta_banco, fin_banco, mast_paises, fin_moneda, fin_tipo_cuenta, mast_sucursal";
		$sql.= " WHERE ban_pais = pai_id";
		$sql.= " AND cueb_banco = ban_codigo";
		$sql.= " AND cueb_sucursal = suc_id";
		$sql.= " AND cueb_tipo_cuenta = tcue_codigo";
		$sql.= " AND cueb_moneda = mon_id";
		if(strlen($codigo)>0) { 
			 $sql.= " AND cueb_codigo IN($codigo)"; 
		}
		if(strlen($ban)>0) { 
			  $sql.= " AND ban_codigo = $ban"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND cueb_sucursal = $suc"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND cueb_ncuenta = '$num'"; 
		}
		if(strlen($tip)>0) { 
			  $sql.= " AND cueb_tipo_cuenta = $tip"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND cueb_moneda = $mon"; 
		}
		if(strlen($pai)>0) { 
			  $sql.= " AND ban_pais = $pai"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cueb_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_cuenta_banco($cod,$ban,$suc,$num,$nom,$tip,$saldo,$mon,$tasa,$plazo,$fpag,$fini){
		$num = trim($num);
		$nom = trim($nom);
		$fini = $this->regresa_fecha($fini);
		
		$sql = "INSERT INTO fin_cuenta_banco";
		$sql.= " VALUES ($cod,$ban,$suc,'$num','$nom',$tip,$saldo,$mon,$tasa,$plazo,'$fpag','$fini',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_cuenta_banco($cod,$ban,$suc,$num,$nom,$tip,$mon,$tasa,$plazo,$fpag,$fini){
		$num = trim($num);
		$nom = trim($nom);
		$fini = $this->regresa_fecha($fini);
		
		$sql = "UPDATE fin_cuenta_banco SET ";
		$sql.= "cueb_sucursal = $suc,"; 
		$sql.= "cueb_ncuenta = '$num',"; 
		$sql.= "cueb_nombre = '$nom',"; 
		$sql.= "cueb_tipo_cuenta = '$tip',"; 
		$sql.= "cueb_moneda = '$mon',"; 
		$sql.= "cueb_tasa = '$tasa',"; 
		$sql.= "cueb_plazo = '$plazo',"; 
		$sql.= "cueb_forma_pago = '$fpag',"; 
		$sql.= "cueb_fini = '$fini'"; 
		
		$sql.= " WHERE cueb_codigo = $cod "; 	
		$sql.= " AND cueb_banco = $ban; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_cuenta_banco($cod,$ban,$sit){
		
		$sql = "UPDATE fin_cuenta_banco SET ";
		$sql.= "cueb_situacion = $sit"; 
				
		$sql.= " WHERE cueb_codigo = $cod"; 	
		$sql.= " AND cueb_banco = $ban; "; 	
		
		return $sql;
	}
	
	function comprueba_sit_cuenta_banco($cod,$ban) {
		
		$sql = "SELECT COUNT(cueb_codigo) as total";
		$sql.= " FROM fin_cuenta_banco";
		$sql.= " WHERE cueb_codigo = $cod"; 	
		$sql.= " AND cueb_banco = $ban"; 	
		$sql.= " AND cueb_saldo > 0; "; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$cant = $row["total"];
				if($cant > 0){
					return true;
				}
			}
		}
		//echo $sql;
		return false;
	}
		
		
	function max_cuenta_banco($ban) {
		
        $sql = "SELECT max(cueb_codigo) as max ";
		$sql.= " FROM fin_cuenta_banco";
		$sql.= " WHERE cueb_banco = $ban; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	function saldo_cuenta_banco($cue,$ban,$mont,$signo){
		
		$sql = "UPDATE  fin_cuenta_banco SET ";
		if($signo == "+") { 
			$sql.= "cueb_saldo = cueb_saldo + $mont"; 
		}else if($signo == "-") { 
			$sql.= "cueb_saldo = cueb_saldo - $mont"; 
		}
		
		$sql.= " WHERE cueb_codigo = $cue "; 	
		$sql.= " AND cueb_banco = $ban; "; 	
		//echo $sql;
		return $sql;
	}

//---------- Movimientos de Cuenta ---------//
    function get_mov_cuenta($cod,$cue = '',$ban = '',$mov = '',$tipo = '',$doc = '',$quien = '',$fini = '',$ffin = '',$sit = '',$suc = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM  fin_mov_cuenta_banco, fin_cuenta_banco, fin_banco, mast_paises, fin_moneda, fin_tipo_cuenta";
		$sql.= " WHERE ban_pais = pai_id";
		$sql.= " AND mcb_cuenta = cueb_codigo";
		$sql.= " AND mcb_banco = cueb_banco";
		$sql.= " AND cueb_banco = ban_codigo";
		$sql.= " AND cueb_tipo_cuenta = tcue_codigo";
		$sql.= " AND cueb_moneda = mon_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND mcb_codigo = $cod"; 
		}
		if(strlen($cue)>0) { 
			  $sql.= " AND cueb_codigo = $cue"; 
		}
		if(strlen($ban)>0) { 
			  $sql.= " AND ban_codigo = $ban"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND cueb_sucursal = $suc"; 
		}
		if(strlen($mov)>0) { 
			  $sql.= " AND mcb_movimiento = '$num'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mcb_tipo = '$tipo'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND mcb_doc = '$doc'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND mcb_quien = $quien"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND mcb_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mcb_situacion = $sit"; 
		}
		$sql.= " ORDER BY mcb_fechor ASC, ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, mcb_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_mov_cuenta($cod,$cue = '',$ban = '',$mov = '',$tipo = '',$doc = '',$quien = '',$fini = '',$ffin = '',$sit = '',$suc = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM  fin_mov_cuenta_banco, fin_cuenta_banco, fin_banco, mast_paises, fin_moneda, fin_tipo_cuenta";
		$sql.= " WHERE ban_pais = pai_id";
		$sql.= " AND mcb_cuenta = cueb_codigo";
		$sql.= " AND mcb_banco = cueb_banco";
		$sql.= " AND cueb_banco = ban_codigo";
		$sql.= " AND cueb_tipo_cuenta = tcue_codigo";
		$sql.= " AND cueb_moneda = mon_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND mcb_codigo = $cod"; 
		}
		if(strlen($cue)>0) { 
			  $sql.= " AND cueb_codigo = $cue"; 
		}
		if(strlen($ban)>0) { 
			  $sql.= " AND ban_codigo = $ban"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND cueb_sucursal = $suc"; 
		}
		if(strlen($mov)>0) { 
			  $sql.= " AND mcb_movimiento = '$num'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mcb_tipo = '$tipo'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND mcb_doc = '$doc'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND mcb_quien = $quien"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND mcb_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mcb_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_saldo_anterior($cue,$ban,$fec) {
		
       	$fec = $this->regresa_fecha($fec);
		
		$sql= "SELECT cueb_codigo,";
		$sql.= " (SELECT SUM(mcb_monto) FROM fin_mov_cuenta_banco WHERE mcb_cuenta = cueb_codigo AND mcb_banco = cueb_banco AND mcb_movimiento = 'I' AND mcb_fecha < '$fec') as ingresos,";
		$sql.= " (SELECT SUM(mcb_monto) FROM fin_mov_cuenta_banco WHERE mcb_cuenta = cueb_codigo AND mcb_banco = cueb_banco AND mcb_movimiento = 'E' AND mcb_fecha < '$fec') as egresos";
		$sql.= " FROM  fin_cuenta_banco";
		$sql.= " WHERE cueb_codigo = $cue"; 
		$sql.= " AND cueb_banco = $ban"; 
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$ingresos = $row['ingresos'];
			$egresos = $row['egresos'];
		}
		$saldo = $ingresos - $egresos;
		return $saldo;
	}
		
	function insert_mov_cuenta($cod,$cue,$ban,$mov,$monto,$tipo,$motivo,$doc,$fecha){
		//--
		$fecha = $this->regresa_fecha($fecha);
		$fechor = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO fin_mov_cuenta_banco"; 
		$sql.= " VALUES ($cod,$cue,$ban,'$mov','$monto','$tipo','$motivo','$doc','$fecha','$fechor',$usu,1); ";
		//echo $sql;
		return $sql;
	}
			
	function max_mov_cuenta($cue,$ban) {
		
        $sql = "SELECT max(mcb_codigo) as max";
		$sql.= " FROM fin_mov_cuenta_banco";
		$sql.= " WHERE mcb_banco = $ban "; 	
		$sql.= " AND mcb_cuenta = $cue "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

	
	//---------- Cheques ---------//
    function get_cheque($cod,$cue = '',$ban = '',$num = '',$quien = '',$fini = '',$ffin = '',$sit = '',$suc = '') {
		$quien = trim($quien);
		
        $sql= "SELECT * ";
		$sql.= " FROM fin_cheque, fin_cuenta_banco, fin_banco, mast_paises, fin_moneda, fin_tipo_cuenta";
		$sql.= " WHERE ban_pais = pai_id";
		$sql.= " AND che_cuenta = cueb_codigo";
		$sql.= " AND che_banco = cueb_banco";
		$sql.= " AND cueb_banco = ban_codigo";
		$sql.= " AND cueb_tipo_cuenta = tcue_codigo";
		$sql.= " AND cueb_moneda = mon_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND che_codigo = $cod"; 
		}
		if(strlen($cue)>0) { 
			  $sql.= " AND cueb_codigo = $cue"; 
		}
		if(strlen($ban)>0) { 
			  $sql.= " AND ban_codigo = $ban"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND cueb_sucursal = $suc"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND che_ncheque = '$num'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND che_quien like '%$quien%'"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND che_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND che_situacion = $sit"; 
		}
		$sql.= " ORDER BY ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, che_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_cheque($cod,$cue = '',$ban = '',$num = '',$quien = '',$fini = '',$ffin = '',$sit = '',$suc = '') {
		$quien = trim($quien);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM fin_cheque, fin_cuenta_banco, fin_banco, mast_paises, fin_moneda, fin_tipo_cuenta";
		$sql.= " WHERE ban_pais = pai_id";
		$sql.= " AND che_cuenta = cueb_codigo";
		$sql.= " AND che_banco = cueb_banco";
		$sql.= " AND cueb_banco = ban_codigo";
		$sql.= " AND cueb_tipo_cuenta = tcue_codigo";
		$sql.= " AND cueb_moneda = mon_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND che_codigo = $cod"; 
		}
		if(strlen($cue)>0) { 
			  $sql.= " AND cueb_codigo = $cue"; 
		}
		if(strlen($ban)>0) { 
			  $sql.= " AND ban_codigo = $ban"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND cueb_sucursal = $suc"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND che_ncheque = '$num'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND che_quien like '%$quien%'"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND che_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND che_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_cheque($cod,$cue,$ban,$num,$monto,$quien,$concept){
		$concept = trim($concept);
		$quien = trim($quien);
		//--
		$fec = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO fin_cheque";
		$sql.= " VALUES ($cod,$cue,$ban,'$num','$monto','$quien','$concept','$fec',$usu,1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_cheque($cod,$cue,$ban,$num,$monto,$quien,$concept){
		
		$sql = "UPDATE fin_cheque SET ";
		$sql.= "che_ncheque = '$num',"; 
		$sql.= "che_monto = '$monto',"; 
		$sql.= "che_quien = '$quien',"; 
		$sql.= "che_concepto = '$concept'"; 
		
		$sql.= " WHERE che_codigo = $cod "; 	
		$sql.= " AND che_banco = $ban "; 	
		$sql.= " AND che_cuenta = $cue; "; 	
		//echo $sql;
		return $sql;
	}
		
	function max_cheque($cue,$ban) {
		
        $sql = "SELECT max(che_codigo) as max ";
		$sql.= " FROM fin_cheque";
		$sql.= " WHERE che_banco = $ban "; 	
		$sql.= " AND che_cuenta = $cue "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

	function last_numero_cheque($cue,$ban) {
		
        $sql = "SELECT MAX(che_ncheque) as last ";
		$sql.= " FROM fin_cheque";
		$sql.= " WHERE che_banco = $ban "; 	
		$sql.= " AND che_cuenta = $cue "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$last = $row["last"];
		}
		//echo $sql;
		return $last;
	}	
	
	
	function comprueba_sit_cheque($cod,$cue,$ban) {
		
		$sql = "SELECT COUNT(che_codigo) as total";
		$sql.= " FROM fin_cheque";
		$sql.= " WHERE che_codigo = $cod"; 	
		$sql.= " AND che_cuenta = $cue"; 	
		$sql.= " AND che_banco = $ban"; 	
		$sql.= " AND che_situacion = 2; "; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$cant = $row["total"];
				if($cant > 0){
					return true;
				}
			}
		}
		//echo $sql;
		return false;
	}
	
	function cambia_sit_cheque($cod,$cue,$ban,$sit){
		
		$sql = "UPDATE fin_cheque SET ";
		$sql.= "che_situacion = $sit"; 
		
		$sql.= " WHERE che_codigo = $cod "; 	
		$sql.= " AND che_banco = $ban "; 	
		$sql.= " AND che_cuenta = $cue; "; 	
		//echo $sql;
		return $sql;
	}
	
	
}	
?>
