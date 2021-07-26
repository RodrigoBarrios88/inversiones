<?php
class ClsICSMultiple {
   const DT_FORMAT = 'Ymd\THis\Z';
   
   public $iCalendar = '';
   
   public function __construct($data) {
      $texto = $this->cabezera();
      $texto.= $this->set($data);
      $texto.= $this->pie();
      
      $this->iCalendar = $texto;
   }
   
   function cabezera(){
      $salida = "BEGIN:VCALENDAR"."\r\n";
      $salida.= "VERSION:2.0"."\r\n";
      $salida.= "PRODID:-//hacksw/handcal//NONSGML v1.0//EN"."\r\n";
      $salida.= "CALSCALE:GREGORIAN"."\r\n";
      return $salida;
   }
   
   function pie(){
      $salida = "END:VCALENDAR";
      return $salida;
   }
   
   function set($data) {
      $salida = "";
      foreach($data as $row){
         $salida.= "BEGIN:VEVENT\r\n";
         $salida.= "location:".$this->escape_string($row["location"])."\r\n";
         $salida.= "description:".$this->escape_string($row["description"])."\r\n";
         $salida.= "dtstart:".$this->format_timestamp($row["dtstart"])."\r\n";
         $salida.= "dtend:".$this->format_timestamp($row["dtend"])."\r\n";
         $salida.= "summary:".$this->escape_string($row["summary"])."\r\n";
         $salida.= "url;VALUE=URI:".$this->escape_string($row["url"])."\r\n";
         $salida.= "END:VEVENT\r\n";
      }
      return $salida;
   }
   
   
   private function format_timestamp($timestamp) {
      $dt = new DateTime($timestamp);
      return $dt->format(self::DT_FORMAT);
   }
   
   private function escape_string($str) {
      return preg_replace('/([\,;])/','\\\$1', $str);
   }
}
?>