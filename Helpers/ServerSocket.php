<?php
require_once '/data/www/apache/default/TFG2/src/BenchmarkBundle/Helpers/Monitorizar.php';
// set some variables
/**
* 
*/
// don't timeout!

//namespace BenchmarkBundle\Helpers;
set_time_limit(0);
use BenchmarkBundle\Helpers\Monitorizar;
class ServerSocket  {
    
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

    public function checkStado() {



        $connection = @fsockopen($this ->host, $this ->port);

        if (is_resource($connection)) {
            fclose($connection);
            return "ENCENDIDO";
        } else {
            return "APAGADO";
        }

    }

    public function inicio() {
        // create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // bind socket to port
        $result = socket_bind($socket, $this ->host, $this ->port) or die("Could not bind to socket\n");
        // start listening for connections
        $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
        $m = new Monitorizar(1);
        // accept incoming connections
        // spawn another socket to handle communication
        $repetir =true;
        while($repetir){
            $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
            // read client input
            $input = socket_read($spawn, 1024) or die("Could not read input\n");
            // clean up input string
            $input = trim($input);
            echo "Client Message : ".$input."\n";
            $msg=explode("_",$input);
            if( strcmp($msg[0],"MEDIR") === 0){
                $m = new Monitorizar(1);
                $m ->start();
                $output =serialize (array("RESPONSE" => "MEDIR_OK"));
            }else if (strcmp($msg[0],"GETDATA")===0){
                 $m ->setMonitorizar(false);
                 sleep(1);
                 $output =serialize($m ->getResultados());
                 $m->join();
            }else if (strcmp($msg[0],"STATUS") ===0){
                $output =serialize (array("RESPONSE" => "STATUS_OK"));
            }else if (strcmp($msg[0],"STOP") ===0){
                $output =serialize (array("RESPONSE" => "STOP_OK"));
                $repetir=false;
                //socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
            }else{
                $output =serialize (array("RESPONSE" => "DESCONOCIDO_OK"));

            }
            $output.="\n";
            // reverse client input and send back
            //$output = strrev($input) . "\n";
            socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
            // close sockets
        }
        socket_close($spawn);
        socket_close($socket);
    }
}
$s = new ServerSocket ();
$s->inicio();


?>