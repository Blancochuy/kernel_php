<!DOCTYPE html>
<?php
  require('../backend/functions.php');
  $functions = new Functions();
  //Funcion para extraer los valores del archivo txt
  if(isset($_GET['link']))
  {
      $link = htmlentities($_GET['link']);
      $myData = $functions->getData($link);
  }
  //funcion para partir el areglos
  $arrss = $functions->getVariabels($myData);
  $valores = $arrss[0];
  $procesos = $arrss[1];

  //Funcion de tiempo
  $button = $functions->timeButton($valores);

  //Datos de procesos
  $num_procesos = $valores[2];
  $paginas_procesos = $functions->numeroPaginasProcesos($num_procesos, $procesos);
  $process_data = $functions->getProcessData($num_procesos, $procesos);

  var_dump($process_data[0][1]);
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- Title -->
        <title>MyOs</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">


        <!-- Theme Styles -->
        <link href="../../assets/css/lime.min.css" rel="stylesheet">
        <link href="..\..\assets\themes\dark_mode.css" rel="stylesheet">
        <link href="..\..\assets\css\custom.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="no-loader">

        <div class="lime-header">
            <nav class="navbar navbar-expand-lg justify-content-end">

                <a class="navbar-brand" href="#">MyOs</a>

                <div class="row">
                    <div class="col">
                      <label>Tiempo</label>
                      <form method='post'>
                      <input class="form-control" name='add' type="submit" value='<?php echo $_SESSION['attnum']++ ?>'>
                      </form>

                      <form method='post'>
                      <input class="btn btn-danger mt-2" name='reset' type="submit" value="Reset">
                      </form>

                    </div>
                    <div class="col">
                      <label>Paginas</label>
                      <select class="form-control custom-select" name="tablaPaginacion">
                          <option>Ejecutar paginas</option>
                      </select>
                    </div>
                    <div class="col">
                      <label>Interrupciones</label>
                      <select class="form-control custom-select" name="interruptionTable">
                          <option value="0">SVC de solicitud de I/O</option>
                          <option value="1">SVC de terminación normal</option>
                          <option value="2">SVC de solitud de fecha</option>
                          <option value="3">Error de programa</option>
                          <option value="4">Externa de quantum expirado</option>
                          <option value="5">Dispositivo de I/O</option>
                      </select>
                    </div>
                </div>
            </nav>
        </div>

        <!-- inicio Contenedor -->
        <div class="lime-container">
            <div class="lime-body">
                <div class="container">

            <!-- inicio de Procesos -->
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title">Procesos</h3>
                    <div class="row">
                      <div class="col-xl">
                          <div class="card text-center">
                              <div class="card-header">
                                  New
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Nombre</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Nombre">
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Páginas</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Páginas">
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Ejec Total</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Ejec Total">
                                  </div>
                                </div>
                                <br>
                                  <a href="#" class="btn btn-info">  +  </a>
                              </div>
                              <div class="card-footer text-muted">

                              </div>
                          </div>
                      </div>
                      <div class="col-xl">
                          <div class="card text-center">
                              <div class="card-header">
                                  Ready
                              </div>
                              <div class="card-body">
                                <table class="table" name="ready">

                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                        </tr>
                                    </tbody>
                                </table>
                              </div>
                              <div class="card-footer text-muted">

                              </div>
                          </div>
                      </div>
                        <div class="col-xl">
                          <div class="card text-center">
                              <div class="card-header">
                                  Running
                              </div>
                              <div class="card-body">
                                <table class="table" name="running">

                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>

                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>

                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>

                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>

                                        </tr>
                                    </tbody>
                                </table>
                              </div>
                              <div class="card-footer text-muted">

                              </div>
                          </div>
                        </div>
                        <div class="col-xl">
                          <div class="card text-center">
                              <div class="card-header">
                                  Blocked
                              </div>
                              <div class="card-body">
                                <table class="table" name="blocked">

                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>

                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>

                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>

                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>

                                        </tr>
                                    </tbody>
                                </table>
                              </div>
                              <div class="card-footer text-muted">

                              </div>
                          </div>
                        </div>
                        <div class="col-xl">
                            <div class="card text-center">
                                <div class="card-header">
                                    Finished
                                </div>
                                <div class="card-body">
                                  <table class="table" name="finished">
                                      <tbody>
                                          <tr>
                                              <th scope="row">1</th>

                                          </tr>
                                          <tr>
                                              <th scope="row">2</th>

                                          </tr>
                                          <tr>
                                              <th scope="row">3</th>

                                          </tr>
                                          <tr>
                                              <th scope="row">3</th>

                                          </tr>
                                      </tbody>
                                  </table>
                                </div>
                                <div class="card-footer text-muted">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- fin Procesos -->
              <!-- inicio de CPU -->
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title">CPU</h3>
                    <div class="row">
                      <div class="col-xl">
                        <!-- Manejo de espacios -->
                      </div>
                      <div class="col-xl">
                          <div class="card text-center">
                              <div class="card-header">
                                  Scheduling
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Nombre</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Nombre" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Tpo llegada</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Tpo" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Cpu Asignado</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Cpu Asignado" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Envejecimiento</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Env" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Cpu Restante</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Cpu Asignado" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Quantum Restante</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Quantum" disabled>
                                  </div>
                                </div>
                              </div>
                              <div class="card-footer text-muted">

                              </div>
                          </div>
                      </div>

                        <div class="col-xl">
                          <!-- Manejo de espacios -->
                        </div>
                        <div class="col-xl">
                            <div class="card text-center">
                                <div class="card-header">
                                    CPU
                                </div>
                                <div class="card-body">
                                  <div class="col">
                                    <select class="form-control custom-select" id="schedulingTable">
                                        <option>FIFO</option>
                                        <option>Round Robbin</option>
                                        <option>Shortest Job First</option>
                                        <option>Shortest Remaining Time</option>
                                        <option>Highest Response</option>
                                        <option>Multi Level Feedback Queues</option>
                                    </select>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col">
                                      <p class="card-text">Tam Quantum</p>
                                    </div>
                                    <div class="col">
                                      <input type="text" class="form-control" placeholder="Tam">
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer text-muted">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- Fin CPU -->
              <!-- inicio de Memoria -->
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title">Memoria</h3>
                    <div class="row">

                      <div class="col-xl">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">pag</th>
                                    <th scope="col">r</th>
                                    <th scope="col">llegada</th>
                                    <th scope="col">ult acceso</th>
                                    <th scope="col">accesos</th>
                                    <th scope="col">NUR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                      </div>

                        <div class="col-xl">
                          <!-- Manejo de espacios -->
                        </div>
                        <div class="col-xl">
                            <div class="card text-center">
                                <div class="card-header">
                                    Memoria
                                </div>
                                <div class="card-body">
                                  <div class="col">
                                    <select class="form-control custom-select" name="exampleFormControlSelect2">
                                        <option>NUR</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                  </div>
                                  <br>
                                  <a href="#" class="btn btn-info">Reset a bits NUR</a>
                                </div>
                                <div class="card-footer text-muted">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- Fin de Memoria -->
                </div>
            </div>
            <div class="lime-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="footer-text">2020 © 🥳 </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascripts -->
        <script src="../../assets/plugins/jquery/jquery-3.1.0.min.js"></script>
        <script src="../../assets/plugins/bootstrap/popper.min.js"></script>
        <script src="../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="../../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../../assets/js/lime.min.js"></script>
    </body>
</html>
