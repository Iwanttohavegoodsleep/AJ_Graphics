<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>AJ Graphics</title>	
	<link rel="stylesheet" href="dash.css">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">	
</head>
<body>

 <?php 
 	if ($_SESSION['role'] === 'admin') {
 		echo "Hello {$_SESSION['username']} you are a admin";
 	}
 	else {
 		echo "Hello {$_SESSION['username']}";
 	}
 ?>





	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>	
</body>
</html>

