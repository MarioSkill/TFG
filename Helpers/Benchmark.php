<?php  

namespace BenchmarkBundle\Helpers;
use BenchmarkBundle\Bin\Shell;
use BenchmarkBundle\Entity\Test;
use BenchmarkBundle\Entity\Estado;
use BenchmarkBundle\Entity\Configuracion;
use BenchmarkBundle\Entity\Scriptbenchmark;
use BenchmarkBundle\Entity\Comparativa;
use BenchmarkBundle\Entity\Scripts;
use BenchmarkBundle\Entity\Resultado;
use BenchmarkBundle\Helpers\ClientSocket;
use BenchmarkBundle\Helpers\ConfiguracionBenchmark;
/**
* 
*/
class Benchmark {

	private $em; //Entity Manager
	private $programa;
	private $algoritmo;
	private $FicheroDatos;
	private $tipoPrueba;
	private $rutaProyecto;
	private $rutaDatosDocker;
	private $shell;
	private $monitor;
	private $paramEjecucion;
	private $confAdicionalByAlgoritmo;
	private $maxMemoriaDocker;

	function __construct(
		$em,$programa,$algoritmo,$FicheroDatos,$rutaProyecto,$rutaDatosDocker,$paramEjecucion=null,$confAdicionalByAlgoritmo=null) {
		$this -> em 			= $em;
		$this -> programa		= $programa;
		$this -> algoritmo 		= $algoritmo;
		$this -> FicheroDatos	= $FicheroDatos;
		$this -> rutaProyecto	= $rutaProyecto;// /var/www/html/TFG2/src/BenchmarkBundle/Resources/public/tfg/resources/
		$this -> rutaDatosDocker =$rutaDatosDocker;// /bigData
		$this -> shell = new Shell();
		$this -> monitor = new ClientSocket();

		if($confAdicionalByAlgoritmo==null){
			$this ->confAdicionalByAlgoritmo ="";
		}else{
			$this ->confAdicionalByAlgoritmo =$confAdicionalByAlgoritmo." ";
		}
		$c = new ConfiguracionBenchmark();
		$this -> maxMemoriaDocker = $c -> getMemoriaMaximaDocker();

		if ($paramEjecucion != null){
			$this -> paramEjecucion = $paramEjecucion." ";
		}else{
			$this -> paramEjecucion=null;
		}

		if ($this -> programa != null) {

			if(strcasecmp($this -> programa[0] -> getNombre(),"TODOS") == 0 ) {
				$this -> programa[0] -> setEM ( $this -> em );
				$this -> programa = $this -> programa[0] -> getTodosProgramas ();

			}

			$this -> tipoPrueba		= count($this -> programa);

		}



	}

	public function crearPrueba() {
		$task =array();
		//Guardamos las pruebas en la BBDD
		for ($i=0; $i < $this -> tipoPrueba; $i++) { 
			$task[$i]=$this ->crearTask($i);
		}

		//Si se ha lanzado una prueba conjunta, la guardamos como una comparativa 

		if ( $this -> tipoPrueba > 1 ){
			$time=new \DateTime();
			$comparativaID = $this -> getNextIDComparativa();
			for ($i=0; $i <count($task); $i++) { 
				$c = new Comparativa($this -> em,$comparativaID,$time,$task[$i]);
				$c -> setId($comparativaID);
				$this -> em -> persist($c);
		        $this -> em -> flush();
		        $c="";
		        $c=null;
			}
		}

		if($this -> HayTareasEnEjecucion() == 0){
			return $this -> lanzarSiguienteTarea();
		}
		return "Docker en ejecucion";

	}


	private function crearTask($i) {
		$test = new Test($this -> em); 
		$estado = new Estado ($this -> em);
		$config = new Configuracion ($this -> em);
		$scriptBenchmark =new Scriptbenchmark();
		$time=new \DateTime();
		$nombreContenedor = $this -> programa[$i] -> getNombre().'_'. $time -> format('d_m_Y_s').'_'.md5(uniqid(rand(), true));


		$scriptBenchmark -> setContenido("null");
		$scriptBenchmark -> setRuta($this -> rutaProyecto."medir_".$this -> programa[$i] -> getNombre().".sh");
		

		$config -> setOp("SetAndNext");
		$config -> setFicherosalida($this -> rutaDatosDocker."result/response_".$nombreContenedor.".txt");
		$config -> setLogs($this -> rutaDatosDocker."logs/log".$this -> programa[$i] -> getNombre().".txt");
		

		$dockerImagen ="ubuntu-".strtolower($this -> programa[$i] -> getNombre()).":latest";
		$test -> setComand(
			"docker run --name ".$nombreContenedor." -m ".$this ->maxMemoriaDocker."m -v ".$this -> rutaProyecto.":".$this -> rutaDatosDocker." -dit ".$dockerImagen.
			" ".$this -> rutaDatosDocker."medir_".$this -> programa[$i] -> getNombre().".sh"
			); 
		$test -> setContainerName($nombreContenedor);


		$test -> setPrograma($this -> programa[$i]);
		$test -> setEstado($estado -> getEstadoBy('Programado'));
		$test -> setFichero($this -> FicheroDatos);
		$test -> setAlgoritmo($this -> algoritmo);
		$test -> setConfiguracion($config);


		$script = $this -> crearScript( $test->getPrograma(), $test->getAlgoritmo(),$test->getContainerName(),$test->getConfiguracion() );
		
		$scriptBenchmark-> setContenido($script);
        $test -> setScriptbenchmark ($scriptBenchmark);

        $config ->setParamejucucion($this -> paramEjecucion);
        $this -> paramEjecucion=null;


		$this -> em -> persist($scriptBenchmark);
		$this -> em -> persist($config);
		$this -> em -> persist($test);
        $this -> em -> flush();
        return $test;
	}

	public function crearScript($programa,$algoritmo,$nombreContenedor,$configuracion){
		$script = new Scripts($this -> em);

		$script =$script -> getDataByAlgoritmoYPrograma($algoritmo,$programa);

        $base=file_get_contents($this -> rutaProyecto.'script/medir.sh');

        $in_aux="";
        $out_aux="";
        $separador ="2> ";
        
        if ( strcasecmp($programa -> getNombre(),'FLINK') == 0 ){
        	$base = str_replace('#flink_jobManager','/flink/start-local.sh',$base);
        	$in_aux="--input ";
       		$out_aux="--output ";
       		$separador="> ";
        }else if (strcasecmp($programa -> getNombre(),'STORM') == 0 ){
        	$servicios ='/usr/local/src/apache-storm-$STORM_VERSION/bin/storm nimbus&'.PHP_EOL;
        	$servicios .='/usr/local/src/apache-storm-$STORM_VERSION/bin/storm supervisor&'.PHP_EOL;
        	$servicios .= '/usr/local/src/zookeeper-$ZOO_VERSION/bin/zkServer.sh start'.PHP_EOL;
        	$base = str_replace('#storm_services',$servicios,$base);
        }

		if ($this -> paramEjecucion == null){
			$c = new ConfiguracionBenchmark();
			$this ->paramEjecucion = $c->getParamEjucucionByNombre($programa ->getNombre());
		}

        $run_script = 
        	$programa ->getBin(). " " .
        	$this -> paramEjecucion. "".
        	$script->getClass()."".
        	$script->getBin()." ".
        	$in_aux . $this -> rutaDatosDocker."data/".$this -> FicheroDatos -> getNombre()." ".
        	$out_aux . $configuracion -> getFicherosalida() ." ".
        	$this -> confAdicionalByAlgoritmo.$separador.
        	$configuracion -> getLogs();

        $fichero = str_replace('#execute',$run_script,$base);
        $fichero = str_replace('#tipoOperacion', $configuracion -> getOp(), $fichero);
        $fichero = str_replace('#id', $nombreContenedor, $fichero);
        $fichero = str_replace('#tool',$programa -> getNombre(), $fichero);

        return $fichero;
	}	

	public function lanzarSiguienteTarea(){
		$test = new Test($this -> em); 
		$test= $test -> getNextTask();
		$time = new \DateTime();

		$estado = $this -> em->createQuery('SELECT f
            FROM BenchmarkBundle:Estado f
            WHERE f.id = :activo')->setParameter('activo', 1)->getSingleResult();

		//$script = $this -> crearScript( $test->getPrograma(), $test->getAlgoritmo(),$test->getContainerName(),$test->getConfiguracion() );
		$scriptbenchmark = $test -> getScriptbenchmark();


        file_put_contents($scriptbenchmark->getRuta() ,$scriptbenchmark->getContenido() );
        chmod($scriptbenchmark->getRuta() , 0777);
        if( strrpos($this -> monitor -> getServerStatus(), "APAGADO") !== false) { 
        	$rutaServerSocket = "/var/www/default/TFG2/src/BenchmarkBundle/Bin/arrancar.sh > /dev/null 2>/dev/null &";
        	shell_exec($rutaServerSocket);
        	sleep(2);
        }
        $this -> monitor -> peticion("MEDIR_REQUEST");
      	$docker_id = $this -> shell -> launch($test->getComand());
        $test -> setInicio($time);
        $test -> setContainerId($docker_id);
        $test -> setEstado($estado);
        $this -> em-> persist ($test);
        $this -> em -> flush();
        return $docker_id;
	}

	public function getMediciones( ){
		return $this -> monitor -> peticion("GETDATA_REQUEST");
	}

	// return >0 hay tareas en ejecucion
	public function HayTareasEnEjecucion() {
        $hayTareas = $this -> em->createQuery('SELECT count(f)
            FROM BenchmarkBundle:Test f
            WHERE f.estado = :activo')->setParameter('activo', 1)->getSingleScalarResult();
        return $hayTareas;
	}

	public function HayTareasPendientes() {
        $hayTareas = $this -> em->createQuery('SELECT count(f)
            FROM BenchmarkBundle:Test f
            WHERE f.estado = :pendiente')->setParameter('pendiente', 5)->getSingleScalarResult();
        return $hayTareas;
	}
	public function getNextIDComparativa(){
        $id= $this -> em->createQueryBuilder()
        ->select('MAX(e.id)')
        ->from('BenchmarkBundle:Comparativa', 'e')
        ->getQuery()
        ->getSingleScalarResult();
        $id ++;
        return $id;
	}

	public function salvarResultadoYlanzarSiguienteTarea($containerName,$tiempo,$cpu,$ram,$configuracion){

		$resultado = new Resultado($this -> em);
		$test = new Test($this -> em); 
		$test = $test -> getTestByContainerName($containerName);
		$ruta = $configuracion -> getRutaProyecto();

		$numCores=trim(shell_exec("cat /proc/cpuinfo | grep processor | wc -l"));
		$proceador= shell_exec("cat /proc/cpuinfo | grep 'model name' | uniq | awk '{print $4FS$5FS$6FS$8FS$10}'");
		$totalMemoria = shell_exec("cat /proc/meminfo | grep MemTotal: | awk '{print $2/1000}'");

		$totalMemoria = round($totalMemoria,0);
		$proceador=trim(preg_replace('/\s+/', ' ', $proceador));
		$numCores=trim(preg_replace('/\s+/', ' ', $numCores));

		$time = new \DateTime();
		$id=2; 
		$logs= file_get_contents($ruta.'logs/log'.$test->getPrograma()->getNombre().'.txt');
		if ( stripos($logs, 'ERROR') !== false || stripos($logs, 'EXCEPTION') !== false ) { // 
			$id =6;
		}
		$estado = $this -> em->createQuery('SELECT f
            FROM BenchmarkBundle:Estado f
            WHERE f.id = :terminado')->setParameter('terminado', $id)->getSingleResult();

		$test ->setEstado($estado);
		$test ->setFin($time);

        $this -> em-> persist ($test);
        

		$resultado->setTiempo($tiempo);
		$resultado->setCpu($cpu);
		$resultado->setRam($ram);
		$resultado->setModelocpu($proceador);
		$resultado->setNucleoscpu($numCores);
		$resultado->setTotalram($totalMemoria);
		$resultado->setLog($logs);


		$resultado->setTest($test);

		$this -> em-> persist ($resultado);
		$this -> em -> flush();

		$stop = shell_exec ("docker stop $containerName");
        $rm = shell_exec ("docker rm $containerName");

		if($this -> HayTareasEnEjecucion() == 0  && $this -> HayTareasPendientes() > 0 ){
			$this -> lanzarSiguienteTarea();
		}else{
			echo "Tareas en ejecucion";
		}


	}
}

?>