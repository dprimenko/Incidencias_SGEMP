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

	class Dao {
		protected $db;
		public $error;

		function __construct() {
			echo "<p>Hola PDO</p>";

			try {
				$this->db = new PDO(DB_CONNECTION, DB_USERNAME, DB_PASSWORD);
			} catch(PDOException $e) {
				$this->error = $e->getMessage();
				$this->connect = false;
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
			$sql = "SELECT * FROM ".TABLE_USUARIOS." WHERE username = ".$username." AND password = ".sha1($password);

			if (isConnected()) {
				$statement = $this->db->query($sql);
				$result = $statement->fetch(PDO::FETCH_ASSOC);
				print_r($result);
			}
		}

		function getUsuarios() {
			

			if ($this->db == null) {
				echo "<p>No hay conexión a la base de datos</p>"
			} else {
				$statement = $this->db->query('SELECT * FROM'.TABLE_USUARIOS);
				$aResult = $statement->fetch(PDO::FETCH_ASSOC);

				if (count($aResult) > 0) {
					echo "<p>Existen usuarios</p>";
				} else {
					echo "<p>No existen usuarios</p>";
				}
			}
		}
	}
?>