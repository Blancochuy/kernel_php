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
    $aging = $actual_time - $this->arrival - ($this->estimated_time - $this->remainingCpu())-1;
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
    $this->quantum = (int)$quantum;
    $this->actual_time = $actual_time;
    $this->contQuantum = 0;
  }

  function addExecutionTime()
  {
    $this->running_process->execution_time++;
    $this->contQuantum++;
  }

  function is_running_process_finished()
  {
    if ($this->running_process instanceof stdClass) {
      return false;
    }
    else {
      $boolean = ($this->running_process->remainingCpu() == 0);
      return $boolean;
    }
  }

  function is_ready_process_running()
  {
    if ($this->is_running_process_finished()) {
      return true;
    }
    return false;
  }

  function quantum_left()
  {
    return $this->quantum - $this->contQuantum;
  }

  function is_quantum_over()
  {
    if ($this->quantum == $this->contQuantum) {
      return true;
    }
    return false;
  }
  //INTERRUPTIONS (Receive Interruption as parameter)
  /* de running a blocked*/
  function is_io_interruption($interruption)
  {
    if ($interruption == "SVC de solicitud de I/O")
    {
      return true;
    }
    return false;
  }

  function is_date_request($interruption)
  {
    if ($interruption == "SVC de solicitud de fecha")
    {
      return true;
    }
    return false;
  }

  /*De running a finished*/
  function is_normal_termination($interruption)
  {
    if ($interruption == "SVC de terminacion normal")
    {
      return true;
    }
    return false;
  }

  function is_program_error($interruption)
  {
    if ($interruption == "Error de programa")
    {
      return true;
    }
    return false;
  }

  /*De blocked a ready*/
  function is_io_device($interruption)
  {
    if ($interruption == "Dispositivo de I/O")
    {
      return true;
    }
    return false;
  }
}
//PRUEBAS OBJETOS
/*

*/
 ?>
