<?php
class StatusProcess
{
  function __construct($running, $blocked, $ready, $order, Interruption $interruption)
  {
      //processes divided by status
      $this->running = $running;
      $this->blocked = $blocked;
      $this->ready = $ready;
      //schedule order
      $this->order = $order;
      //nombre de interrupcion
      $this->interruption = $interruption;
  }

  //PENDIENTE A RECIBIR PARAMETROS
  function roundRobin()
  {
  }
}

class Process
{
  //datos CPU proc1: llegada, tiempo total estimado, estado (1-running, 2-blocked, 3-ready)
  function __construct($name, $arrival, $estimated_time, $status)
  {
    $this->name = $name;
    $this->arrival = $arrival;
    $this->estimated_time = $estimated_time;
    $this->status = $status;
    $this->execution_time = 0;

  }
  function calculateAging($actual_time)
  {
    $arrival = $this->arrival;
    $execution_time = $this->execution_time;
    $aging = $actual_time - $arrival - $execution_time;
    return $aging;
  }
  function remainingCpu()
  {
    $estimated_time = $this->estimated_time;
    $execution_time = $this->execution_time;

    return $estimated_time - $execution_time;
  }
}

class Interruption
{
  function __construct($tipo)
  {
    $this->tipo = $tipo;
  }
}

class Order
{
  function __construct($tipo)
  {
    $this->tipo = $tipo;
  }
}

class Cpu
{
  function __construct($running_process, $order, $quantum, $actual_time)
  {
    $this->running_process = $running_process;
    $this->scheduling_order = $order;
    $this->quantum = $quantum;
    $this->actual_time = $actual_time;
  }
  function addExecutionTime()
  {
    $this->running_process->execution_time++;
  }
}
//PRUEBAS OBJETOS
/*

*/
 ?>
