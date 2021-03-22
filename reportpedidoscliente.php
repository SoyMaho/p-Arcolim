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
      <a href=""><img src="img/arcolim_Logo.jpg" id="logo_Home" alt=""></a>
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
                  <li><a href="listadoproducts.php">Listado</a></li>
                  <li><a href="nproducts.php">Registrar</a></li>
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
            <li> <a href="">Reportes</a></li>
            <li> <a href="usuarios.php">Usuarios</a></li>
          </ul>
        </nav>
      </div>

      <div class="Main">
        <h1>Reporte de Pedidos por cliente detallado</h1>
        <h2>Descripcion</h2>
        <p>Este reporte enlista todos los pedidos realizados por los clientes y los agrupa segun el cliente</p>
        <div class="report">
          <?php
          $nombreCliente=(trim($_POST['nombre_Cliente']));

          $data=[
            'nombreCliente'=>$nombreCliente,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.idVenta,c.nombre_Cliente,lm.claveProducto,lm.nombreProducto,lm.cantidadProducto,lm.precioProducto, lm.precioTotalProducto, s.fechaVenta FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta INNER JOIN listadomovimientos AS lm ON lm.idDocumentoVenta = s.idVenta WHERE s.estadoRegistroV!=3 ORDER BY s.id_ClienteVenta";

          $statement = $connect->prepare($query);
          $statement->execute($data);
          echo "<table>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Cliente</td>
          <td width='150'>Clave Producto</td>
          <td width='150'>Nombre Producto</td>
          <td width='150'>Cantidad Producto</td>
          <td width='150'>Precio Producto</td>
          <td width='150'>Precio Total Producto</td>
          <td width='150'>Fecha Venta</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
        {
        echo"
        <tr>
        <td width='150'>".$registro['idVenta']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['claveProducto']."</td>
        <td width='150'>".$registro['nombreProducto']."</td>
        <td width='150'>".$registro['cantidadProducto']."</td>
        <td width='150'>".$registro['precioProducto']."</td>
        <td width='150'>".$registro['precioProducto']."</td>
        <td width='150'>".$registro['fechaVenta']."</td>
        </tr>
        ";
        }

        echo "</table>";
          ?>
        </div>




      </div>

    </div>
  </body>
</html>
