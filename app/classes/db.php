<?php

#Ultima modificacion 6/10/08

class db {
	
	private $dbhost;
	private $dbname;
	private $dbuser;
	private $dbpass;
	private $charset;
	private $dbconn;
	private $DB_DIE_ON_FAIL;
	private $DB_DEBUG;
	
	function __construct( )
	{

			$this->dbhost = 'localhost';
			$this->dbname = 'oferto';
			$this->dbuser = 'root';
			$this->dbpass = 'root';

			$this->dbhost = 'localhost';
			$this->dbname = 'ofertoha_oferto';
			$this->dbuser = 'ofertoha_oferto';
			$this->dbpass = 'dZevd6mtHVGmJViw';

			$this->DB_DEBUG = 1;
			$this->DB_DIE_ON_FAIL = true;
			$this->connect();
	}
	

	function connect() {	
		if (! $this->dbconn = @mysql_connect($this->dbhost, $this->dbuser, $this->dbpass)) {
			if ($this->DB_DEBUG) {
				trigger_error ('No se puede conectar a '.$this->dbhost .  ' como '.$this->dbuser.' : '.mysql_error() , E_USER_ERROR);
			} 
	
			if ($this->DB_DIE_ON_FAIL) {
				trigger_error ('El script no puede continuar por error de conexión MySQL' , E_USER_ERROR);
				die();
			}
		}
	
		if (! mysql_select_db($this->dbname)) {
			if ($this->DB_DEBUG) {
				trigger_error ('No se puede seleccionar la base de datos '.$this->dbname .' : '.mysql_error() , E_USER_ERROR);
			} 
	
			if ($this->DB_DIE_ON_FAIL) {
				trigger_error ('El script no puede continuar por error de conexión MySQL' , E_USER_ERROR);
				die();
			}
		}
	
		return $this->dbconn;
	}

	function disconnect() {
		mysql_close();
	}

	function query($query, $debug=false, $die_on_debug=true, $silent=false) {
		if ($debug) {
			echo "<pre>" . htmlspecialchars($query) . "</pre>";
			if ($die_on_debug) die;
		}
		$qid = mysql_query($query);
		if (! $qid && ! $silent) {
			if ($this->DB_DEBUG) {
				trigger_error ('No se pudo ejecutar la consulta '. htmlspecialchars($query) .' : '.mysql_error() , E_USER_ERROR);
			} 
			if ($this->DB_DIE_ON_FAIL) {
				trigger_error ('El script no puede continuar '. htmlspecialchars($query) .' : '.mysql_error() , E_USER_ERROR);
				die();
			}
		}
		return $qid;
	}
	
	function fetch_array($qid) {
		return mysql_fetch_array($qid);
	}
	
	function fetch_assoc($qid) {
		return mysql_fetch_assoc($qid);
	}
	function fetch_row($qid) {
		return mysql_fetch_row($qid);
	}
	
	function result_array($qid) {
		$reg = array();
		while($pr = mysql_fetch_assoc($qid))
			$reg[] = $pr;
		return $reg;
	}
	
	function fetch_object($qid) {
		return mysql_fetch_object($qid);
	}
	
	function num_rows($qid) {
		return mysql_num_rows($qid);
	}
	
	function affected_rows() {
		return mysql_affected_rows();
	}
	
	function insert_id() {
		return mysql_insert_id();
	}
	
	function free_result($qid) {
		mysql_free_result($qid);
	}
	
	function num_fields($qid) {
		return mysql_num_fields($qid);
	}
	
	function field_name($qid, $fieldno) {
		return mysql_field_name($qid, $fieldno);
	}
	
	function data_seek($qid, $row) {
		if ($this->num_rows($qid)) { return mysql_data_seek($qid, $row); }
	}
	
	function insert($vars,$table) 
	{
		$fields = "";
		$values = "";
		$sql_insert = "";
		
		foreach($vars as $key => $val)
		{
			$fields=$fields.$key.",";
			$val="'".$val."'";
			$values=$values.$val.",";
		}
		
		$fields = substr($fields,0,strlen($fields)-1);
		$values = substr($values,0,strlen($values)-1);
		
		 $sql_insert = "INSERT INTO $table ($fields) values($values)";
		 if($this->query($sql_insert)!=0)
			  return true;
		else
			  return false;
	}
	
	function update($vars,$table,$where)
	{
		$fields_vals='';
		foreach($vars as $key=>$val)
		{
			$val="'".$val."'";
			$fields_vals=$fields_vals.$key."=".$val.",";
		}
		$fields_vals=substr($fields_vals,0,strlen($fields_vals)-1);
		$query="UPDATE $table SET $fields_vals WHERE $where";
		return ($this->query($query) != 0) ?  true : false;
		
	}
	
	function query_loop($query, $prefix, $suffix, $found_str, $default="") {
	
		$output = "";
		$result = $this->query($query);
		while (list($val, $label) = $this->fetch_row($result)) {
			if (is_array($default))
				$selected = empty($default[$val]) ? "" : $found_str;
			else
				$selected = $val == $default ? $found_str : "";
	
			$output .= "$prefix value='$val' $selected>$label$suffix";
		}
	
		return $output;
	}
	
	function listbox($query, $default="", $suffix="</option>\n") {
		return $this->query_loop($query, "<option", $suffix, "selected", $default);
	}


}
?>