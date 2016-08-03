<?php

namespace BenchmarkBundle\Bin;

class Shell {
//sudo usermod -aG docker www-data
	function __construct() { }

	public function launch($container) {
		$r  = shell_exec($container);
		$r=str_replace('\n', '', $r);
		return $r;
		//'php /var/www/html/TFG/src/BenchmarkBundle/Resources/public/tfg/data/docker.php'
		//return 1111111111;
	}

	public function getContainerStatus() {
		//CONTAINER ID IMAGE COMMAND CREATED STATUS PORTS NAMES
		return shell_exec("docker ps -a");
	}

	public function clean() {
		$stop = shell_exec ("docker stop $(docker ps -a -q)");
		$rm = shell_exec ("docker rm $(docker ps -a -q)");
		return ( '<node><stop>'. $stop. '</stop><rm>'.$rm.'</rm></node>' );
	}
	public function getContainerStatusByID($id){
		$r = shell_exec('docker ps --filter "id='.$id.'"');
		return $r;
	}
	public function terminal() {
		return exec('/var/www/html/TFG/src/BenchmarkBundle/Resources/public/tfg/terminal/open.sh');
		//docker run --rm -it --user docker -v $(pwd):/ -w / ubuntu-spark:latest R
		//docker run --rm -it --user docker -v $(pwd):/home/docker/foo -w /home/docker/foo ubuntu-spark:latest R
		//docker run -d -P -v $(pwd):/home/docker/foo \ ubuntu-spark:latest
		//docker run --name flink_test -v $(pwd):/home/docker/foo -d ubuntu-flink:latest 
	}

}
?>
