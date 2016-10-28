<?php
class DB
{
	public function __call($name, $arguments)
	{
		if(method_exists($this->_connect, $name)) {
			call_user_func_array([$this->_connect, $name], $arguments);
		}
	}
	/* Inizatilization */

	protected static $_instance = null;

	public static function getInstance () 
	{
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	protected function __construct ()
	{
		$this->getConnect();
	}

	public function __destruct ()
	{
		$this->closeConnect();
	}

	public function escape ($string) 
	{
		return $this->_connect->real_escape_string($string);
	}

	/* Connection */

	protected $_connect = null;
	
	protected function getConnect () 
	{
		try {
			if ($this->_connect === null) {
				/* check connection */
				$this->_connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				if ($this->_connect->connect_errno) {
	    			throw new Exception($this->_connect->connect_error);
				}
			}
			return $this->_connect;
		} catch (Exception $e) {
			var_dump($e->message);
		}
	}

	protected function closeConnect() 
	{
		$this->_connect->close();
	}

	/* Condition */

	protected $_conditions = [];

	public function setCondition ($conditionName, $conditionValue)
    {
		try {
			if(!is_callable($conditionValue)) {
				throw new Exception("Condition is not callable!");	
			}
			$this->_conditions[$conditionName] = $conditionValue();
		} catch (Exception $e) {
			var_dump($e->getMessage());
		} 
	}

	public function setConditions($conditions) {
		foreach ($conditions as $conditionName => $conditionValue) {
			$this->setCondition($conditionName, $conditionValue);
		}
	}

	public function getConditions () {

		// Empty array to prevent using other conditions
		$conditions = $this->_conditions;
		$this->_conditions = [];

		$conditions = implode(' ', array_map(function($conditionName, $conditionValues) {
				$conditionName = strtoupper($conditionName);
				return "$conditionName $conditionValues";
			},
			array_keys($conditions),
			$conditions
		));
		if($conditions) {
			$conditions = ' '.$conditions;
		}

		return $conditions;
	}

	/* CRUD */
	
	public function insert ($table, array $fields) 
	{
		$fieldsKeys = implode(', ', array_keys($fields));
		$fieldsValues = array_map(function ($elem) {
			return $this->escape($elem);
		}, array_values($fields));
		$fieldsValues = implode(', ', Text::addQuoteToEachElem($fieldsValues));
		$sql = trim("INSERT INTO $table ($fieldsKeys) VALUES ($fieldsValues);");

		debug($sql, $this->getConnect());
		
		$this->_connect->query($sql);
		
		return $this->_connect->insert_id;
	}

	public function select($table, array $fields, $multiple = false) {
		$fields = implode(', ', $fields);

		$conditions = $this->getConditions();
		
		$sql = "SELECT $fields FROM {$table}{$conditions};";
		
		debug($sql);
		
		$q = $this->_connect->query($sql);

		$data = null;
		if ($multiple) {
			$data = [];
			while($data[] = $q->fetch_array(MYSQLI_ASSOC)){}
			unset($data[count($data)-1]);
		} else {
			$data = $q->fetch_array(MYSQLI_ASSOC);
		}
		$q->free_result();
		return $data;
	}

	public function update ($table, array $fields) 
	{

		$fields = Text::convertArrayFieldsToText($fields);
		$conditions = $this->getConditions();
		$sql = "UPDATE $table SET {$fields}{$conditions};";
		debug($sql);
		return $this->_connect->query($sql);
	}

	public function delete($table) {
			$conditions = $this->getConditions();
			$sql = "DELETE FROM {$table}{$conditions};";
			debug($sql);
			return $this->_connect->query($sql);
	}
}