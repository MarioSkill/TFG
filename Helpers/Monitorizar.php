<?php
/**
* 
*/

namespace BenchmarkBundle\Helpers;
class Monitorizar extends \Thread {

	private $dat;
	private $monitorizar;
	private $containerName;
	public $resultados;

	function __construct($id){
		$this ->i = 1;
		$this -> containerName = $id;
		$this -> monitorizar = true;
	}

	public function getMonitorizar(){
		return $this->monitorizar;
	}

	public function setMonitorizar($monitorizar){
		$this->monitorizar = $monitorizar;
	}

	public function getContainerName(){
		return $this->containerName;
	}

	public function setContainerName($containerName){
		$this->containerName = $containerName;
	}

	public function getResultados(){
		return $this->resultados;
	}

	function getServerMemoryUsage(){
		$free = shell_exec('free');
		$free = (string)trim($free);
		$free_arr = explode("\n", $free);
		$mem = explode(" ", $free_arr[1]);
		$mem = array_filter($mem);
		$mem = array_merge($mem);
		$memory_usage = $mem[2]/$mem[1]*100;


		return $memory_usage;
	}
	function getServerCpuUsage(){
		#by Paul Colby (http://colby.id.au), no rights reserved ;)
		//$load = sys_getloadavg();
		//$r =shell_exec("grep 'cpu ' /proc/stat | awk '{usage=($2+$4)*100/($2+$4+$5)} END {print usage}'");
		//return str_replace(array("\r", "\n"), '', $r);
		//$exec_loads = sys_getloadavg();
		//$exec_cores = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
		//$cpu = round($exec_loads[0]/($exec_cores )*100, 0);
		$cpu = round( shell_exec("mpstat | grep -A 5 \"%idle\" | tail -n 1 | awk -F \" \" '{print 100 -  $ 12}'a"),2);
		return $cpu;
	}
	public function run() {
		$i =0;
		$cpu = [];
		$ram = [];
		$PREV_TOTAL=0;
		$PREV_IDLE=0;
		while ($this->monitorizar == true) {

		  $CPU=shell_exec("sed -n 's/^cpu\s//p' /proc/stat");
		  $CPU = preg_split('/\s+/', trim($CPU));
		  $IDLE=$CPU[3]; # Just the idle CPU time.
		  # Calculate the total CPU time.
		  $TOTAL=0;
		  foreach($CPU as $VALUE){
		    $TOTAL=$TOTAL+$VALUE;
		  }
		 
		  # Calculate the CPU usage since we last checked.
		  $DIFF_IDLE=$IDLE-$PREV_IDLE;
		  $DIFF_TOTAL=$TOTAL-$PREV_TOTAL;
		  $DIFF_USAGE=(1000 * ($DIFF_TOTAL-$DIFF_IDLE)/$DIFF_TOTAL+5)/10;
		  //echo "\rCPU: $DIFF_USAGE\n";
		 
		  # Remember the total and idle CPU times for the next check.
		  $PREV_TOTAL=$TOTAL;
		  $PREV_IDLE=$IDLE;



			$ram[$i] = round($this -> getServerMemoryUsage(),2);
			$cpu[$i] = round($DIFF_USAGE,2);
			//$this -> resultados["RAM" => [$i => $this -> getServerMemoryUsage()]];
			$i++;
			sleep(1);
		}

		$this -> resultados=[
			"RESPONSE" => "GETDATA_OK",
			"CPU" => $cpu,
			"RAM"=>$ram
		];
	}
}
/*
$a = new Monitorizar(1);
$a->start();
sleep(3);
$a->setMonitorizar(false);

sleep(1);
$r=$a ->getResultados();



echo "<pre>";
print_r($r);*/

?>