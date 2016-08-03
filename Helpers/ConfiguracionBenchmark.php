<?php

namespace BenchmarkBundle\Helpers;

class ConfiguracionBenchmark {

	private $rutaProyecto;
	private $rutaDatosDocker;
	private $paramEjucucion;
	private $memoriaMaximaDocker;

	function __construct($memoriaUsar=80) {
		$this -> rutaProyecto	= "/var/www/default/TFG2/src/BenchmarkBundle/Resources/public/tfg/resources/";
		$this -> rutaDatosDocker ='/bigData/';// /bigData
		$this -> paramEjucucion = '';
		$totalMemoria = shell_exec("cat /proc/meminfo | grep MemTotal: | awk '{print $2/1000}'");
		$this -> memoriaMaximaDocker = round((($totalMemoria * $memoriaUsar) /100),0);


	}

	public function getRutaProyecto(){
		return $this->rutaProyecto;
	}

	public function getMemoriaMaximaDocker(){
		return $this -> memoriaMaximaDocker;
	}

	public function setRutaProyecto($rutaProyecto){
		$this->rutaProyecto = $rutaProyecto;
	}

	public function getRutaDatosDocker(){
		return $this->rutaDatosDocker;
	}

	public function setRutaDatosDocker($rutaDatosDocker){
		$this->rutaDatosDocker = $rutaDatosDocker;
	}
	public function setParamEjucucion($paramEjucucion){
		$this -> paramEjucucion=$paramEjucucion;
	}
	public function getParamEjucucionByNombre($nombre){
		switch ($nombre) {
			case 'SPARK':
				$this -> paramEjucucion = "--master local[*] --driver-memory 4G --executor-memory 6g ";
				break;
			case 'FLINK':
				$this -> paramEjucucion = "";
				break;
			case 'STORM':
				$this -> paramEjucucion = "";
				break;
			default:
				$this -> paramEjucucion="ERROR";
				break;
		}
		return $this -> paramEjucucion;
	}
}
?>
