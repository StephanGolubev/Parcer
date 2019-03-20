<?php
class DB {
	protected $_server = 'localhost';
	protected $_user = 'root';
	protected $_password = '';
 	protected $_database = 'parcer';
	protected $_link;
	protected $_result;
	protected static $_db;
	private static $_instance;
	
	/*
	public function __destruct() {
		$this->disconnect();
	}
	*/
	
	public function __construct() {
        // $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		
		if (!$this->_link = mysqli_connect($this->_server, $this->_user, $this->_password, $this->_database))
			die('Невозможно подключится к БД как '.$this->_user.'@'.$this->_server.'. MySQL error: '.mysqli_error());
		else {
			$this->_link->set_charset("utf8");
			$this->_link = mysqli_connect($this->_server, $this->_user, $this->_password, $this->_database);
        }
		
		$this->_link->set_charset("utf8");
		// mysqli_query('SET CHARACTER SET utf8', $this->_link);
	}
	
	/*
	public function	disconnect() {
		if ($this->_link)
			mysql_close($this->_link);
		$this->_link = false;
	}
	*/
	
	public function query($query) {
		$this->_result = false;
		if ($this->_link) {
			$this->_result = mysqli_query($this->_link,$query);
			// return $this->_result;
			return "<h3>Все сканированно и добавлено в базу данных</h3>";
		}
		return "no link";
	}


	public function getRows($query, $array = true) {
		$this->_result = false;
		if ($this->_link && $this->_result = mysql_query($query, $this->_link)) {
			if (!$array)
				return $this->_result;
			$resultArray = array();
			while ($row = mysql_fetch_assoc($this->_result))
				$resultArray[] = $row;
			return $resultArray;
		}
		return false;
	}
	
	public function insert($table,$name, $values) {
		$query = "INSERT INTO "."`".$table."`"." (`";
		foreach ((array) $name AS $key => $value)
			$query .= "".$value."`, ";
		// foreach ($values AS $key => $value)
		// 	$query .= $key.', ';
		$query = rtrim($query, " ,")."".") VALUES ";
		foreach ($values AS $key => $value)
			$query .= "('".$value."') , ";
		$query = rtrim($query, ", ");
		return $this->query($query);
		// return $query;
		// return mysqli_query($this->_link,$query);
	}


	
	public function update($table, $values, $where = false, $limit = false) {
		if (!sizeof($values))
			return true;
		$query = 'UPDATE `'.$table.'` SET ';
		foreach ($values AS $key => $value)
			$query .= '`'.$key.'` = \''.$value.'\',';
		$query = rtrim($query, ',');
		if ($where)
			$query .= ' WHERE '.$where;
		if ($limit)
			$query .= ' LIMIT '.intval($limit);
		return $this->query($query);
	}
	
	//INSERT INTO tbl_name (col1,col2) VALUES (col2*2,15);
	//UPDATE persondata SET age=age*2, age=age+1;
	
	
	public function delete($table, $where = false, $limit = false) {
		$this->_result = false;
		if ($this->_link)
			return mysql_query('DELETE FROM `'.pSQL($table).'`'.($where ? ' WHERE '.$where : '').($limit ? ' LIMIT '.intval($limit) : ''), $this->_link);
		return false;
	}
	
}