<?php

  require('files/backend/functions.php');
  $functions = new Functions();
  if( isset($_GET['submit']) )
  {
    $link = htmlentities($_GET['link']);
    $button = $functions->getData($link);
  }
?>
<!-- Styles -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../../assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">


<!-- Theme Styles -->
<link href="../../assets/css/lime.min.css" rel="stylesheet">
<link href="..\..\assets\themes\dark_mode.css" rel="stylesheet">
<link href="..\..\assets\css\custom.css" rel="stylesheet">

<form class="" action="" method="get" target="myvalue">
  <input class="form-control" type="text" name="link"></input>
  <button class="btn btn-primary" type="submit"  href="">Submit</button>
</form>

<iframe name="myvalue"></iframe>
