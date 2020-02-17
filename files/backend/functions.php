<?php
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

  public function timeButton()
  {
    session_start();
    // Page was not reloaded via a button press
      if (!isset($_POST['add']))
      {
          $_SESSION['attnum'] = 1; // Reset counter
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
}
 ?>
