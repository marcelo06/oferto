<?php
class database
{
	var $host;
	var $user;
	var $password;
	var $database;
	var $connection;
	var $err_msg = '';

	function __construct()
	{
		$this->host = 'localhost';
		$this->user = 'oferto';
		$this->password = 'dZevd6mtHVGmJViw';
		$this->database = 'oferto';
		$this->connection = mysql_connect($this->host, $this->user, $this->password);
		if(!$this->connection)
		{
			$this->err_msg = 'No fue posible establecer conexión con el servidor.';
		}
		else
		{
			mysql_query("SET NAMES 'utf8'", $this->connection);
			if(!mysql_select_db($this->database, $this->connection))
			{
				$this->err_msg = 'No fue posible abrir la base de datos.';
			}
		}
	}

	function disconnect()
	{
		return mysql_close($this->connection);
	}

	function insert($table, $columns, $values)
	{
		$sql = "INSERT INTO ".$table." (".$columns.") VALUES (".$values.")";
		$result = mysql_query($sql, $this->connection);
		if(!$result)
			echo mysql_error($this->connection);
		return $result;
	}

	function update($table, $columns, $condition)
	{
		$sql = "UPDATE ".$table." SET ".$columns." WHERE ".$condition;
		$result = mysql_query($sql, $this->connection);
		if(!$result)
			echo mysql_error($this->connection);
		return $result;
	}

	function delete($table, $condition)
	{
		$sql = "DELETE FROM ".$table." WHERE ".$condition;
		$result = mysql_query($sql, $this->connection);
		if(!$result)
			echo mysql_error($this->connection);
		return $result;
	}

	function select($columns, $table, $condition = null)
	{
		$sql = "SELECT ".$columns." FROM ".$table;
		if(isset($condition))
			$sql = $sql." WHERE ".$condition;
		$result = mysql_query($sql, $this->connection);
		return $result;
	}

	function query($sql)
	{
		$result = mysql_query($sql, $this->connection);
		return $result;
	}

	function fetch_array($result)
	{
		return mysql_fetch_array($result, MYSQL_ASSOC);
	}

	function fetch_all($result)
	{
		while(($row[] = mysql_fetch_array($result, MYSQL_ASSOC)) || array_pop($row));
		return $row;
	}

	function num_rows($sql)
	{
		return mysql_num_rows($sql);
	}

	function last_insert_id()
	{
		return mysql_insert_id();
	}
}
?>