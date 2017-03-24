<?php
    require_once "Classes/Config.php";
    require_once "Classes/Router.php";
    require_once "Classes/Connection.php";
	

    $update = file_get_contents('php://input');
    $updateArray = json_decode($update, TRUE);
    
    Router::direcionar($updateArray);
?>

<h2>Version 0.1</h2>