<?php
	
	include_once('dao.php');

	session_start();

	class App {

		protected $dao;

		function __construct() {
			$this->dao = new Dao();
		}

		function getDao() {

		}

		function loginIsSet() {

			$result = false;
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
				$result = true;
			}

			return $result;
		}

		function login($username, $password) {
			
			$this->dao->checkUser($username, $password);

			/*if($this->dao->checkUser($username, $password)) {
				echo "<script>window.location='../html/main.html';</script>";
			}*/
		}
	}
?>