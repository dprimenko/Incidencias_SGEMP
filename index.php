<?php

include_once('php/app.php');

session_start();
header("Content-Type: text/html;charset=utf-8");

global $app;
$app = new App();


if (isset($_GET['disconnect'])) {
    unset($_GET['disconnect']);
    $app->disconnect();
}

if (isset($_GET['addIncidencia'])) {
    unset($_GET['addIncidencia']);
    $username = $_SESSION['username'];
    $description = $_POST['add-description'];
    $student =  $_POST['add-student'];
    $tipoIncidencia =  $_POST['add-tipo-incidencia'];
    $userId = $app->getUser($username)[0]['id'];

    $app->insertIncidencia($description, $student, $tipoIncidencia, $userId);
    echo "<script>window.location='index.php';</script>";
}

if($app->loginIsSet()) {
    echo '
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        		<title>Main - Incidencias en un aula</title>
        		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
        		<link rel="stylesheet" type="text/css" href="css/style.css" />
            </head>
            <body>
                <div class="wrapper-hidden">
                    <div class="modal-container">
                        <div class="add-modal">
                            <img id="close-add-incidencia" class="close-modal" src="img/close.svg"/>
                            <h3>Añadir incidencia</h3>
                            <br/>
                            <form class="add-incidencia-form" action="index.php?addIncidencia=true" method="post">
    							<div class="row">
    								<div class="col-md-12">
    									<textarea class="input-app" placeholder="Descripción..."  required rows="3" name="add-description"></textarea>
    								</div>
    								<div class="col-md-12">
    									<input class="input-app" placeholder="Alumno" type="text" required name="add-student">
    								</div>
    								<div class="col-md-12">
    									<select class="select" name="add-tipo-incidencia">
    									    <option value="" selected disabled>Tipo incidencia...</option>
    									    <option value="1">Retraso</option>
    									    <option value="2">Falta respeto</option>
    									    <option value="3">Falta a clase</option>
    									    <option value="4">Ejercicios no entregados</option>
    									</select>
    								</div>
    								<div class="col-md-12">
    									<input class="button-send" type="submit" value="Añadir" name="send">
    								</div>
    							</div>
						    </form>
                        </div>
                        <div class="manage-users-modal">
                            <img id="close-manage-users" class="close-modal" src="img/close.svg"/>
                            <h3>Gestionar usuarios</h3>
                            <br/>
                            <ul class="users-list">';
                            $app->getUsers();   
        echo '               </ul>
                        </div>
                    </div>
                </div>
        	    <div class="wrapper main">
        	    	<div class="table-container">
        	    		<div class="table-header">
        	    			<div class="welcome-main">
        ';

        echo '<h3>Hola '.$app->getUser($_SESSION['username'])[0]['name'].'!</h3>';
        echo '
                            </div>
        	    			<div class="controls">';
        	    		    if ($_SESSION['username'] == 'root') {
        	    		        echo'<img id="manage-users" class="svg" src="img/account-multiple.svg"/>';
        	    		    }
        echo '	    			<img id="add-incidencia" class="svg" src="img/plus.png"/>
        	    				<div class="search-box">
        	    					<form autocomplete="off">
        	    						<input id="livesearch" class="search-input" placeholder="Buscar..." type="text" name="search" />	
        	    					</form>
        	    				</div>
        	    				<img id="open_search" class="svg" src="img/magnify.svg"/>
        	    				<a href="index.php?disconnect=true">
        	    					<img class="svg" src="img/power.svg"/>
        	    				</a>
        	    			</div>
        	    		</div>
        	    		<div class="table-content">
        	    		    <div class="row">
                                <div class="col-md-3">
                                    <div class="info-incidencias">
                                        <p><strong>- Total de incidencias: '.$app->getCountIncidencias().'</strong></p>
                                        <p><strong>- Incidencias de hoy: '.$app->getCountTodayIncidencias(date("Y-m-d")).'</strong></p>
                                    </div>
                                </div>
                                <div class="col-md-9">
        
        ';
        if (isset($_GET['search'])) {
            $app->getIncidencias($_GET['search']);
            unset($_GET['search']);
        } else {
            $app->getIncidencias("empty");
        }

        echo '              
                                </div>
                            </div>
                        </div>
        	    	</div>
        		</div>	
        		<script type="text/javascript">
        			document.getElementById("open_search").addEventListener("click", function(event) {
        				(function(event) {
        					var searchBox = document.querySelector(".search-box");
        					var displayValue = searchBox.style.display;
        					if (displayValue.localeCompare("inline-block")) {
        						searchBox.style.display = "inline-block";
        					} else {
        						searchBox.style.display = "none";
        					}
        				}).call(document.getElementById("open_search"),event);	
        			});
        		</script>
        		<script type="text/javascript">
        			document.getElementById("add-incidencia").addEventListener("click", function(event) {
        				(function(event) {
        				    var wrapperHidden = document.querySelector(".wrapper-hidden");
        				    var addIncidenciaModal = document.querySelector(".add-modal");
        				    var wrapper = document.querySelector(".main");
        				    
        				    
        				    wrapper.style.zIndex = "0";
        				    wrapperHidden.style.zIndex = "1";
        				    addIncidenciaModal.style.visibility = "visible";
        				    addIncidenciaModal.style.display = "inline-block";
        				}).call(document.getElementById("add-incidencia"),event);	
        			});
        		</script>
        		<script type="text/javascript">
        			document.getElementById("close-add-incidencia").addEventListener("click", function(event) {
        				(function(event) {
        				    var wrapperHidden = document.querySelector(".wrapper-hidden");
        				    var addIncidenciaModal = document.querySelector(".add-modal");
        				    var wrapper = document.querySelector(".main");
        				    
        				    
        				    wrapper.style.zIndex = "1";
        				    wrapperHidden.style.zIndex = "0";
        				    addIncidenciaModal.style.visibility = "hidden";
        				    addIncidenciaModal.style.display = "none";
        				}).call(document.getElementById("close-add-incidencia"),event);	
        			});
        		</script>
        		<script type="text/javascript">
        			document.getElementById("manage-users").addEventListener("click", function(event) {
        				(function(event) {
        				    var wrapperHidden = document.querySelector(".wrapper-hidden");
        				    var manageUsersModal = document.querySelector(".manage-users-modal");
        				    var wrapper = document.querySelector(".main");
        				    
        				    
        				    wrapper.style.zIndex = "0";
        				    wrapperHidden.style.zIndex = "1";
        				    manageUsersModal.style.visibility = "visible";
        				    manageUsersModal.style.display = "inline-block";
        				}).call(document.getElementById("add-incidencia"),event);	
        			});
        		</script>
        		<script type="text/javascript">
        			document.getElementById("close-manage-users").addEventListener("click", function(event) {
        				(function(event) {
        				    var wrapperHidden = document.querySelector(".wrapper-hidden");
        				    var manageUsersModal = document.querySelector(".manage-users-modal");
        				    var wrapper = document.querySelector(".main");
        				    
        				    
        				    wrapper.style.zIndex = "1";
        				    wrapperHidden.style.zIndex = "0";
        				    manageUsersModal.style.visibility = "hidden";
        				    manageUsersModal.style.display = "none";
        				}).call(document.getElementById("close-manage-users"),event);	
        			});
        		</script>
            </body>
        </html>
        ';
} else {
    echo "<script>window.location='php/login.php';</script>";
}
?>