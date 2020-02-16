<?php
   session_start();
   // Page was not reloaded via a button press
   if (!isset($_POST['add'])) {
       $_SESSION['attnum'] = 1; // Reset counter
   }
   if (!isset($_POST['reset'])) {
     $reem = array("attnum" => 0);
     $reiniciar = array_replace($reem);
   }

?>
