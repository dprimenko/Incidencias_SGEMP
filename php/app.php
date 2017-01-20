<?php
	
	include_once('dao.php');

	session_start();

	class App {

		protected $dao;

		function __construct() {
			echo "Hola";
			$this->dao = new Dao();
		}

		function getDao() {

		}

		function loginIsSet() {

			boolean $result = false;;
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
				$result = true;
			}

			return $result;
		}

		function login($username, $password) {

			$dao->checkUser($username, $password);
		}
	}
?>