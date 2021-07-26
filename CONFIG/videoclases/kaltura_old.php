<?php
require_once('lib/KalturaClient.php');

/*//Partner ID
$userId = "jpellecer@inversionesd.com";
$partner_id = "2950161";
//Sub Partner ID
$subpartner_id = "295016100";
//Administrator Secret
$secret_pass = "89c392bd7031f0683354051231f5e89c";
//User Secret
$user_secret = "eb5ab9f05c5ca7a7298273c1986b2380";*/


/*//Partner Farasi
$userId = "manuelsa@farasi.com.gt";
$partner_id = "3020131";
//Sub Partner ID
$subpartner_id = "302013100";
//Administrator Secret
$secret_pass = "f176af30d299dcf463d153cc716aacfc";
//User Secret
$user_secret = "bb40b5b53c0ed3c875f2ade470ed0304";*/

function kaltura_connect() {
        
    $secret = "89c392bd7031f0683354051231f5e89c";
    $userId = "jpellecer@inversionesd.com";
    $partnerId = 2950161;
    
    $type = KalturaSessionType::ADMIN;
    $url = "https://www.kaltura.com";
    $expiry = 86400;
    
	
    $config = new KalturaConfiguration( $partnerId );
    $config->setServiceUrl( $url );
    $client = new KalturaClient($config );
    $ks = $client->session->start( $secret, $userId, $type, $partnerId );
    $client->setKS( $ks );
    
    return $client;
}


function kaltura_add_schedule($nombre, $descripcion) {
        
    $client = kaltura_connect();
  
    $schedulePlugin = KalturaScheduleClientPlugin::get($client);
    $scheduleResource = new KalturaLocationScheduleResource();
    $scheduleResource->description = $descripcion;
    $scheduleResource->name = $nombre;
    $scheduleResource->parentId = null;
    $scheduleResource->tags = "vcprovider:newrow";
  
    try {
        $result = $schedulePlugin->scheduleResource->add($scheduleResource);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
        "status" => $status,
        "data" => (array) $result,
        "error" => $error
    );
    
    return $payload;
}

function kaltura_delete_schedule($id) {
        
    $client = kaltura_connect();
  
    $schedulePlugin = KalturaScheduleClientPlugin::get($client);
    $scheduleResourceId = $id;
  
    try {
        $result = $schedulePlugin->scheduleResource->delete($scheduleResourceId);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
        "status" => $status,
        "data" => (array) $result,
        "error" => $error
    );
    
    return $payload;
}

function kaltura_list_schedule() {
        
    $client = kaltura_connect();
  
    $schedulePlugin = KalturaScheduleClientPlugin::get($client);
    $filter = new KalturaScheduleResourceFilter();
    $pager = new KalturaFilterPager();
  
    try {
        $result = $schedulePlugin->scheduleResource->listAction($filter, $pager);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
        "status" => $status,
        "data" => (array) $result,
        "error" => $error
    );
    
    return $payload;
}


function kaltura_add_event($id_video_clase, $organizador, $nombre, $cui_organizador, $dateinicio, $datefin){
    $client = kaltura_connect();
    
    $schedulePlugin = KalturaScheduleClientPlugin::get($client);
    $scheduleEvent = new KalturaRecordScheduleEvent();
    $scheduleEvent->recurrenceType = KalturaScheduleEventRecurrenceType::NONE;
    $scheduleEvent->summary = $nombre;
    $scheduleEvent->startDate = $dateinicio;
    $scheduleEvent->endDate = $datefin;
    $scheduleEvent->organizer = $organizador;
    $scheduleEvent->ownerId = $cui_organizador;
    $scheduleEvent->referenceId = $id_video_clase;
    $scheduleEvent->tags = "custom_rec_auto_start:1,custom_rs_show_invite:1,custom_rs_enable_guests_to_join:0,custom_rs_class_mode:virtual_classroom,custom_rs_user_lang:es-LA";

    
    try {
        $result = $schedulePlugin->scheduleEvent->add($scheduleEvent);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
        "status" => $status,
        "data" => (array) $result,
        "error" => $error
    );
    
    return $payload;

}


function kaltura_delete_event($id) {
        
    $client = kaltura_connect();
  
    $schedulePlugin = KalturaScheduleClientPlugin::get($client);
    $scheduleEventId = $id;
  
    try {
        $result = $schedulePlugin->scheduleEvent->delete($scheduleEventId);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
      "status" => $status,
      "data" => (array) $result,
      "error" => $error
    );
    
    return $payload;
}


function kaltura_list_event() {
        
    $client = kaltura_connect();
  
    $schedulePlugin = KalturaScheduleClientPlugin::get($client);
    $filter = new KalturaScheduleEventFilter();
    $pager = new KalturaFilterPager();
  
    try {
        $result = $schedulePlugin->scheduleEvent->listAction($filter, $pager);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
        "status" => $status,
        "data" => (array) $result,
        "error" => $error
    );
    
    return $payload;
}


function kaltura_resource_event($event, $resource) {
        
    $client = kaltura_connect();
  
    $schedulePlugin = KalturaScheduleClientPlugin::get($client);
    $scheduleEventResource = new KalturaScheduleEventResource();
    $scheduleEventResource->eventId = $event;
    $scheduleEventResource->resourceId = $resource;
  
    try {
        $result = $schedulePlugin->scheduleEventResource->add($scheduleEventResource);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
        "status" => $status,
        "data" => (array) $result,
        "error" => $error
    );
    
    return $payload;
}



function kaltura_session($eventId, $tipo_usuario, $cui, $nombre, $apellido) {
        
    $secret = "89c392bd7031f0683354051231f5e89c";
    $userId = $cui;
    $type = KalturaSessionType::USER;
    $url = "https://www.kaltura.com";
    $partnerId = 2950161;
    $expiry = 86400;
    
    $config = new KalturaConfiguration( $partnerId );
    $config->setServiceUrl( $url );
    $client = new KalturaClient( $config );
    
    
    switch($tipo_usuario){
        case 1: $role = "adminRole"; $contextual = 0; $rolnombre = "(Autoridad)"; break;
        case 2: $role = "adminRole"; $contextual = 0; $rolnombre = "(Maestro)"; break;
        case 5: $role = "adminRole"; $contextual = 0; $rolnombre = "(Administrador)"; break;
        case 3: $role = "viewerRole"; $contextual = 3; $rolnombre = "(Padre/Madre)"; break;
        case 10: $role = "viewerRole"; $contextual = 3; $rolnombre = "(Alumno)"; break;
    }
    
    $privileges = "eventId:$eventId,role:$role,userContextualRole:$contextual,firstName:$nombre,lastName: $rolnombre";
    //echo "$secret, $userId, $type, $partnerId, $expiry, $privileges<br><br>";
  
    try {
        $result = $client->session->start($secret, $userId, $type, $partnerId, $expiry, $privileges);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
        "status" => $status,
        "token" => (array) $result,
        "error" => $error
    );
    
    return $payload;
}



function kaltura_list_liveStream() {
        
    $client = kaltura_connect();
  
    $filter = new KalturaMediaEntryFilter();
    $filter->orderBy = KalturaMediaEntryOrderBy::CREATED_AT_DESC;
    $pager = new KalturaFilterPager();
    
    try {
        $result = $client->media->listAction($filter, $pager);
        $status = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $status = false;
    }
    
    $payload = array(
        "status" => $status,
        "data" => (array) $result,
        "error" => $error
    );
    
    return $payload;
}

?>