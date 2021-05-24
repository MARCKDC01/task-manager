<?php


 class Connection{

 	public function __construct(){
 		$this->host = '127.0.0.1';
 		$this->user = 'root';
 		$this->password = 'Marcoesel7.5';
 		$this->dbName = 'task_manager';
 		$this->port = 3306;
 	}

 	public function dbConnect(){
 		
 		$mysqli = new mysqli($this->host, $this->user, $this->password, $this->dbName, $this->port);

		if ($mysqli->connect_errno) {
	    	$mysqli  = "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		return $mysqli;
	}
}

?>