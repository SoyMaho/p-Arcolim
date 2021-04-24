<?php
session_start();
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
try {
  if (!isset($_SESSION['user'])){
    header('Location: index.php');
  }
  else {
    $currentUser = $sesion->getCurrentUser();
    echo '<h2> Bienvenido </h2>' .$currentUser;
  }
 } catch(PDOException $e) {
   echo 'Error: ' . $e->getMessage();
 }
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
      <a href="index.php"><img src="img/arcolim_Logo.jpg" id="logo_Home" alt=""></a>
      <div class="user">


         <a href="logout.php"> Salir</a>
      </div>
    </header>

    <div class="work_Section">
      <div class="NavBar">
        <nav class="menuMain">
          <ul>
            <li> <a>Productos</a>
                <ul>
                  <?php
                  if ($_SESSION['tipoUsuario']==2) {
                    echo "<li><a href='listadoproductsUser.php'>Listado</a></li>";
                    echo "<li><a href='nproductsUser.php'>Registrar</a></li>";

                  }else{
                    echo "<li><a href='listadoproducts.php'>Listado</a></li>";
                    echo "<li><a href='nproducts.php'>Registrar</a></li>";
                  }
                  ?>
                  <li><a href="entradaproducts.php">Generar Entrada</a> </li>
                </ul>
            </li>
            <li> <a>Venta</a>
              <ul>
                <li><a href="registroventa.php">Registrar Venta</a></li>
                <li><a href="listadopedido.php"> Listado de Ventas</a></li>
                <li><a href="servicio.php">Registrar Servicio</a> </li>
                <li> <a href="listapedidoservices.php">Listado de Servicios</a> </li>
              </ul>
            </li>
            <li> <a>Proveedores</a>
              <ul>
                <li><a href="listadoproveedores.php">Listado</a></li>
                <li><a href="nproveedor.php">Registrar</a></li>
              </ul>
            </li>
            <li> <a>Clientes</a>
              <ul>
                <li><a href="listadoclientes.php">Listado</a></li>
                <li><a href="ncliente.php">Registrar</a></li>
              </ul>
            </li>
            <li>
              <a>Reportes</a>
              <ul>
                <li><a href="reportventasproduct.php">Ventas por producto</a></li>
                <li><a href="reportpedidoscliente.php">Pedidos por cliente</a> </li>
                <li> <a href="reportcostoproducto.php">Costo por producto</a> </li>
                <li> <a href="reportservicioscliente.php">Servicios por cliente</a> </li>
                <li><a href="reportservicioservices.php">Servicios por servicio</a></li>
                <li><a href="reportclientes.php">Reporte de clientes</a></li>
              </ul>
            </li>
            <?php
            if ($_SESSION['tipoUsuario']==1) {
              echo "<li> <a href='usuarios.php'>Usuarios</a></li>";
              echo "<li><a>Utilerias</a>";
              echo "<ul>";
              echo "<li><a href='recosteo.php'>Recosteo</a></li>";
              echo "</ul>";
              echo "</li>";
            }
            ?>

          </ul>
        </nav>
      </div>

      <div class="Main">
        <h1>Main Section</h1>
      </div>

    </div>
  </body>
</html>
