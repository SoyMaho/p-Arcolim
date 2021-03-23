<?php
session_start();
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
try {
  if (!isset($_SESSION['user'])){
    header('Location: index.php');
  }
  //Condicion para Evitar que el usuario sin privilegios, ingrese a la pagina de reporteVentasproduct
  else if ($_SESSION['tipoUsuario']!=1) {
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
        <h1>Ventas por producto</h1>
        <h2>Descripcion</h2>
        <p>Este reporte enlista todas las ventas relacionadas al producto elegido.</p>
        <p>Para exportar el listado completo de las ventas usa el boton Exportar.</p>

        <form id=""class="" action="" method="post">
          <?php
          if(isset($error))
          {
           ?>
              <tr>
              <td id="error"><?php echo $error; ?></td>
              </tr>
              <?php
          }
          ?>
          <div id="venta">
            <h3 id="labelFecha">Producto</h3>
            <tr>
                <td><select class="inputShort" name="select_product">
                  <option value="<?php if(isset($id_p)){echo $id_p;}  ?>"><?php if(isset($pname)){echo $pname;}  ?></option>
                  <?php
                      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $query = "SELECT id_Producto, nombre_Producto FROM cat_producto where estadoRegistroP !=3";
                      $statement = $connect->prepare($query);
                      $statement->execute();

                      while($registro = $statement->fetch())
                  {
                    echo"<option value=".$registro["id_Producto"].">".$registro["nombre_Producto"]."</option>";
                  }
                   ?>
                  </select>
                </td>
            </tr>
            <h3 id="labelFecha">Fecha Inicio</h3>
            <input id="" class="inputShort" type="text" name="fecha_VentaIni" placeholder="Fecha" value="<?php if(isset($fechaVentaIni)){echo $fechaVentaIni;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />
            <h3 id="labelFecha">Fecha Final</h3>
            <input id="" class="inputShort" type="text" name="fecha_VentaFin" placeholder="Fecha" value="<?php if(isset($fechaVentaFin)){echo $fechaVentaFin;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />

          </div>

          <div id='horizontal'>
            <button type="submit" class="botonLista"name="btn-search">Filtrar por producto</button>
            <button type="submit" class="botonLista"name="btn-searchPF">Filtrar por producto y fechas</button>

          </div>
          <button type="submit" name="btn-export" onclick ="this.form.action = 'reportventasproductExcel.php'" formtarget="_blank" >Exportar</button>


        </form>

        <?php
            //Boton para buscar ventas por producto


            if (isset($_POST['btn-search'])) {

              $id_p = trim($_POST['select_product']);

              $data=[
                'claveProducto'=>$id_p,
              ];
              $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
              $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $query = "SELECT s.idVenta, c.nombre_Cliente,lm.claveProducto,lm.nombreProducto,lm.cantidadProducto,lm.precioProducto, lm.precioTotalProducto, s.fechaVenta FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta INNER JOIN listadomovimientos AS lm ON lm.idDocumentoVenta = s.idVenta WHERE lm.claveProducto=:claveProducto AND s.estadoRegistroV!=3";

              $statement = $connect->prepare($query);
              $statement->execute($data);
              echo "<table class='report'>
              <tr>
              <td width='150'>Folio</td>
              <td width='150'>Cliente</td>
              <td width='150'>Clave del producto</td>
              <td width='150'>Nombre del producto</td>
              <td width='150'>Cantidad</td>
              <td width='150'>Precio</td>
              <td width='150'>Precio Total</td>
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
            <td width='150'>".$registro['precioTotalProducto']."</td>
            <td width='150'>".$registro['fechaVenta']."</td>
            </tr>
            ";
          }

          echo "</table>";
        }



        if (isset($_POST['btn-searchPF'])) {
          $id_p = trim($_POST['select_product']);
          $fechaVentaIni=(trim($_POST['fecha_VentaIni']));
          $fechaVentaFin=(trim($_POST['fecha_VentaFin']));

          $data=[
            'claveProducto'=>$id_p,
            'fechaVentaIni'=>$fechaVentaIni,
            'fechaVentaFin'=>$fechaVentaFin,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.idVenta, c.nombre_Cliente,lm.claveProducto,lm.nombreProducto,lm.cantidadProducto,lm.precioProducto, lm.precioTotalProducto, s.fechaVenta FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta INNER JOIN listadomovimientos AS lm ON lm.idDocumentoVenta = s.idVenta WHERE lm.claveProducto=:claveProducto AND s.fechaVenta BETWEEN :fechaVentaIni AND :fechaVentaFin AND s.estadoRegistroV!=3";

          $statement = $connect->prepare($query);
          $statement->execute($data);
          echo "<table class='report'>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Cliente</td>
          <td width='150'>Clave del producto</td>
          <td width='150'>Nombre del producto</td>
          <td width='150'>Cantidad</td>
          <td width='150'>Precio</td>
          <td width='150'>Precio Total</td>
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
        <td width='150'>".$registro['precioTotalProducto']."</td>
        <td width='150'>".$registro['fechaVenta']."</td>
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
