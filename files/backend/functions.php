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
      if (!isset($_POST['reset']))
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
    return $process_data;
  }
}
 ?>
