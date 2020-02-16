<?php
    //validar que se este mandando el archivo de ejecucioón
    if (empty($_GET['link']))
    {
    $error = true;
    } else {
      // continuia en MyOs.php 
    }
    if ($error)
    {
      echo "All fields are required.";
    } else {
      echo "Proceed...";
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

<form action="files/front/myos.php" method="get">
  <input class="form-control" type="text" name="link"></input>
  <button class="btn btn-primary" type="submit">Submit</button>
</form>
