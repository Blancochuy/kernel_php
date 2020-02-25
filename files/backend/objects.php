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
    // Method to find the waiting time for all
    // processes
    function findWaitingTime($processes, $n, $bt, $wt, $quantum)
    {
        // Make a copy of burst times bt[] to store remaining
        // burst times.
        $rem_bt = []; //arr tamaño n
        for ($i = 0 ; $i < $n ; $i++)
            $rem_bt[$i] =  $bt[$i];

        //var_dump($rem_bt);
        $t = 0; // Current time

        // Keep traversing processes in round robin manner
        // until all of them are not done.
        while(true)
        {
            $done = true;

            // Traverse all processes one by one repeatedly
            for ($i = 0 ; $i < $n; $i++)
            {
                // If burst time of a process is greater than 0
                // then only need to process further
                if ($rem_bt[$i] > 0)
                {
                    $done = false; // There is a pending process

                    if ($rem_bt[$i] > $quantum)
                    {
                        // Increase the value of t i.e. shows
                        // how much time a process has been processed
                        $t += $quantum;

                        // Decrease the burst_time of current process
                        // by quantum
                        $rem_bt[$i] -= $quantum;
                    }

                    // If burst time is smaller than or equal to
                    // quantum. Last cycle for this process
                    else
                    {
                        // Increase the value of t i.e. shows
                        // how much time a process has been processed
                        $t = $t + $rem_bt[$i];

                        // Waiting time is current time minus time
                        // used by this process
                        $wt[$i] = $t - $bt[$i];

                        // As the process gets fully executed
                        // make its remaining burst time = 0
                        $rem_bt[$i] = 0;
                    }
                }
            }
            // If all processes are done
            if ($done == true)
              return $wt;
        }
    }

    // Method to calculate turn around time
    function findTurnAroundTime($processes, $n, $bt, $wt, $tat)
    {
        // calculating turnaround time by adding
        // bt[i] + wt[i]
        for ($i = 0; $i < $n ; $i++)
        {
            $tat[$i] = ($bt[$i] + $wt[$i]);
        }

        return $tat;
    }
    // Method to calculate average time
    function findavgTime($processes, $n, $bt, $quantum)
    {
        $wt = array_fill(0, $n, 0); //arr tamaño n
        $tat = array_fill(0, $n, 0); //arr tamaño n
        $total_wt = 0;
        $total_tat = 0;

        // Function to find waiting time of all processes
        $wt = findWaitingTime($processes, $n, $bt, $wt, $quantum);

        // Function to find turn around time for all processes
        $tat = findTurnAroundTime($processes, $n, $bt, $wt, $tat);
        // Display processes along with all details
        printf("Processes "." Burst time "." Waiting time "." Turn around time");

        // Calculate total waiting time and total turn
        // around time
        for ($i=0; $i<$n; $i++)
        {
            $total_wt = $total_wt + $wt[$i];
            print("\n");
            $total_tat = $total_tat + $tat[$i];
            printf(" " .($i+1) . "\t\t" . $bt[$i] ."\t " . $wt[$i] ."\t\t " . $tat[$i]);
        }

        printf("\n\nAverage waiting time = ".($total_wt / $n));
        printf("\nAverage turn around time = ".($total_tat / $n));
    }
    // Driver Method
        // process id's
        $processes = array_merge($this->running, $this->blocked, $this->ready);
        $n = count($processes);

        // Burst time of all processes
        $burst_time = array(10, 5, 8);

        // Time quantum
        $quantum = 5;

        findavgTime($processes, $n, $burst_time, $quantum);
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

    return $actual_time - $arrival - $execution_time;
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
