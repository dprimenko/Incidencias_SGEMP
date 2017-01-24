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

if (isset($_GET['removeUser'])) {
    if ($_SESSION['username'] == "root") {
        $app->removeUser($_GET['removeUser']);
        unset($_GET['removeUser']);
    }
    echo "<script>window.location='index.php';</script>";
}

if (isset($_GET['addUser'])) {
    
    if ($_SESSION['username'] == "root") {
        $app->addUser($_POST['new-username'], $_POST['new-password'], $_POST['new-name']);
        unset($_GET['addUser']);
    }
    echo "<script>window.location='index.php';</script>";
}

if (isset($_GET['updateUser'])) {
    if ($_SESSION['username'] == "root") {
        $app->updateUser($_GET['updateUser'], $_POST['update-name'], $_POST['update-password']);
        unset($_GET['updateUser']);
    }
    echo "<script>window.location='index.php';</script>";
}

if (isset($_GET['editIncidencia'])) {
    
    $usernameRequest = $app->getUserById($app->getIncidencia($_GET['editIncidencia'])[0]['idCreator'])[0]['username'];
    
    if (($_SESSION['username'] == "root") || ($_SESSION['username'] == $usernameRequest)) {
        $app->updateIncidencia($_GET['editIncidencia'], $_POST['edit-description'], $_POST['edit-student'], $_POST['edit-tipo-incidencia']);
    }
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
                        <div class="window-modal add-modal">
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
                        <div class="window-modal edit-incidencia-modal">
                            <img id="close-edit-incidencia" class="close-modal" src="img/close.svg"/>
                            <h3>Editar incidencia</h3>
                            <br/>
                            <form id="edit-incidencia-form" action="" method="post">
    							<div class="row">
    								<div class="col-md-12">
    									<textarea class="input-app" placeholder="Descripción..."  required rows="3" name="edit-description"></textarea>
    								</div>
    								<div class="col-md-12">
    									<input class="input-app" placeholder="Alumno" type="text" required name="edit-student">
    								</div>
    								<div class="col-md-12">
    									<select class="select" name="edit-tipo-incidencia">
    									    <option value="" selected disabled>Tipo incidencia...</option>
    									    <option value="1">Retraso</option>
    									    <option value="2">Falta respeto</option>
    									    <option value="3">Falta a clase</option>
    									    <option value="4">Ejercicios no entregados</option>
    									</select>
    								</div>
    								<div class="col-md-12">
    									<input class="button-send" type="submit" value="Editar" name="send">
    								</div>
    							</div>
						    </form>
                        </div>
                        <div class="window-modal manage-users-modal">
                            <img id="close-manage-users" class="close-modal" src="img/close.svg"/>
                            <h3>Gestionar usuarios</h3>
                            <br/>
                            <ul class="users-list">';
                            $app->getUsers();   
        echo '               </ul>
                            <button class="button-send" onclick="addUser()">Añadir usuario</button>
                        </div>
                        <div class="window-modal add-user-modal">
                            <img id="close-add-user" class="close-modal" src="img/back.svg"/>
                            <h3>Añadir usuario</h3>
                            <br/>
                            <form id="add-user-form" action="index.php?addUser=true" method="post">
    							<div class="row">
    							    <div class="col-md-12">
    									<input id="add-name" placeholder="Nombre" class="input-app" name="new-name" required</input>
    								</div>
    							    <div class="col-md-12">
    									<input id="add-username" class="input-app" placeholder="Nombre usuario" type="text" required name="new-username">
    								</div>
    								<div class="col-md-12">
    									<input id="add-password" class="input-app" placeholder="Contraseña" type="password" required name="new-password">
    								</div>
    								<div class="col-md-12">
    									<input class="button-send" type="submit" value="Añadir" name="send">
    								</div>
    							</div>
						    </form>
                        </div>
                        <div class="window-modal update-user-modal">
                            <img id="close-update-user" class="close-modal" src="img/back.svg"/>
                            <h3>Editar usuario</h3>
                            <br/>
                            <form id="update-user-form" action="" method="post">
    							<div class="row">
    							    <div class="col-md-12">
    									<input id="update-username" class="input-app" name="update-username" disabled></input>
    								</div>
    							    <div class="col-md-12">
    									<input id="update-name" class="input-app" placeholder="Nombre" type="text" required name="update-name">
    								</div>
    								<div class="col-md-12">
    									<input id="update-password" class="input-app" placeholder="Nueva contraseña" type="password" required name="update-password">
    								</div>
    								<div class="col-md-12">
    									<input class="button-send" type="submit" value="Editar" name="send">
    								</div>
    							</div>
						    </form>
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
                                        <a href="index.php?allIncidencias=true"><p><strong>Total de incidencias: '.$app->getCountIncidencias().'</strong></p></a>
                                        <a href="index.php"><p><strong>Incidencias de hoy: '.$app->getCountTodayIncidencias(date("Y-m-d")).'</strong></p></a>
                                        <br/>
                                        <p><strong>Filtro</strong></p>
                                        <form class="form-date" action="index.php?filter=true" method="post">';
                                        
                                        $minDate = $app->getMinDate();
                                        $minDate = substr($minDate, 0, 10);
                                        $tomorrow = date('Y-m-d',strtotime($minDate . "+1 days"));
                                        
            echo '                          <p>Desde:</p>
                                            <input size="1" type="number" min="1" max="31" value="'.substr($minDate, 8, 2).'" class="input-date" name="from-day">
                                            <input size="1" type="number" min="1" max="12" value="'.substr($minDate, 5, 2).'" class="input-date" name="from-month">
                                            <input size="2" type="number" min="2000" max="9999" value="'.substr($minDate, 0, 4).'" class="input-date" name="from-year">
                                            <br/>
                                            <br/>
                                            <p>Hasta:</p>
                                            <input size="1" type="number" min="1" max="31" value="'.substr($tomorrow, 8, 2).'" class="input-date" name="to-day">
                                            <input size="1" type="number" min="1" max="12" value="'.substr($tomorrow, 5, 2).'" class="input-date" name="to-month">
                                            <input size="2" type="number" min="1" max="9999" value="'.substr($tomorrow, 0, 4).'" class="input-date" name="to-year">
                                            <br/>
                                            <br/>
                                            <input class="button-send btn-red" type="submit" value="Filtrar"/>
                                        </form>
                                        <br/>
                                    </div>
                                </div>
                                <div class="col-md-9">
        
        ';
        if (isset($_GET['search'])) {
            $app->getIncidencias($_GET['search']);
            unset($_GET['search']);
        } else {
            if (isset($_GET['filter'])) {
                $from = $_POST['from-year']."-".$_POST['from-month']."-".$_POST['from-day'];
                $to = $_POST['to-year']."-".$_POST['to-month']."-".$_POST['to-day'];
            
                if(strtotime($to) > strtotime($from)){ 
                    $app->getIncidenciasBetweenDates($from, $to);
                } else {
                    echo '<p class="not-found">No se encontraron resultados</p>';
                    echo '<script type="type/javascript">alert("La fecha DESDE debe ser inferior a HASTA")</script>';
                }
            } else if($_GET['allIncidencias']){
               $app->getIncidencias("empty"); 
            } else {
                $app->getTodayIncidencias();
            }
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
        		    function updateIncidencia(id) {
        		        var wrapperHidden = document.querySelector(".wrapper-hidden");
        				var editIncidenciaModal = document.querySelector(".edit-incidencia-modal");
        				var wrapper = document.querySelector(".main");
        				var form = document.getElementById("edit-incidencia-form");
        				    
        				    
        				wrapper.style.zIndex = "0";
        				wrapperHidden.style.zIndex = "1";
        				editIncidenciaModal.style.visibility = "visible";
        				editIncidenciaModal.style.display = "inline-block";
        		  
        		        form.action = "index.php?editIncidencia=" + id;
        		    }
        		</script>
        		<script type="text/javascript">
        			document.getElementById("close-edit-incidencia").addEventListener("click", function(event) {
        				(function(event) {
        				    var wrapperHidden = document.querySelector(".wrapper-hidden");
        				    var editIncidenciaModal = document.querySelector(".edit-incidencia-modal");
            				var wrapper = document.querySelector(".main");
        				    
        				    
        				    wrapper.style.zIndex = "1";
        				    wrapperHidden.style.zIndex = "0";
        				    editIncidenciaModal.style.visibility = "hidden";
        				    editIncidenciaModal.style.display = "none";
        				}).call(document.getElementById("close-edit-incidencia"),event);	
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
        		<script type="text/javascript">
        			function updateUser(username) {
        			    var updateUserModal = document.querySelector(".update-user-modal");
        			    var manageUsersModal = document.querySelector(".manage-users-modal");
        			    var usernameField = document.getElementById("update-username");
        			    var form = document.getElementById("update-user-form");
        			    
        			    manageUsersModal.style.visibility = "hidden";
        			    manageUsersModal.style.display = "none";
        			    
        			    form.action = "index.php?updateUser=" + username;
        			    usernameField.value = username;
        			    
        			    updateUserModal.style.visibility = "visible";
        			    updateUserModal.style.display = "inline-block";
        			}
        		</script>
        		<script type="text/javascript">
        			document.getElementById("close-update-user").addEventListener("click", function(event) {
        				(function(event) {
        				    var updateUserModal = document.querySelector(".update-user-modal");
        			        var manageUsersModal = document.querySelector(".manage-users-modal");
        			    
        			        updateUserModal.style.visibility = "hidden";
        			        updateUserModal.style.display = "none";
        			        manageUsersModal.style.visibility = "visible";
        			        manageUsersModal.style.display = "inline-block";
        			        
        				}).call(document.getElementById("close-manage-users"),event);	
        			});
        		</script>
        		<script type="text/javascript">
        			function addUser() {
        			    var addUserModal = document.querySelector(".add-user-modal");
        			    var manageUsersModal = document.querySelector(".manage-users-modal");
        			    var usernameField = document.getElementById("user-username");
        			    var form = document.getElementById("add-user-form");
        			    
        			    manageUsersModal.style.visibility = "hidden";
        			    manageUsersModal.style.display = "none";
        			  
        			    addUserModal.style.visibility = "visible";
        			    addUserModal.style.display = "inline-block";
        			}
        		</script>
        		<script type="text/javascript">
        			document.getElementById("close-add-user").addEventListener("click", function(event) {
        				(function(event) {
        				    var addUserModal = document.querySelector(".add-user-modal");
        			        var manageUsersModal = document.querySelector(".manage-users-modal");
        			    
        			        updateUserModal.style.visibility = "hidden";
        			        updateUserModal.style.display = "none";
        			        addUserModal.style.visibility = "visible";
        			        addUserModal.style.display = "inline-block";
        			        
        				}).call(document.getElementById("close-add-user"),event);	
        			});
        		</script>
        		<script type="text/javascript">
        			function removeUser(username) {
        			    
        			    if (confirm("¿Seguro que quiere eliminar al usuario " + username +"?")) {
        				    window.location = "index.php?removeUser=" + username;
                        }
        			}
        		</script>
            </body>
        </html>
        ';
} else {
    echo "<script>window.location='php/login.php';</script>";
}
?>