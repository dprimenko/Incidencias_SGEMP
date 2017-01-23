<?php
	
	include_once('dao.php');
	session_start();
	
	class App {

		protected $dao;

		function __construct() {
			$this->dao = new Dao();
		}

		function loginIsSet() {

			$result = false;
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
				$result = true;
			}

			return $result;
		}
		
		function disconnect() {
			
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
				session_destroy();
				echo "<script>window.location='php/login.php';</script>";
			}
		}
		
		function getIncidencias($filter) {
			$incidencias = $this->dao->getIncidencias($filter);
			foreach ($incidencias as $value) {
			
				echo '<div class="incidencias-container">';
					
					echo '<div class="row row-eq-height">';
						echo '<div class="col-md-8 info-incidencia">';
							echo '<span class="incidencia"><strong>Incidencia #'.$value['id'].' | '.$this->getTipoIncidencia($value['idType'])[0]['name'].'</stong></span>';
							echo '<br/>';
							echo '<br/>';
							echo '<span>'.$value['description'].'</span>';
							echo '<br/>';
							echo '<br/>';
							echo '<span class="student-span">Alumno: '.$value['student'].'</span>';
							echo '<br/>';
							echo '<span class="student-span">Creador: '.$this->getCreator($value['idCreator'])[0]['name'].'</span>';
						echo '</div>';
						echo '<div class="col-md-4 icons-incidencia">';
							echo '<div class="container-icons-incidencia">';
								echo '<div class="icons-center">';
									echo'
										<a href="../index.php?view='.$value['id'].'">
			        	    				<img class="svg icon-incidencia left" src="../img/eye.svg"/>
			        	    			</a>
									';
									if (($this->getCreator($value['idCreator'])[0]['username'] == $_SESSION['username']) || ($_SESSION['username'] == 'root')) {
										echo'
										<a href="../index.php?edit='.$value['id'].'">
			        	    				<img class="svg icon-incidencia right" src="../img/pencil.svg"/>
			        	    			</a>
									';
									}
								echo '</div>';
							echo '</div>';
							$date = date_create($value['date']);
							echo '<span class="date-incidencia">['.date_format($date, 'd-m-Y H:i').']</span>';
						echo '</div>';
					echo '</div>';
					
				echo '</div>';
			}
		}
		
		function getTipoIncidencia($id) {
			return $this->dao->getTipoIncidencia($id);
		}
		
		function getCreator($id) {
			return $this->dao->getCreator($id);
		}

		function login($username, $password) {
			if (!$this->loginIsSet()) {
				if($this->dao->checkUser($username, $password)) {
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					
					echo "<script>window.location='../index.php';</script>";
				} else {
					echo "<script>window.location='login.php?connect=false';</script>";
				}
			} else {
				echo "<script>window.location='../index.php';</script>";
			}
		}
		
		function getUser($username) {
			return $this->dao->getUser($username);
		}
		
		function getUsers() {
			$users = $this->dao->getUsers();
			
			foreach($users as $value) {
				echo '
				<li>
					<div class="user-div">
						<div class="username-manage-user">
							<span>'.$value['username'].'</span>
						</div>
						<div class="icons-manage-user">
							<a href="../index.php?view='.$value['id'].'">
			        	    	<img class="svg svg-manage-users" src="../img/pencil.svg"/>
			        	    </a>
			        	    <a href="../index.php?edit='.$value['id'].'">
			        	    	<img class="svg svg-manage-users" src="../img/close_black.svg"/>
			        	    </a>
						</div>
					</div>
				</li>';
			}
		}
		
		function getCountIncidencias() {
			$count = $this->dao->getCountIncidencias();
			return $count;
		}
		
		function getCountTodayIncidencias($today) {
			return $this->dao->getCountTodayIncidencias($today);
		}
		
		function insertIncidencia($description, $student, $tipoIncidencia, $username) {
			$this->dao->insertIncidencia($description, $student, $tipoIncidencia, $username);
		}
	}
?>