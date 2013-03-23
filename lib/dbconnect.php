<?php
class Database{
	private $con;
	
	function __construct(){
		$this->host = "127.0.0.1";
		$this->username = "root"; 
		$this->password  = "9632"; 
		$this->db_name   = "smactracker";
		
		$this->connect();
		$this->select_db();
	}
	
	function connect(){
		if($this->con == null){
			$this->con = mysql_connect($this->host, $this->username, $this->password) or die(mysql_error());
		}
		
		return $this->con;
	}
		
	function select_db(){
		mysql_select_db($this->db_name, $this->con) or die(mysql_error());
	}
	

}

?>
