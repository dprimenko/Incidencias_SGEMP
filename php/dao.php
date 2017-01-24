<?php
	
	// Constantes de conexión
	define("DB_CONNECTION", "mysql:dbname=incidencias_app;host=localhost;");
	define("DB_USERNAME", "app");
	define("DB_PASSWORD", "usuario");

	// Nombres de las tablas
	define("TABLE_INCIDENCIAS", "incidencias");
	define("TABLE_TIPOINCIDENCIAS", "tipoIncidencias");
	define("TABLE_USUARIOS", "usuarios");

	// Nombres columnas de incidencias
	define("COL_ID_INCIDENCIAS", "id");
	define("COL_DESCRIPTION_INCIDENCIAS", "description");
	define("COL_STUDENT_INCIDENCIAS", "student");
	define("COL_DATE_INCIDENCIAS", "date");
	define("COL_IDTYPE_INCIDENCIAS", "idType");
	define("COL_IDCREATOR_INCIDENCIAS", "idCreator");

	// Nombres columnas de tipoIncidencias
	define("COL_ID_TIPOINCIDENCIAS", "id");
	define("COL_NAME_TIPOINCIDENCIAS", "name");
	define("COL_DESCRIPTION_TIPOINCIDENCIAS", "description");

	// Nombres columnas de usuarios
	define("COL_ID_USUARIOS", "id");
	define("COL_USERNAME_USUARIOS", "username");
	define("COL_PASSWORD_USUARIOS", "password");
	define("COL_NAME_USUARIOS", "name");

	class Dao {
		protected $db;
		public $error;

		function __construct() {
			try {
				$this->db = new PDO(DB_CONNECTION, DB_USERNAME, DB_PASSWORD);
			} catch(PDOException $e) {
				$this->error = $e->getMessage();
				$this->db = null;
			}
			
		}

		function __destruct() {
			if (!($this->isConnected())) {
				$this->db = null;
			}
		}

		function isConnected() {
			return ($this->db != null);
		}

		function checkUser($username, $password) {
			
			$result = false;
			
			if ($this->isConnected()) {
				$sql = "SELECT * FROM ".TABLE_USUARIOS." WHERE username = ? AND password = ?";
				$sth = $this->db->prepare($sql);
				$sth->execute(array($username, $password));
				$output = $sth->fetchAll();
				
				if (count($output) == 1) {
					$result = true;
				}
			}
			
			return $result;
		}

		function getIncidencias($filter) {
			
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				if ($filter == "empty") {
					$sql = "SELECT * FROM ".TABLE_INCIDENCIAS;
					
				} else {
					$sql = "SELECT * FROM ".TABLE_INCIDENCIAS." WHERE student LIKE '".$filter."%'";
				}
				
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			
			return $output;
		}
		
		function getIncidenciasBetweenDates($from, $to) {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT * FROM ".TABLE_INCIDENCIAS." WHERE date(".COL_DATE_INCIDENCIAS.") >= '".$from."' AND date(".COL_DATE_INCIDENCIAS.") <='".$to."' ORDER BY ".COL_DATE_INCIDENCIAS.";";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			
			return $output;
		}
		
		function getTodayIncidencias($today) {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT * FROM ".TABLE_INCIDENCIAS." WHERE ".COL_DATE_INCIDENCIAS." LIKE '".$today."%';";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			
			return $output;
		}
		
		function getCountTodayIncidencias($today) {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT count(".COL_ID_INCIDENCIAS.") FROM ".TABLE_INCIDENCIAS." WHERE ".COL_DATE_INCIDENCIAS." LIKE '".$today."%';";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			
			return $output[0]['count(id)'];
		}
		
		function getCountIncidencias() {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT count(".COL_ID_INCIDENCIAS.") FROM ".TABLE_INCIDENCIAS.";";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			
			return $output[0]['count(id)'];
		}
		
		function addUser($username, $password, $name) {
			$sql;
			
			if ($this->isConnected()) {
				
				if ($username != root) {
					$sql = "INSERT INTO ".TABLE_USUARIOS." (".COL_USERNAME_USUARIOS.",".COL_PASSWORD_USUARIOS.",".COL_NAME_USUARIOS.") VALUES('".$username."','".sha1($password)."','".$name."');";
					$sth = $this->db->prepare($sql);
					$sth->execute();
				}
			}
		}
		
		function updateUser($username, $name, $password) {
			$sql;
			
			if ($this->isConnected()) {
				
				if ($username != root) {
					$sql = "UPDATE ".TABLE_USUARIOS." SET ".COL_PASSWORD_USUARIOS." = '".sha1($password)."', ".COL_NAME_USUARIOS." = '".$name."' WHERE ".COL_USERNAME_USUARIOS." = '".$username."';";
					$sth = $this->db->prepare($sql);
					$sth->execute();
				}
			}
		}
		
		function removeUser($username) {
			$sql;
			
			if ($this->isConnected()) {
				
				if ($username != root) {
					$sql = "DELETE FROM ".TABLE_USUARIOS." WHERE ".COL_USERNAME_USUARIOS." = '".$username."';";
					$sth = $this->db->prepare($sql);
					$sth->execute();
				}
			}
		}
		
		function getUser($username) {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT * FROM ".TABLE_USUARIOS." WHERE ".COL_USERNAME_USUARIOS." = '".$username."';";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			return $output;
		}
		
		function getUserById($id) {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT * FROM ".TABLE_USUARIOS." WHERE ".COL_ID_USUARIOS." = ".$id.";";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			return $output;
		}
		
		function getUsers() {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT * FROM ".TABLE_USUARIOS.";";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			return $output;
		}
		
		function insertIncidencia($description, $student, $tipoIncidencia, $username) {
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "INSERT INTO ".TABLE_INCIDENCIAS." (".COL_DESCRIPTION_INCIDENCIAS.", ".COL_STUDENT_INCIDENCIAS.", ".COL_DATE_INCIDENCIAS.", ".COL_IDTYPE_INCIDENCIAS.", ".COL_IDCREATOR_INCIDENCIAS.") VALUES('".$description."', '".$student."', '".date("Y-m-d H:i:s")."', ".$tipoIncidencia.", ".$username.");";
				$sth = $this->db->prepare($sql);
				$sth->execute();
			}
		}
		
		function updateIncidencia($id, $description, $student, $tipoIncidencia) {
			$sql;
			
			if ($this->isConnected()) {
				
				if ($this->isConnected()) {
					$sql = "UPDATE ".TABLE_INCIDENCIAS." SET ".COL_DESCRIPTION_INCIDENCIAS." = '".$description."', ".COL_STUDENT_INCIDENCIAS." = '".$student."', ".COL_IDTYPE_INCIDENCIAS." = ".$tipoIncidencia." WHERE ".COL_ID_INCIDENCIAS." = ".$id.";";
					$sth = $this->db->prepare($sql);
					$sth->execute();
				}
			}
		}
		
		function getIncidencia($id) {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT * FROM ".TABLE_INCIDENCIAS." WHERE ".COL_ID_INCIDENCIAS." = ".$id.";";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			return $output;
		}
		
		function getTipoIncidencia($id) {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT * FROM ".TABLE_TIPOINCIDENCIAS." WHERE ".COL_ID_TIPOINCIDENCIAS." = ".$id.";";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			return $output;
		}
		
		function getCreator($id) {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT * FROM ".TABLE_USUARIOS." WHERE ".COL_ID_USUARIOS." = ".$id.";";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			return $output;
		}
		
		function getMinDate() {
			$output;
			$sql;
			
			if ($this->isConnected()) {
				
				$sql = "SELECT min(".COL_DATE_INCIDENCIAS.") FROM ".TABLE_INCIDENCIAS.";";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$output = $sth->fetchAll();
			}
			return $output;
		}
	}
?>