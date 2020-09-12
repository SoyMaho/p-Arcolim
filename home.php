<?php
session_start();
include("conexion.php");
include_once 'sesion.php';
$sesion = new sesion ();

$currentUser = $sesion->getCurrentUser();

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <header>
      <img src="img/arcolim_Logo.jpg" id="logo_Home" alt="">
      <div class="user">
        <?php  try {
           $con = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
           $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $stmt = $con->prepare('SELECT *  FROM users WHERE id_user = :id_u');
           $stmt->execute(
             array(
             'id_u' =>  $currentUser)
           );

           while( $datos = $stmt->fetch()){

             echo '<h2> Bienvenido </h2>' . $datos[3] ;
             echo  "&nbsp;" . $datos[4] ;
           }




         } catch(PDOException $e) {
           echo 'Error: ' . $e->getMessage();
         }
         ?>
      </div>
    </header>

    <div class="work_Section">
      <div class="Menu">
        <h1>Side Bar</h1>
        <ul>
          <li> <a href="#">Opcion1</a></li>
          <li> <a href="#">Opcion2</a></li>
        </ul>
      </div>

      <div class="main_Content">
        <h1>Main Content</h1>
      </div>
    </div>
  </body>
</html>
