<?php
class Kernel
{

  function __construct(StatusProcess $lista_procesos_status, Cpu $cpu, $order, $interruption)
  {
    $this->lista_procesos_status = $lista_procesos_status;
    $this->cpu = $cpu;
    $this->order = $order;
    $this->interruption = $interruption;
  }

  public function updateInterruption($value)
  {
    $functions = new Functions();
    $this->interruption = $functions->getInterruption($value);
  }

  public function updateOrder($value)
  {
    $functions = new Functions();
    $this->order = $functions->getOrder($value);
  }

  public function updateCpu()
  {
    $new_process = $this->lista_procesos_status->running[0];
    $this->cpu->running_process = $new_process;
  }

  //(1-running, 2-blocked, 3-ready, 4-finished)
  public function running_to_finished()
  {
    if ($this->cpu->running_process_finished())
    {
      $finished_process= array_pop($this->lista_procesos_status->running);
      array_push($this->lista_procesos_status->finished, $finished_process);
      $this->updateCpu();
    }
  }

  public function ready_to_running()
  {
    if ($this->cpu->ready_process_running() or $this->cpu->running_process_blocked($this->interruption))
    {
      $running_process= array_pop($this->lista_procesos_status->ready);
      array_unshift($this->lista_procesos_status->running, $running_process);
      $this->updateCpu();
    }
  }

  public function running_to_blocked()
  {
    if ($this->cpu->running_process_blocked($this->interruption))
    {
      $blocked_process= array_pop($this->lista_procesos_status->running);
      array_push($this->lista_procesos_status->blocked, $blocked_process);
      $this->updateCpu();
    }
  }

  public function blocked_to_ready()
  {

  }
}

 ?>
