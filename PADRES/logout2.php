<?php
  include_once('user_auth_fns.php');

  unset($_SESSION['gyt_usu']);
  unset($_SESSION['gyt_pass']);
  session_destroy();

  header('Location: http://www.mozilla.org/es-ES/firefox/new/');
?>

