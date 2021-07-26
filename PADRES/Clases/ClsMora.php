<?php
require_once("ClsConex.php");

class ClsMora extends ClsConex
{
    /* Situacion 1 = ACTIVO, 0 = INACTIVO */

     public function get_grupos_moras($bloque = '', $division = '', $grupo = '', $empresa = '', $anio = '', $fini = '', $ffin = ''){
          $sql= "SELECT *, COUNT(mor_codigo) as mor_boletas ";
          $sql.= " FROM  boleta_mora, fin_cuenta_banco, fin_banco, fin_moneda, fin_tipo_cuenta";
          $sql.= " WHERE mor_division = cueb_codigo";
          $sql.= " AND mor_grupo_division = cueb_banco";
          $sql.= " AND cueb_banco = ban_codigo";
          $sql.= " AND cueb_tipo_cuenta = tcue_codigo";
          $sql.= " AND cueb_moneda = mon_id";
          if (strlen($bloque)>0) {
              $sql.= " AND mor_bloque = '$bloque'";
          }
          if (strlen($division)>0) {
              $sql.= " AND mor_division = $division";
          }
          if (strlen($grupo)>0) {
              $sql.= " AND mor_grupo_division = $grupo";
          }
          if (strlen($anio)>0) {
              $sql.= " AND YEAR(mor_fecha_registro) = $anio";
          }
          if (strlen($empresa)>0) {
              $sql.= " AND cueb_sucursal = $empresa";
          }
          if ($fini != "" && $ffin != "") {
              $fini = $this->regresa_fecha($fini);
              $ffin = $this->regresa_fecha($ffin);
              $sql.= " AND mor_fecha_registro BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
          }
          $sql.= " GROUP BY mor_bloque";
          $sql.= " ORDER BY mor_bloque ASC, mor_fecha_registro";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;
     }

    //---------- Configuracion de Moras ---------//
     public function insert_boleta_mora($codigo, $division, $grupo, $bloque, $motivo){
        //--
        $freg = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "INSERT INTO boleta_mora";
        $sql.= " VALUES ($codigo,$division,$grupo,$bloque,'$motivo',$usu,'$freg'); ";
        //echo $sql;
        return $sql;
    }

    public function max_grupo_mora(){
        $sql = "SELECT max(mor_bloque) as max ";
        $sql.= " FROM boleta_mora";
        $sql.= " WHERE 1 = 1 ";
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $max = $row["max"];
        }
        //echo $sql;
        return $max;
    }

    public function cambia_sit_mora($cod, $division, $grupo, $motivo_anula){
        //--
        $motivo_anula = trim($motivo_anula);
        $freg = date("d/m/Y H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "UPDATE boleta_mora SET ";
        $sql.= "mor_descripcion = 'GRUPO ANULADO EL: $freg MOTIVO: $motivo_anula USUARIO: $usu'";

        $sql.= " WHERE mor_codigo = $cod";
        $sql.= " AND mor_grupo_division = $grupo";
        $sql.= " AND mor_division = $division; ";
        //echo $sql;
        return $sql;
    }


}
