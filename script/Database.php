<?php 
	
	namespace Todos;
	
// this is my own crated query builder
// github link : https://github.com/inside-the-div/mysql-query-builder
	
	class Database{

		public $sql;
		public $connection;

		function __construct()
		{
			$this->connection = mysqli_connect('localhost','root','','todos_db');
			if(!$this->connection){
				echo 'Database Not connected !!';
			}
		}


		public function query($sql){
			$this->sql = $sql;
			$row = mysqli_query($this->connection,$this->sql);
			if($row){
				return $row;
			}else{
				return "Query Error Your Query Is @".$this->sql."@";
			}
		}
		public function select($columns){
			$this->sql = 'SELECT '.$columns;
			return $this;
		}
		public function select_all(){
			$this->sql = 'SELECT *';
			return $this;	
		}
		public function from($table){
			$this->sql .=' from '.$table; 
			return $this;
		}
		public function where($condition){
			$this->sql .=' where '.$condition;
			return $this;
		}
		public function order_by($reder_by){
			$this->sql .= ' order by '.$reder_by;
			return $this;
		}
		public function sort($sort){
			$this->sql .=' '.$sort;
			return $this; 
		}

		public function limit($from,$to){
			$this->sql .=' limit '.$from.','.$to;
			return $this; 
		}

// insert query make 
		public function insert($table){
			$this->sql = "insert into ".$table."(";
			return $this; 
		}
		public function values($array){
			foreach ($array as $key => $value) {
				$this->sql .= $key.",";
			}
			$this->sql = substr_replace($this->sql, "", -1);
			$this->sql .= ") values(";
			foreach ($array as $key => $value) {
				if(is_int($value) || is_double($value)){
					$this->sql .= $value.",";
				}else{
					$value = $this->escape_string($value);
					$this->sql .= "'".$value."',";
				}
			}
			$this->sql = substr_replace($this->sql, "", -1);
			$this->sql .=")";

			return $this; 
		}

// update query make 
		public function update($table){
			$this->sql = 'update '.$table.' set ';
			return $this;
		}
		public function set($array){

			foreach ($array as $key => $value) {
				if($value != ''){
					$this->sql .= $key."=";
					if(is_int($value) || is_double($value)){
						$this->sql .= $value.",";
					}else{
						$value = $this->escape_string($value);
						$this->sql .= "'".$value."',";
					}
				}
			}
			$this->sql = substr_replace($this->sql, "", -1);
			return $this;
		}

// delete query make 

		public function delete($table){
			$this->sql = 'delete from '.$table;
			return $this;
		}


// final get method to get result 
		public function get(){
			$row = mysqli_query($this->connection,$this->sql);
			if($row){
				return $row;
			}else{
				return "Query Error Your Query Is @".$this->sql."@";
			}
		}

// escape_string
		function escape_string($str){
			return $this->connection->real_escape_string($str);
		}

	} // end class



?>