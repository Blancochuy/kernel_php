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

  public function run()
  {
    switch ($this->order) {
      case "FIFO":
        $this->running_to_finished();
        $this->running_to_blocked();
        $this->blocked_to_ready();
        break;

      case "Round Robbin":
        $this->running_to_finished_rr();
        $this->running_to_blocked_rr();
        $this->blocked_to_ready_rr();
        break;

      case "Shortest Job First":
        $this->running_to_finished_sjf();
        $this->running_to_blocked_sjf();
        $this->blocked_to_ready_sjf();
        break;

      case "Shortest Remaining Time":
        $this->running_to_finished_srt();
        $this->running_to_blocked_srt();
        $this->blocked_to_ready_srt();
        break;

      case "Highest Response":
        $this->running_to_finished_hrt();
        $this->running_to_blocked_hrt();
        $this->blocked_to_ready_hrt();
        break;

      case "Multi Level Feedback Queues":
        $this->running_to_finished_mlfq();
        $this->running_to_blocked_mlfq();
        $this->blocked_to_ready_mlfq();
        break;
    }
  }
  //(1-running, 2-blocked, 3-ready, 4-finished)
  #<---------Round Robin----------->
    public function running_to_finished_rr()
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

    public function ready_to_running_rr()
    {
      $running_process= array_shift($this->lista_procesos_status->ready);
      array_unshift($this->lista_procesos_status->running, $running_process);
      $this->updateCpu();
    }

    public function running_to_blocked_rr()
    {
      if ($this->cpu->is_io_interruption($this->interruption) or
          $this->cpu->is_date_request($this->interruption) or
          $this->cpu->is_quantum_over())
      {
        $blocked_process= array_shift($this->lista_procesos_status->running);
        array_unshift($this->lista_procesos_status->blocked, $blocked_process);
        if (!empty($this->lista_procesos_status->ready)) {
          $this->ready_to_running();
        }
        if($this->cpu->is_quantum_over() == true) {
          $this->cpu->contQuantum = 0;
        }
      }
      $this->updateCpu();
    }

    public function blocked_to_ready_rr()
    {
      if ($this->cpu->is_io_device($this->interruption))
      {
        if (!empty($this->lista_procesos_status->blocked))
         {
           $ready_process= array_shift($this->lista_procesos_status->blocked);
           array_unshift($this->lista_procesos_status->ready, $ready_process);
           $this->updateCpu();
        }
      }
    }

    #<---------Shortest Job First----------->
    public function running_to_finished_sjf()
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

    public function ready_to_running_sjf()
    {
      $running_process= array_shift($this->lista_procesos_status->ready);
      array_unshift($this->lista_procesos_status->running, $running_process);
      $this->updateCpu();
    }

    public function running_to_blocked_sjf()
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

    public function blocked_to_ready_sjf()
    {
      if ($this->cpu->is_io_device($this->interruption))
      {
        if (!empty($this->lista_procesos_status->blocked))
         {
           $ready_process= array_shift($this->lista_procesos_status->blocked);
           array_unshift($this->lista_procesos_status->ready, $ready_process);
           $this->updateCpu();
        }
      }
    }

    #<---------Shortest Remaining Time----------->
    public function running_to_finished_srt()
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

    public function ready_to_running_srt()
    {
      $running_process= array_shift($this->lista_procesos_status->ready);
      array_unshift($this->lista_procesos_status->running, $running_process);
      $this->updateCpu();
    }

    public function running_to_blocked_srt()
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

    public function blocked_to_ready_srt()
    {
      if ($this->cpu->is_io_device($this->interruption))
      {
        if (!empty($this->lista_procesos_status->blocked))
         {
           $ready_process= array_shift($this->lista_procesos_status->blocked);
           array_unshift($this->lista_procesos_status->ready, $ready_process);
           $this->updateCpu();
        }
      }
    }

    #<---------Highest Response Time----------->
    public function running_to_finished_hrt()
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

    public function ready_to_running_hrt()
    {
      $running_process= array_shift($this->lista_procesos_status->ready);
      array_unshift($this->lista_procesos_status->running, $running_process);
      $this->updateCpu();
    }

    public function running_to_blocked_hrt()
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

    public function blocked_to_ready_hrt()
    {
      if ($this->cpu->is_io_device($this->interruption))
      {
        if (!empty($this->lista_procesos_status->blocked))
         {
           $ready_process= array_shift($this->lista_procesos_status->blocked);
           array_unshift($this->lista_procesos_status->ready, $ready_process);
           $this->updateCpu();
        }
      }
    }

    #<---------Multiple Level Feedback Queues----------->
    public function running_to_finished_mlfq()
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

    public function ready_to_running_mlfq()
    {
      $running_process= array_shift($this->lista_procesos_status->ready);
      array_unshift($this->lista_procesos_status->running, $running_process);
      $this->updateCpu();
    }

    public function running_to_blocked_mlfq()
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

    public function blocked_to_ready_mlfq()
    {
      if ($this->cpu->is_io_device($this->interruption))
      {
        if (!empty($this->lista_procesos_status->blocked))
         {
           $ready_process= array_shift($this->lista_procesos_status->blocked);
           array_unshift($this->lista_procesos_status->ready, $ready_process);
           $this->updateCpu();
        }
      }
    }

    #<---------FIFO----------->
    public function running_to_finished()
    {

      if ($this->cpu->is_running_process_finished() or
          $this->cpu->is_normal_termination($this->interruption) or
          $this->cpu->is_program_error($this->interruption))
      {
        $finished_process = array_shift($this->lista_procesos_status->running);
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
        if (!empty($this->lista_procesos_status->blocked))
         {
           $ready_process= array_shift($this->lista_procesos_status->blocked);
           array_unshift($this->lista_procesos_status->ready, $ready_process);
           $this->updateCpu();
        }
        if (empty($this->lista_procesos_status->running)) {
          $this->ready_to_running();
        }
      }
    }
}

 ?>