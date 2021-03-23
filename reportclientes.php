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
        <h1>Reporte de clientes</h1>
        <h2>Descripcion</h2>
        <p>Este reporte enlista los clientes registrados y que no esten ocultos</p>
        <p>Para exportar el listado a excel usa el boton Exportar.</p>
        <form class="" action="" method="post">
          <button type="submit" name="btn-export" onclick ="this.form.action = 'reportclientesExcel.php'" formtarget="_blank" >Exportar</button>
        </form>

        <div id="tablaLong">
          <?php
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT c.id_Cliente,c.nombre_Cliente, c.pApellido_Cliente, c.razonSocial_Cliente, c.rfc_Cliente, c.correo_Cliente, c.tel_Cliente, d.calle_Cliente, d.numeroEx_Cliente, d.numeroInt_Cliente, d.colonia_Cliente, d.ciudad_Cliente, e.nombre_Estado FROM cat_clientes AS c INNER JOIN cat_direccionclientes AS d ON c.direccion_Cliente = d.id_Direccion INNER JOIN cat_estado AS e ON d.estado_Cliente = e.id_Estado WHERE c.tipo_Entidad=1 ORDER BY c.id_Cliente";

          $statement = $connect->prepare($query);
          $statement->execute();
          echo "<table>
          <tr>
          <td width='150'>Id</td>
          <td width='150'>Nombre</td>
          <td width='150'>Apellido</td>
          <td width='150'>Razon Social</td>
          <td width='150'>RFC</td>
          <td width='150'>Correo</td>
          <td width='150'>Telefono</td>
          <td width='150'>Calle</td>
          <td width='150'>Numero Ext</td>
          <td width='150'>Numero Int</td>
          <td width='150'>Colonia</td>
          <td width='150'>Ciudad</td>
          <td width='150'>Estado</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
        {
        echo"
        <tr>
        <td width='150'>".$registro['id_Cliente']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['pApellido_Cliente']."</td>
        <td width='150'>".$registro['razonSocial_Cliente']."</td>
        <td width='150'>".$registro['rfc_Cliente']."</td>
        <td width='150'>".$registro['correo_Cliente']."</td>
        <td width='150'>".$registro['tel_Cliente']."</td>
        <td width='150'>".$registro['calle_Cliente']."</td>
        <td width='150'>".$registro['numeroEx_Cliente']."</td>
        <td width='150'>".$registro['numeroInt_Cliente']."</td>
        <td width='150'>".$registro['colonia_Cliente']."</td>
        <td width='150'>".$registro['ciudad_Cliente']."</td>
        <td width='150'>".$registro['nombre_Estado']."</td>
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
