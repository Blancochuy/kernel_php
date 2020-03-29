<!DOCTYPE html>
<?php
  require('../backend/functions.php');
  require('../backend/kernel_obj.php');
  $functions = new Functions();
  //Funcion para extraer los valores del archivo txt
  if(isset($_GET['link']))
  {
      $link = htmlentities($_GET['link']);
      $myData = $functions->getData($link);
  }

  if(isset($_POST['start']))
  {
    //funcion para partir el areglos
    $arrss = $functions->getVariabels($myData);
    $valores = $arrss[0];
    $procesos = $arrss[1];

    //Funcion de tiempo
    $button = $functions->timeButton($valores);

    //Datos de procesos
    $num_procesos = $valores[2];
    //PROCESOS
    $process_data = $functions->getProcessData($num_procesos, $procesos);
    //Arreglo de todos los procesos
    $obj_process_arr = $functions->createProcessList($process_data);
    //INTERRUPCION
    $interruption = $functions->getInterruption($_POST['interruptionTable']);
    //Order
    @$order = $functions->getOrder($_POST['schedulingTable']);
    //Arreglos de procesos por status
    $_SESSION['lista_procesos_status'] = $functions->createStatusProcess($obj_process_arr);
    //Proceso corriendo actualmente
    $running_process = $_SESSION['lista_procesos_status']->running[0];
    //Tamaño de Quantum
    @$quantum = $_SESSION['quantumSize'];
    //Tiempo actual
    $cpu_time = $_SESSION['attnum'];
    //CPU
    $_SESSION['kernel']->cpu = $functions->createCpu($running_process, $quantum, $cpu_time);

    //MAIN OBJECT
    $_SESSION['kernel'] = new Kernel($_SESSION['lista_procesos_status'], $_SESSION['kernel']->cpu, $order, $interruption);
  }

  @session_start();

  //Verificador de tema
  if(isset($_POST['theme']))
  {
  $_SESSION['theme'] = $_POST['theme'];
  }

  if(isset($_POST['quantumSize']))
  {
     $_SESSION['quantumSize'] = $_POST['quantumSize'];
  }

  //Al agregar tiempo o proceso se ejecutan
  if (isset($_POST['createProcess']) or isset($_POST['add']))
  {
    $_SESSION['kernel']->cpu->quantum = $_SESSION['quantumSize'];
    $_SESSION['kernel']->cpu->addExecutionTime();
    $_SESSION['kernel']->updateInterruption($_POST['interruptionTable']);
    $_SESSION['kernel']->updateOrder($_POST['schedulingTable']);
    $_SESSION['kernel']->run();
  }

  var_dump($_SESSION['kernel']->cpu->running_process->pages[0]->residence);

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
        <form class="ml-4 mt-4"method="post">
            <input class="custom-radio mt-2" type="radio" name="theme" value="light"<?php if ($_SESSION['theme'] == "light") { echo "checked";} ?>>LIGHT</input>
            <input class="custom-radio mt-2" type="radio" name="theme" value="dark"<?php if ($_SESSION['theme'] == "dark") { echo "checked";} ?>>DARK</input>
          <?php

          if ($_SESSION['theme'] == "light") {
          }
          else{
            echo '<link href="..\..\assets\themes\dark_mode.css" rel="stylesheet">';
          }
           ?>
           <div>
             <input class="btn btn-secondary" type="submit" value="change theme">
           </div>
        </form>
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
                      <input class="btn btn-success mt-2" name='start' type="submit" value="Start">
                    </div>
                    <div class="col">
                      <label>Paginas</label>
                      <select class="form-control custom-select" name="tablaPaginacion">
                          <option>Ejecutar paginas</option>
                      </select>
                    </div>
                      <div class="col">
                        <label>Interrupciones</label>
                        <select class="form-control custom-select" name='interruptionTable'>
                            <option value="0" selected>Ninguna</option>
                            <option value="1">SVC de solicitud de I/O</option>
                            <option value="2">SVC de terminación normal</option>
                            <option value="3">SVC de solicitud de fecha</option>
                            <option value="4">Error de programa</option>
                            <option value="5">Externa de quantum expirado</option>
                            <option value="6">Dispositivo de I/O</option>
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
                                    <input type="text" class="form-control" placeholder="Nombre" name="process_name" >
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Páginas</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Páginas" name="process_pages" >
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Ejec Total</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" placeholder="Ejec Total" name="estimatedTime" >
                                  </div>
                                </div>
                                <br>
                                  <input name="createProcess" class="btn btn-info" type="submit" value=" + "></input>
                                  <?php
                                    if (isset($_POST['createProcess']))
                                    {
                                      if (empty($_POST['process_name']) or empty($_POST['estimatedTime']) or empty($_POST['process_pages']))
                                      {
                                          $_SESSION['attnum']--;
                                          echo '<script language="javascript">';
                                          echo 'alert("Tiene que llenar los campos del Proceso")';
                                          echo '</script>';
                                      }else {
                                        @$new_process = $functions->createProcess($_POST['process_name'], $_SESSION['attnum'], $_POST['estimatedTime'], 3);
                                        array_push($_SESSION['kernel']->lista_procesos_status->ready ,$new_process);
                                        unset ($_POST['createProcess']);
                                        @$_SESSION['createProcess'] = $_POST['createProcess'];
                                      }

                                    }
                                  ?>
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
                                        <?php
                                        foreach ($_SESSION['kernel']->lista_procesos_status->ready as $process) {
                                          if ($process) {
                                          echo '<tr>';
                                          echo '<th>'.$process->name.'</th>';
                                          echo "</tr>";
                                        }
                                      } ?>
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
                                          <?php
                                          foreach ($_SESSION['kernel']->lista_procesos_status->running as $process) {
                                            if ($process) {
                                            echo '<tr>';
                                            echo '<th>'.$process->name.'</th>';
                                            echo "</tr>";
                                          }
                                        } ?>
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
                                      <?php
                                            foreach ($_SESSION['kernel']->lista_procesos_status->blocked as $process) {
                                              if ($process) {
                                                echo '<tr>';
                                                echo '<th>'.$process->name.'</th>';
                                                echo "</tr>";
                                              }
                                            } ?>
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
                                          <?php
                                          foreach ($_SESSION['kernel']->lista_procesos_status->finished as $process) {
                                            if ($process) {
                                            echo '<tr>';
                                            echo '<th>'.$process->name.'</th>';
                                            echo "</tr>";
                                          }
                                        } ?>
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
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['kernel']->cpu->running_process->name; ?>" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Tiempo llegada</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['kernel']->cpu->running_process->arrival; ?>" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Tiempo Estimado</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['kernel']->cpu->running_process->estimated_time; ?>" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Envejecimiento</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['kernel']->cpu->running_process->calculateAging((int)$_SESSION['attnum']); ?>" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Cpu Restante</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['kernel']->cpu->running_process->remainingCpu(); ?>" disabled>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col">
                                    <p class="card-text">Quantum Restante</p>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control" name="quantumLeft" disabled value = "<?php
                                        if ($_SESSION['kernel']->order != "Round Robbin") {
                                          echo "N/A";
                                        }
                                        else {
                                          echo $_SESSION['kernel']->cpu->quantum_left();
                                        }
                                     ?>" >
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
                                    <div class="col">
                                        <select class="form-control custom-select" name="schedulingTable" onchange="assignQuantum()">
                                            <option value="0" id="schedule0"
                                            <?php if ($_POST['schedulingTable'] == "0") { echo "selected";}?> >FIFO</option>
                                            <option value="1" id="schedule1"
                                            <?php if ($_POST['schedulingTable'] == "1") { echo "selected";}?> >Round Robbin</option>
                                            <option value="2" id="schedule2"
                                            <?php if ($_POST['schedulingTable'] == "2") { echo "selected";}?> >Shortest Job First</option>
                                            <option value="3" id="schedule3"
                                            <?php if ($_POST['schedulingTable'] == "3") { echo "selected";}?> >Shortest Remaining Time</option>
                                            <option value="4" id="schedule4"
                                            <?php if ($_POST['schedulingTable'] == "4") { echo "selected";}?> >Highest Response</option>
                                            <option value="5" id="schedule5"
                                            <?php if ($_POST['schedulingTable'] == "5") { echo "selected";}?> >Multi Level Feedback Queues</option>
                                        </select>
                                      </div>
                                    </div>
                                  <br>
                                  <div class="row">
                                    <div class="col">
                                      <p class="card-text">Tam Quantum</p>
                                    </div>
                                    <div class="col">
                                      <input type="text" class="form-control" name="quantumSize" value="<?php echo @$_SESSION['quantumSize']; ?>">
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer text-muted">
                              </form>
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
                                    <th scope="col">NUR referencia</th>
                                    <th scope="col">NUR modificacion</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php for ($i=0; $i < count($_SESSION['kernel']->cpu->running_process->pages); $i++) {  ?>
                                <tr>
                                    <th scope="row"><?php echo $i+1 ?></th>
                                    <td><?php echo $_SESSION['kernel']->cpu->running_process->pages[$i]->residence ?></td>
                                    <td><?php echo $_SESSION['kernel']->cpu->running_process->pages[$i]->arrival ?></td>
                                    <td><?php echo $_SESSION['kernel']->cpu->running_process->pages[$i]->last_access ?></td>
                                    <td><?php echo $_SESSION['kernel']->cpu->running_process->pages[$i]->accesses ?></td>
                                    <td><?php echo $_SESSION['kernel']->cpu->running_process->pages[$i]->nur_referencia ?></td>
                                    <td><?php echo $_SESSION['kernel']->cpu->running_process->pages[$i]->nur_modificacion ?></td>
                                </tr>

                              <?php } ?>
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
