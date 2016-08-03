<?php
/**
* 
*/
namespace BenchmarkBundle\Helpers;
use BenchmarkBundle\Helpers\Monitorizar;
class ClientSocket  {
	private $host;//    = "127.0.0.1";
	private $port;//    = 9001;
	
	function __construct($host="127.0.0.1",$port= 9002) {
		$this ->host =$host;
		$this ->port =$port;
	}
    public function getHost () {
        return $this ->host;
    }
    public function getPort () {
        return $this ->port;
    }
	public function peticion($message) {
	//$message = "MEDIR_OK";
		//$message = "GETDATA_OK";
		//echo "Message To server :".$message;
		// create socket
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		// connect to server
		$result = socket_connect($socket, $this ->host, $this ->port) or die("Could not connect to server\n");  
		// send string to server
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		// get server response
		$result="";
		while ($out = socket_read ($socket, 2048)) {
		    $result.=$out;
		    if (strpos($out, "\n") !== false) break;
		}
		//echo "Reply From Server  :".$result;
		$array=unserialize($result);
		// close socket
		socket_close($socket);
		return $array;
	}
	public function getServerStatus(){
		$h =$this ->host;
		$p =$this ->port;
		$estado = shell_exec("netstat -anp | grep $h:$p");
		$serverStatus ="";
		if( strrpos($estado, "ESCUCHAR") !== false) {
			$serverStatus="ENCENDIDO";
		}else if ( strrpos($estado, "TIME_WAIT") !== false ){
			$serverStatus="CERRANDO";
		}else {
			$serverStatus="APAGADO";
		}
		return $serverStatus;
	}
}
/*
$c = new ClientSocket();
$r1 = $c -> peticion("MEDIR_OK");
sleep(5);
$r2 = $c -> peticion("GETDATA_OK");
echo "<pre>";
print_r($r1);
echo "</pre>";
echo "<br><br><pre>";
print_r($r2);
echo "</pre>";
*/
?>