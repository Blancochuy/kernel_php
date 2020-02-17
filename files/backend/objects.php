<?php
class StatusProcess
{
  function __construct($ready, $running, $blocked, $order, Interruption $interruption)
  {
      //processes divided by status
      $this->ready = $ready;
      $this->running = $running;
      $this->blocked = $blocked;
      //schedule order
      $this->order = $order;
      //nombre de interrupcion
      $this->interruption = $interruption;
  }
}

class Process
{
  // datos CPU proc1: llegada, tiempo total estimado, estado (1-running, 2-blocked, 3-ready)
  function __construct($nombre, $arrival, $estimated_time, $status)
  {
    $this->nombre = $nombre;
    $this->arrival = $arrival;
    $this->estimated_time = $estimated_time;
    $this->status = $status;
  }
}

class Interruption
{
  function __construct($tipo)
  {
    $this->tipo = $tipo;
  }
}
 ?>
