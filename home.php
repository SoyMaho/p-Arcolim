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

         <a href="logout.php"> Salir</a>
      </div>
    </header>

    <div class="work_Section">
      <div class="NavBar">
        <nav>
          <ul>
            <li> <a href="/listadoproducts.php">Productos</a>
                <ul>
                  <li><a href="nproducts.php">Registrar Producto</a></li>
                  <li><a href="/modproducts.php">Modificar Productos</a></li>
                </ul>
            </li>
            <li> <a href="/listadoproducts.php">Clientes</a>
              <ul>
                <li><a href="/nproducts.php">Registrar Cliente</a></li>
                <li><a href="/modproducts.php">Modificar Clientes</a></li>
              </ul>
            </li>
            <li> <a href="/listadoproducts.php">Proveedores</a>
              <ul>
                <li><a href="/nproducts.php">Registrar Proveedor</a></li>
                <li><a href="/modproducts.php">Modificar Proveedor</a></li>
              </ul>
            </li>
            <li> <a href="/nproducts.php">Clientes</a>
              <ul>
                <li><a href="/listadoproducts.php">Registrar Cliente</a></li>
                <li><a href="/modproducts.php">Modificar Clientes</a></li>
              </ul>
            </li>
            <li> <a href="/nproducts.php">Reportes</a></li>
            <li> <a href="#">Panel de control</a></li>
          </ul>
        </nav>
      </div>

      <div class="Main">
        <h1>Main Section</h1>
      </div>

    </div>
  </body>
</html>
