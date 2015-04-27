<?php
   session_start();
   var_dump($_SESSION);
   echo 'Location:'.$_SESSION['LIVESTREAM'];
//   header ('Location:'.$_SESSION['LIVESTREAM']);
   session_unset('LIVESTREAM');
?>
