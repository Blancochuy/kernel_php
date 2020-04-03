<?php
require('objects.php');
class Functions
{
  public function getData($file_link)
  {
    /*
    Link ejemplo de input
      https://gist.githubusercontent.com/Blancochuy/1e8a575d1b399888ed0dfdd1711c2cc8/raw/762ba487488054b74de342a96008715b53aaaa4a/ejecuci%25C3%25B3n.txt
    */
    $página_inicio = file_get_contents($file_link);
    $stripped = str_replace(' ', '', $página_inicio);
    $str = preg_replace('#\s+#',',',trim($stripped));
    $myData = explode(',', $str);
    return $myData;
    //return var_dump("Max paginas: ".$max_pag." Tiempo reloj: ".$tiempo_reloj." Num Procesos ".$num_proc);
  }

  public function timeButton($val)
  {
    session_start();
    // Page was not reloaded via a button press
      if (!isset($_POST['add']))
      {
          $_SESSION['attnum'] = $val[1]; // Reset counter
      }
      if (!isset($_POST['start']))
      {
        $reem = array("attnum" => 0);
        $reiniciar = array_replace($reem);
      }
  }

  public function getVariabels($myArr)
  {
    $valores = array_slice($myArr, 0,3);
    $procArr = array_slice($myArr, 3);
    return array($valores, $procArr);
  }

//  Procesos
  public function numeroPaginasProcesos($num_procesos, $procesos)
  {
    $paginas_procesos = [];
    $datos_cpu_proc = 3;
    $datos_memoria = 6;
    $index_global = 0;

    $cont = 0;

    for ($i = 0; $i < $num_procesos; $i++) {
        $index_global+=3;
        $paginas = $procesos[$index_global];
        array_push($paginas_procesos, $paginas);
        for ($j = 0; $j < $paginas; $j++) {
            $index_global+=$datos_memoria;
        }
        $index_global++;
    }
    return $paginas_procesos;
  }

  public function getProcessData($num_procesos, $procesos)
  {
    $datos_cpu_proc = 3;
    $datos_memoria = 6;
    $index_global = 0;
    $process_data = [];
    $aux_procesos = $procesos;

    for ($i = 0; $i < $num_procesos; $i++) {

        array_push($process_data, array_slice($procesos, $index_global, 3));

        //
        $index_global+=3;
        $paginas = $procesos[$index_global];
        for ($j = 0; $j < $paginas; $j++) {
            $index_global+=$datos_memoria;
        }
        $index_global++;
    }

    $datos_memoria_procesos = [];

    for ($i = 0; $i < $num_procesos; $i++)
    {
        $aux_procesos = array_slice($aux_procesos, 3);
        $num_paginas_proc = array_shift($aux_procesos);
        for($j = 0; $j < $num_paginas_proc; $j++)
        {
            $page = array_slice($aux_procesos, 0, 6);
            $aux_procesos = array_slice($aux_procesos, 6);
            array_push($datos_memoria_procesos, $page);
            $page = null;
        }
        array_push($process_data[$i], $datos_memoria_procesos);
        $datos_memoria_procesos = [];
    }

    return $process_data;
  }

  public function createProcessList($process_data)
  {
    //parametros de objeto Process
    $arrival;
    $estimated_time;
    $status;
    $pages;
    //arreglo de objetos Process
    $arr_process = [];

    $num_procesos = count($process_data);
    for ($i=0; $i < $num_procesos; $i++) {
      for ($j=0; $j < 4; $j++) {
        switch ($j) {
            case 0:
                $arrival = $process_data[$i][$j];
                break;
            case 1:
                $estimated_time = $process_data[$i][$j];
                break;
            case 2:
                $status = $process_data[$i][$j];
                break;
            case 3:
                $pages = $this->createPages($process_data[$i][$j]);
                break;
        }
      }
      $process = new Process($i+1, $arrival, $estimated_time, $status, $pages);
      array_push($arr_process, $process);
    }
    return $arr_process;
  }


  public function getInterruption($value) {
    $interruption = "";

    switch ($value) {
      case 0:
        $interruption = "Ninguna";
        break;
      case 1:
        $interruption = "SVC de solicitud de I/O";
        break;
      case 2:
        $interruption = "SVC de terminacion normal";
        break;
      case 3:
        $interruption = "SVC de solicitud de fecha";
        break;
      case 4:
        $interruption = "Error de programa";
        break;
      case 5:
        $interruption = "Externa de quantum expirado";
        break;
      case 6:
        $interruption = "Dispositivo de I/O";
        break;
    }
    return $interruption;
  }

  public function getOrder($value) {
    $order = "";
    switch ($value) {
      case 0:
        $order = "FIFO";
        break;
      case 1:
        $order = "Round Robbin";
        break;
      case 2:
        $order = "Shortest Job First";
        break;
      case 3:
        $order = "Shortest Remaining Time";
        break;
      case 4:
        $order = "Highest Response";
        break;
      case 5:
        $order = "Multi Level Feedback Queues";
        break;
    }
    return $order;
  }

  //CREACION DE OBJECTS
  public function createStatusProcess($obj_process_arr)
  {
    $lista_procesos_status = new StatusProcess([],[],[],[]);

    foreach ($obj_process_arr as $key => $process) {
      switch ($process->status) {
        case '1':
          array_push($lista_procesos_status->running, $process);
          break;
        case '2':
          array_push($lista_procesos_status->blocked, $process);
          break;
        case '3':
          array_push($lista_procesos_status->ready, $process);
          break;
      }
    }
    return $lista_procesos_status;
  }

  public function createCpu($running_process, $quantum, $cpu_time)
  {
    return new Cpu($running_process, $quantum, $cpu_time);
  }

  public function createProcess($name, $arrival, $estimated_time, $status, $pages)
  {
    return new Process($name, $arrival, $estimated_time, $status, $pages);
  }

  public function createPages($arr_pages)
  {
    $process_pages = [];
    foreach ($arr_pages as $key => $page) {
      $residence = $page[0];
      $arrival = $page[1];
      $last_access = $page[2];
      $accesses = $page[3];
      $nur_referencia = $page[4];
      $nur_modificacion = $page[5];

      $page = new Page($residence, $arrival, $last_access, $accesses, $nur_referencia, $nur_modificacion);
      array_push($process_pages, $page);
    }
    return $process_pages;
  }

  public function initializePages($num_paginas)
  {
    $process_pages = [];
    for ($i=0; $i < $num_paginas; $i++) {
      $page = new Page(0, 0 , 0 ,0 ,0 ,0);
      array_push($process_pages, $page);
    }
    return $process_pages;
  }

}
  //PRUEBAS FUNCIONES
  /*
    $functions = new Functions();
    //Funcion para extraer los valores del archivo txt

    $myData = $functions->getData("https://gist.githubusercontent.com/Blancochuy/1e8a575d1b399888ed0dfdd1711c2cc8/raw/762ba487488054b74de342a96008715b53aaaa4a/ejecuci%25C3%25B3n.txt");

    //funcion para partir el areglos
    $arrss = $functions->getVariabels($myData);
    $valores = $arrss[0];
    $procesos = $arrss[1];

    //Funcion de tiempo
    $button = $functions->timeButton($valores);

    //Datos de procesos
    $num_procesos = $valores[2];
    //Numero de paginas
    $paginas_procesos = $functions->numeroPaginasProcesos($num_procesos, $procesos);
    //Atributos de todos los procesos
    $process_data = $functions->getProcessData($num_procesos, $procesos);
    //crear Interrupcion
    $interruption = $functions->createInterruption("0");
    //crear lista de procesos
    $obj_process_arr = $functions->createProcessList($process_data);
    //lista status procesos
    $lista_procesos_status = $functions->createStatusProcess("1", $interruption, $obj_process_arr);
    var_dump($lista_procesos_status);
  */
?>
