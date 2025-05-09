<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics</title>
  <link rel="stylesheet" href="signup.css">

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/eedbcd0c96.js"
      crossorigin="anonymous"
    ></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

</head>
<body>

  <?php include_once "navbar.php"?>

  <div class="signup_area">
    <h3 style="text-align: center;"> Signup </h3>  
    <form action="signup_handler.inc.php" method="post">
    
      <label class="form-label">Name </label>           
      <input class="form-control" type="text" name="username" required>

      <label class="form-label">Password </label>           
      <input class="form-control" type="password" name="password" required>

      <label class="form-label">Email </label>           
      <input class="form-control" type="email" name="email" required>

      <label class="form-label">Phone Number </label>           
      <input class="form-control" type="text" name="phone_number" required>

      <input class="btn btn-primary" type="submit">

    </form> 

  </div>

  <?php 
    if (isset($_SESSION['error'])) {
      echo '<p style="color:red; text-align:center;">' . $_SESSION['error'] . '</p>';
      unset($_SESSION['error']);  // Unset error after displaying it
    }
    else {
    }
  ?> 


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>