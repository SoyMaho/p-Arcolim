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
      <a href="header.php"><img src="img/arcolim_Logo.jpg" id="logo_Home" alt=""></a>
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
        <h1>Listado de Ventas</h1>
        <form class="" action="" method="post">
          <div id="horizontal">
            <input id="" class="inputShort" type="text" name="nombre_Cliente" placeholder="Nombre" value="<?php if(isset($numeroServicio)){echo $numeroServicio;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />
            <input id="" class="inputShort" type="text" name="fecha_Venta" placeholder="Fecha" value="<?php if(isset($fechaVenta)){echo $fechaVenta;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />
          </div>

          <div id='horizontal'>
            <button type="submit" class="botonLista"name="btn-search">Filtrar Por nombre</button>
            <button type="submit" class="botonLista"name="btn-searchNF">Filtrar por nombre y fecha</button>
            <button type="submit" class="botonLista"name="btn-searchF">Filtrar por Fecha</button>
            <button type="submit" class="botonLista"name="btn-todos">Mostrar Todos</button>
            <button type="submit" class="botonLista"name="btn-day">Entregas del dia</button>

          </div>

        </form>

        <?php
            //Boton para buscar registros por clientes


            if (isset($_POST['btn-search'])) {
              $nombreCliente=(trim($_POST['nombre_Cliente']));

              $data=[
                'nombreCliente'=>$nombreCliente,
              ];
              $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
              $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $query = "SELECT s.idVenta, c.nombre_Cliente, s.totalVenta, s.fechaVenta, s.fechaVentaEntrega FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta WHERE c.nombre_Cliente = :nombreCliente AND s.estadoRegistroV!=3";

              $statement = $connect->prepare($query);
              $statement->execute($data);
              echo "<table>
              <tr>
              <td width='150'>Folio</td>
              <td width='150'>Cliente</td>
              <td width='150'>Total Venta</td>
              <td width='150'>Fecha</td>
              <td width='150'>Fecha de Entrega</td>
              <td width='300'></td>
              </tr>";
              while($registro = $statement->fetch())
          {
            echo"
            <tr>
            <td width='150'>".$registro['idVenta']."</td>
            <td width='150'>".$registro['nombre_Cliente']."</td>
            <td width='150'>".$registro['totalVenta']."</td>
            <td width='150'>".$registro['fechaVenta']."</td>
            <td width='150'>".$registro['fechaVentaEntrega']."</td>
            </tr>
            ";
          }

          echo "</table>";
        }

        if (isset($_POST['btn-day'])) {
          $fechaVenta=trim(date('Y-m-d'));
          $data=[
            'fechaVenta'=>$fechaVenta,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.idVenta, c.nombre_Cliente, s.totalVenta, s.fechaVenta, s.fechaVentaEntrega FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta WHERE s.fechaVentaEntrega = :fechaVenta AND s.estadoRegistroV!=3";

          $statement = $connect->prepare($query);
          $statement->execute($data);
          echo "<table>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Cliente</td>
          <td width='150'>Total Venta</td>
          <td width='150'>Fecha</td>
          <td width='150'>Fecha de Entrega</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
      {
        echo"
        <tr>
        <td width='150'>".$registro['idVenta']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['totalVenta']."</td>
        <td width='150'>".$registro['fechaVenta']."</td>
        <td width='150'>".$registro['fechaVentaEntrega']."</td>
        </tr>
        ";
      }

      echo "</table>";
    }

        if (isset($_POST['btn-searchF'])) {
          $fechaVenta=(trim($_POST['fecha_Venta']));
          $data=[
            'fechaVenta'=>$fechaVenta,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.idVenta, c.nombre_Cliente, s.totalVenta, s.fechaVenta, s.fechaVentaEntrega FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta WHERE s.fechaVenta = :fechaVenta AND s.estadoRegistroV!=3";

          $statement = $connect->prepare($query);
          $statement->execute($data);
          echo "<table>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Cliente</td>
          <td width='150'>Total Venta</td>
          <td width='150'>Fecha</td>
          <td width='150'>Fecha de Entrega</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
      {
        echo"
        <tr>
        <td width='150'>".$registro['idVenta']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['totalVenta']."</td>
        <td width='150'>".$registro['fechaVenta']."</td>
        <td width='150'>".$registro['fechaVentaEntrega']."</td>
        </tr>
        ";
      }

      echo "</table>";
        }

        if (isset($_POST['btn-searchNF'])) {
          $nombreCliente=(trim($_POST['nombre_Cliente']));
          $fechaVenta=(trim($_POST['fecha_Venta']));
          $data=[
            'nombreCliente'=>$nombreCliente,
            'fechaVenta'=>$fechaVenta,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.idVenta, c.nombre_Cliente, s.totalVenta, s.fechaVenta, s.fechaVentaEntrega FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta WHERE c.nombre_Cliente=:nombreCliente AND s.fechaVenta = :fechaVenta AND s.estadoRegistroV!=3";

          $statement = $connect->prepare($query);
          $statement->execute($data);
          echo "<table>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Cliente</td>
          <td width='150'>Total Venta</td>
          <td width='150'>Fecha</td>
          <td width='150'>Fecha de Entrega</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
      {
        echo"
        <tr>
        <td width='150'>".$registro['idVenta']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['totalVenta']."</td>
        <td width='150'>".$registro['fechaVenta']."</td>
        <td width='150'>".$registro['fechaVentaEntrega']."</td>
        </tr>
        ";
      }

      echo "</table>";
        }

        if (isset($_POST['btn-todos'])) {
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.idVenta, c.nombre_Cliente, s.totalVenta, s.fechaVenta, s.fechaVentaEntrega FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta WHERE s.estadoRegistroV!=3 ORDER BY s.idVenta";

          $statement = $connect->prepare($query);
          $statement->execute();
          echo "<table>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Cliente</td>
          <td width='150'>Total Venta</td>
          <td width='150'>Fecha</td>
          <td width='150'>Fecha de Entrega</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
      {
        echo"
        <tr>
        <td width='150'>".$registro['idVenta']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['totalVenta']."</td>
        <td width='150'>".$registro['fechaVenta']."</td>
        <td width='150'>".$registro['fechaVentaEntrega']."</td>
        </tr>
        ";
      }

      echo "</table>";
          }


         ?>
      </div>

    </div>
  </body>
</html>
