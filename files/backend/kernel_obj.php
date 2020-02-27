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
/* ORDER VALUES
  "0" FIFO
  "1" Round Robbin
  "2" Shortest Job First
  "3" Shortest Remaining Time
  "4" Highest Response
  "5" Multi Level Feedback Queues
*/

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
    if ($this->cpu->is_running_process_finished() or
        $this->cpu->is_normal_termination($this->interruption) or
        $this->cpu->is_program_error($this->interruption))
    {
      $finished_process= array_shift($this->lista_procesos_status->running);
      array_unshift($this->lista_procesos_status->finished, $finished_process);
      if (!empty($this->lista_procesos_status->ready)) {
        $this->ready_to_running();
      }
    }
    $this->updateCpu();
  }

  public function ready_to_running()
  {
    $running_process= array_shift($this->lista_procesos_status->ready);
    array_unshift($this->lista_procesos_status->running, $running_process);
    $this->updateCpu();
  }

  public function running_to_blocked()
  {
    if ($this->cpu->is_io_interruption($this->interruption) or
        $this->cpu->is_date_request($this->interruption))
    {
      $blocked_process= array_shift($this->lista_procesos_status->running);
      array_unshift($this->lista_procesos_status->blocked, $blocked_process);
      if (!empty($this->lista_procesos_status->ready)) {
        $this->ready_to_running();
      }
    }
    $this->updateCpu();
  }

  public function blocked_to_ready()
  {
    if ($this->cpu->is_io_device($this->interruption))
    {
      if (!empty($this->lista_procesos_status->blocked)) {
        $ready_process= array_shift($this->lista_procesos_status->blocked);
        array_push($this->lista_procesos_status->ready, $ready_process);
        $this->updateCpu();
        }
      }
    }
}

 ?>
