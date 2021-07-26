<?php
require_once('lib/KalturaClient.php');

/*
//Partner ID
$userId = "jpellecer@inversionesd.com";
$partner_id = "2950161";
//Sub Partner ID
$subpartner_id = "295016100";
//Administrator Secret
$secret_pass = "89c392bd7031f0683354051231f5e89c";
//User Secret
$user_secret = "eb5ab9f05c5ca7a7298273c1986b2380";
//Contraseña
Contraseña: *JAPid007
*/

function kaltura_connect($partnerId,$userId,$secret) {

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


function kaltura_add_schedule($nombre, $descripcion, $partnerId,$userId,$secret) {

    $client = kaltura_connect($partnerId,$userId,$secret);

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

function kaltura_delete_schedule($id, $partnerId,$userId,$secret) {

    $client = kaltura_connect($partnerId,$userId,$secret);

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

function kaltura_list_schedule($partnerId,$userId,$secret) {

    $client = kaltura_connect($partnerId,$userId,$secret);

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


function kaltura_add_event($id_video_clase, $organizador, $nombre, $cui_organizador, $dateinicio, $datefin, $partnerId,$userId,$secret){
    $client = kaltura_connect($partnerId,$userId,$secret);

    $schedulePlugin = KalturaScheduleClientPlugin::get($client);
    $scheduleEvent = new KalturaRecordScheduleEvent();
    $scheduleEvent->recurrenceType = KalturaScheduleEventRecurrenceType::NONE;
    $scheduleEvent->summary = $nombre;
    $scheduleEvent->startDate = $dateinicio;
    $scheduleEvent->endDate = $datefin;
    $scheduleEvent->organizer = $organizador;
    $scheduleEvent->ownerId = $cui_organizador;
    $scheduleEvent->referenceId = $id_video_clase;
    $scheduleEvent->tags = "custom_rec_auto_start:1,custom_rs_show_invite:0,custom_rs_enable_guests_to_join:0,custom_rs_class_mode:virtual_classroom,custom_rs_user_lang:es-LA";


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


function kaltura_delete_event($id, $partnerId,$userId,$secret) {

    $client = kaltura_connect($partnerId,$userId,$secret);

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


function kaltura_list_event($partnerId,$userId,$secret) {

    $client = kaltura_connect($partnerId,$userId,$secret);

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


function kaltura_resource_event($event, $resource, $partnerId,$userId,$secret) {

    $client = kaltura_connect($partnerId,$userId,$secret);

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



function kaltura_session($partnerId,$secret, $eventId, $tipo_usuario, $cui, $nombre, $apellido) {

     //$partnerId = 2950161;
     //$secret = "89c392bd7031f0683354051231f5e89c";
     $userId = $cui;
     $type = KalturaSessionType::USER;
     $url = "https://www.kaltura.com";
     $expiry = 86400;

     $config = new KalturaConfiguration( $partnerId );
     $config->setServiceUrl( $url );
     $client = new KalturaClient($config );


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



function kaltura_list_liveStream($partnerId,$userId,$secret, $grado_seccion='') {

     $client = kaltura_connect($partnerId,$userId,$secret);

     $filter = new KalturaMediaEntryFilter();
     $filter->orderBy = KalturaMediaEntryOrderBy::CREATED_AT_DESC;
     if(strlen($userId)>0) {
          $filter->userIdEqual = $userId;
     }
     if(strlen($grado_seccion)>0) {
          $filter->nameLike = $grado_seccion;
     }
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
