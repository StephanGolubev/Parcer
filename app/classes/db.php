<?php
class DB {
	// переменные для xampp бд
	protected $_server = 'localhost';
	protected $_user = 'root';
	protected $_password = '';
 	protected $_database = 'parcer';
	protected $_link;
	protected $_result;
	protected static $_db;
	private static $_instance;
	
	// функция подключения к бд
	public function __construct() {
		
		if (!$this->_link = mysqli_connect($this->_server, $this->_user, $this->_password, $this->_database))
			die('Невозможно подключится к БД как '.$this->_user.'@'.$this->_server.'. MySQL error: '.mysqli_error());
		else {
			// делаем для русского языка
			$this->_link->set_charset("utf8");
			$this->_link = mysqli_connect($this->_server, $this->_user, $this->_password, $this->_database);
        }
		
		$this->_link->set_charset("utf8");
		$this->_link->query("set names 'UTF-8'");  
	}
	
	// функция записи в бд
	public function query($query) {
		$this->_result = false;
		if ($this->_link) {
			$this->_result = mysqli_query($this->_link,$query);
			return $this->_result;
			// return "<h3>Все сканированно и добавлено в базу данных</h3>";
		}
		return "no link";
	}

	// функция получения данных
	public function getRows($query, $array = true) {
		$this->_result = false;
		if ($this->_link && $this->_result = mysqli_query( $this->_link,$query)) {
			if (!$array)
				return $this->_result;
			$resultArray = array();
			while ($row = mysqli_fetch_assoc($this->_result))
				$resultArray[] = $row;
			return $resultArray;
		}
		return false;
	}


	// функция формирования команды для записи
	// имя таблицы, массив названия колонок, занчания
	public function insert($table,$name, $values) {
		$query = "INSERT INTO "."`".$table."`"." (";
		foreach ((array) $name AS $key => $value)
			$query .= "`".$value."`, ";
		// foreach ($values AS $key => $value)
		// 	$query .= $key.', ';
		$query = rtrim($query, " ,")."".") VALUES (";
		foreach ($values AS $key => $value)
			$query .= "'".$value."' , ";
		$query = rtrim($query, " ,");
		$query .= ")";
		
		return $this->query($query);
	}
	
	// функция формирования команды для получения все значений таблицы
	public function BuildSelect($table){
		$query =  "SELECT * FROM ".$table;
		return $this->query($query);
		// return $query;
	}

	// считаем количество значений в таблице
	public function	numRows() {
		if ($this->_link AND $this->_result)
			return mysqli_num_rows($this->_result);
	}
}