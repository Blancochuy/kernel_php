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
<link href="assets\plugins\bootstrap\css\bootstrap.min.css" rel="stylesheet">
<link href="assets\plugins\font-awesome\css\all.min.css" rel="stylesheet">


<!-- Theme Styles -->
<link href="assets\css\lime.min.css" rel="stylesheet">
<link href="assets\themes\dark_mode.css" rel="stylesheet">
<link href="assets\css\custom.css" rel="stylesheet">
<pre >
     archivo de prueba .txt
     Copia y pega el url
     https://gist.githubusercontent.com/Blancochuy/1e8a575d1b399888ed0dfdd1711c2cc8/raw/762ba487488054b74de342a96008715b53aaaa4a/ejecuci%25C3%25B3n.txt
</pre>

<body class="no-loader">
<form action="files/front/myos.php" method="get">
  <input class="form-control" type="text" name="link"></input>
  <button class="btn btn-primary" type="submit">Submit</button>
</form>
</body>
