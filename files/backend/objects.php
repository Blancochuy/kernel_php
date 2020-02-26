<?php
class StatusProcess
{
  function __construct($running, $blocked, $ready, $finished)
  {
      //processes divided by status
      $this->running = $running;
      $this->blocked = $blocked;
      $this->ready = $ready;
      $this->finished = $finished;
  }
}

class Process
{
  //datos CPU proc1: llegada, tiempo total estimado, estado (1-running, 2-blocked, 3-ready, 4-finished)
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
    $waiting = $actual_time - $this->arrival;
    $execution_time = $this->execution_time;
    $aging = ($waiting-1) + (1*$execution_time);
    return $aging;
  }
  function remainingCpu()
  {
    $estimated_time = $this->estimated_time;
    $execution_time = $this->execution_time;

    return $estimated_time - $execution_time;
  }
}

class Cpu
{
  function __construct($running_process, $quantum, $actual_time)
  {
    $this->running_process = $running_process;
    $this->quantum = $quantum;
    $this->actual_time = $actual_time;
  }
  function addExecutionTime()
  {
    $this->running_process->execution_time++;
  }

  function running_process_finished()
  {
    $boolean = (($this->running_process->remainingCpu()) == 0);
    return $boolean;
  }

  function running_process_blocked($interruption)
  {
    if ($interruption == "SVC de solicitud de I/O") {
      return true;
    }
    return false;
  }

  function ready_process_running()
  {
    if ($this->running_process_finished()) {
      return true;
    }
    return false;
  }
}
//PRUEBAS OBJETOS
/*

*/
 ?>
