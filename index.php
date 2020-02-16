<?php

    include('files/backend/functions.php');
    $functions = new Functions();
  if(isset($_POST['link']))
  {

      $link = htmlentities($_GET['link']);
      $link = "https://gist.githubusercontent.com/Blancochuy/1e8a575d1b399888ed0dfdd1711c2cc8/raw/762ba487488054b74de342a96008715b53aaaa4a/ejecuci%25C3%25B3n.txt";
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

<form class="" action="" method="post">
  <input class="form-control" type="text" name="link"></input>
  <button class="btn btn-primary" type="submit">Submit</button>
</form>
