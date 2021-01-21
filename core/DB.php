<?php 
	
	class DB {
		protected $host;
		protected $huser;
		protected $hpass;
		protected $dbname;
		public $con;
		public $template;

		public function __construct(){
			// Defines 
			$this->host = 'localhost';
			$this->huser = 'root';
			$this->hpass = 'root';
			$this->dbname = 'nosco_db';
		}

		public function connection(){
			$this->con = mysqli_connect($this->host, $this->huser, $this->hpass, $this->dbname);
			return ($this->con) ? $this->con : die("No connection made");
		}

	}
	
?>