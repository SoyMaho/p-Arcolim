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
    $fechaVenta= trim(date('d/m/Y'));



    if(isset($_POST["btn-search"])){

          $id_p = trim($_POST['id_p']);
          $pname = trim($_POST['name_product']);
          $descP = trim($_POST['descripcion_Producto']);
          $costoP = trim($_POST['costo_Producto']);
          $precioP = trim($_POST['precio_Producto']);
          $unidadP = trim($_POST['unidad_Producto']);
          $existenciaP = trim($_POST['existencia_Producto']);
          $numeroVenta= trim($_POST['numero_Venta']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $id_Cliente = trim($_POST['id_Cliente']);
          $nombreCliente = trim($_POST['nombre_Cliente']);
          $subtotalVenta = trim($_POST['subtotal_Venta']);
          $ivaVenta = trim($_POST['iva_Venta']);
          $totalVenta = trim($_POST['total_Venta']);

          if(empty($id_p))
          {
           $error = "Por favor ingresa un ID del producto";
           $code = 1;
          }else {
            $data = [
            'id_p' => $id_p
            ,];

                $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT * FROM cat_producto WHERE id_Producto = :id_p";
                $statement = $connect->prepare($query);
                $statement->execute($data);

                $count = $statement->rowCount();
                if($count == 0)
                {
                  echo '<script language="javascript">';
                  echo 'alert("El producto no existe")';
                  echo '</script>';
                }
                else {
                  while( $datos = $statement->fetch()){
                  $pname = $datos[1];
                  $precioP = $datos[4];


                  }
                }
             }


    }



    if (isset($_POST["btn-nuevo"])){

      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query1 = "SELECT MAX(idVenta) AS id FROM listado_venta";

      $statement = $connect->prepare($query1);
      $statement->execute();
      $count = $statement->rowCount();

      while( $datos = $statement->fetch()){
      $id = $datos[0];
      }
      $suma=1;
      $numeroVenta=$id+$suma;
    }

    if(isset($_POST["btn-searchCliente"])){

          $id_Cliente = trim($_POST['id_Cliente']);
          $id_p = trim($_POST['id_p']);
          $pname = trim($_POST['name_product']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $precioP = trim($_POST['precio_Producto']);
          $precioTotal = trim($_POST['precio_Total']);
          $numeroVenta= trim($_POST['numero_Venta']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $subtotalVenta = trim($_POST['subtotal_Venta']);
          $ivaVenta = trim($_POST['iva_Venta']);
          $totalVenta = trim($_POST['total_Venta']);

          if(empty($id_Cliente))
          {
           $error = "Por favor ingresa un ID del Cliente";
           $code = 1;
          }else {
            $data = [
            'id_Cliente' => $id_Cliente
            ,];

                $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT * FROM cat_clientes WHERE id_Cliente = :id_Cliente";
                $statement = $connect->prepare($query);
                $statement->execute($data);

                $count = $statement->rowCount();
                if($count == 0)
                {
                  echo '<script language="javascript">';
                  echo 'alert("El cliente no existe")';
                  echo '</script>';
                }
                else {
                  while( $datos = $statement->fetch()){
                  $nombreCliente = $datos[1];


                  }
                }
             }


    }

    if(isset($_POST["btn-guardar"])){
          $id_p = trim($_POST['id_p']);
          $pname = trim($_POST['name_product']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $precioP = trim($_POST['precio_Producto']);
          $precioTotal = trim($_POST['precio_Total']);
          $id_Cliente = trim($_POST['id_Cliente']);
          $numeroVenta = trim($_POST['numero_Venta']);
          $fechaVenta = trim($_POST['fecha_Venta']);
          $idCliente = trim($_POST['id_Cliente']);
          $nombreCliente = trim($_POST['nombre_Cliente']);
          $subtotalVenta = trim($_POST['subtotal_Venta']);
          $ivaVenta = trim($_POST['iva_Venta']);
          $totalVenta = trim($_POST['total_Venta']);

          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM listado_venta WHERE numeroVenta = :numero_Venta";
            $statement = $connect->prepare($query);
            $statement->execute(
              [
                'numero_Venta' => $numeroVenta,
              ]
              //Se reemplazan las lineas de abajo.
            //      array(
            //           'id_p'     =>     $_POST["id_p"],
            //
            //      )
             );
            $count = $statement->rowCount();
            if($count > 0)
            {
              echo '<script language="javascript">';
              echo 'alert("El Folio de la venta ya existe")';
              echo '</script>';
            }
            else
            {
              $data = [
            'numero_Venta' => $numeroVenta,
            'fecha_Venta' => $fechaVenta,
            'id_Cliente' => $idCliente,
            'subtotal_Venta' => $subtotalVenta,
            'iva_Venta' => $ivaVenta,
            'total_Venta' => $totalVenta
            ,];

                $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "INSERT INTO listado_venta(fechaVenta, id_ClienteVenta, subtotalVenta, ivaVenta, totalVenta, numeroVenta)
                VALUES (:fecha_Venta, :id_Cliente, :subtotal_Venta, :iva_Venta, :total_Venta, :numero_Venta)";
                $statement = $connect->prepare($query);
                $statement->execute($data);
              }
    }



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
      <a href="home.php"><img src="img/arcolim_Logo.jpg" id="logo_Home" alt=""></a>
      <div class="user">


         <a href="logout.php"> Salir</a>
      </div>
    </header>

    <div class="work_Section">
      <div class="NavBar">
        <nav>
          <ul>
            <li> <a>Productos</a>
                <ul>

                  <li><a href="listadoproducts.php">Listado</a></li>
                  <li><a href="nproducts.php">Registrar Producto</a></li>

                </ul>
            </li>
            <li> <a href="/listadoproducts.php">Venta</a>
              <ul>
                <li><a href="/registroventa.php">Registrar Venta</a></li>
              </ul>
            </li>
            <li> <a href="/listadoproducts.php">Proveedores</a>
              <ul>
                <li><a href="listadoproveedores.php">Listado</a></li>
                <li><a href="nproveedor.php">Registrar Proveedor</a></li>
              </ul>
            </li>
            <li> <a>Clientes</a>
              <ul>
                <li><a href="listadoclientes.php">Lista</a></li>
                <li><a href="ncliente.php">Registrar Clientes</a></li>
              </ul>
            </li>
            <li> <a href="/nproducts.php">Reportes</a></li>
            <li> <a href="#">Panel de control</a></li>
          </ul>
        </nav>
      </div>

      <div class="Main">
        <h1>Venta</h1>
      </div>

      <div class="">
        <form class="" action="" method="post">
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

          <tr>
          <td><input type="text" name="id_p" placeholder="Id Producto" value="<?php if(isset($id_p)){echo $id_p;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="name_product" placeholder="Nombre del producto" value="<?php if(isset($pname)){echo $pname;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="cantidad_Producto" placeholder=" Cantidad" value="<?php if(isset($cantidadP)){echo $cantidadP;} ?>"  <?php if(isset($code) && $code == 7){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="precio_Producto" placeholder="Precio" value="<?php if(isset($precioP)){echo $precioP;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="precio_Total" placeholder="Precio Total" value="<?php if(isset($precioTotal)){echo $precioTotal;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <td><button type="submit" name="btn-search">Buscar</button></td>
            <td><button type="submit" name="btn-agregar">Agregar</button></td>
          </tr>
          <tr>
          <td><input type="text" name="numero_Venta" placeholder="No. Venta" value="<?php if(isset($numeroVenta)){echo $numeroVenta;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="fecha_Venta" placeholder="Fecha" value="<?php if(isset($fechaVenta)){echo $fechaVenta;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="id_Cliente" placeholder="Id Cliente" value="<?php if(isset($id_Cliente)){echo $id_Cliente;} ?>"  <?php if(isset($code) && $code == 7){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="nombre_Cliente" placeholder="N. Cliente" value="<?php if(isset($nombreCliente)){echo $nombreCliente;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <td><button type="submit" name="btn-searchCliente">Buscar Cliente</button></td>
          </tr>

          <?php
          if(isset($_POST["btn-agregar"])){

                $id_p = trim($_POST['id_p']);
                $pname = trim($_POST['name_product']);
                $cantidadP = trim($_POST['cantidad_Producto']);
                $precioP = trim($_POST['precio_Producto']);
                $precioTotal = trim($_POST['precio_Total']);
                $numeroVenta= trim($_POST['numero_Venta']);
                $cantidadP = trim($_POST['cantidad_Producto']);
                $id = '';
                $id_Cliente = trim($_POST['id_Cliente']);
                $nombreCliente = trim($_POST['nombre_Cliente']);
                $subtotalVenta = trim($_POST['subtotal_Venta']);
                $ivaVenta = trim($_POST['iva_Venta']);
                $totalVenta = trim($_POST['total_Venta']);

                $precioTotal = $precioP * $cantidadP;
                if(empty($id_p))
                {
                 $error = "Por favor ingresa un ID del producto";
                 $code = 1;
                }else {
                  $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  $query1 = "SELECT MAX(idVenta) AS id FROM listado_venta";

                  $statement = $connect->prepare($query1);
                  $statement->execute();
                  $count = $statement->rowCount();

                  while( $datos = $statement->fetch()){
                  $id = $datos[0];
                  }

                  $data = [
                  'id_p' => $id_p,
                  'pname' => $pname,
                  'cantidadP' => $cantidadP,
                  'precioP' => $precioP,
                  'precioTotal' => $precioTotal,
                  'numeroVenta'=> $id,
                ];

                  $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



                  // $rs = mysql_query("SELECT MAX(idVenta) AS id FROM listado_venta");
                  // if ($row = fetch($rs)) {
                  //   $id = trim($row[0]);
                  // }

                  $query = "INSERT INTO listadomovimientos(claveProducto, nombreProducto, cantidadProducto, precioProducto, precioTotalProducto, idDocumentoVenta)
                  VALUES (:id_p, :pname, :cantidadP, :precioP, :precioTotal, :numeroVenta)";
                  $statement = $connect->prepare($query);
                  $statement->execute($data);

                  // Inicio Tabla
                  $numeroVenta = trim($_POST['numero_Venta']);
                  $data = [
                  'numero_Venta' => $numeroVenta
                  ,];
                      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $query = "SELECT claveProducto, nombreProducto, cantidadProducto, precioProducto, precioTotalProducto FROM listadomovimientos WHERE idDocumentoVenta= :numero_Venta";
                      $statement = $connect->prepare($query);
                      $statement->execute($data);

                      while($registro = $statement->fetch())
                  {
                    echo "
                    <table>
                    <tr>
                    <td width='150'>".$registro['claveProducto']."</td>
                    <td width='150'>".$registro['nombreProducto']."</td>
                    <td width='150'>".$registro['precioProducto']."</td>
                    <td width='150'>".$registro['precioTotalProducto']."</td>
                    <td width='150'></td>
                    </tr>
                    </table>
                    ";
                  }



                   }


          }

          
          if(isset($_POST["btn-tabla"])){
            $numeroVenta = trim($_POST['numero_Venta']);
            $data = [
            'numero_Venta' => $numeroVenta
            ,];
                $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT claveProducto, nombreProducto, cantidadProducto, precioProducto, precioTotalProducto FROM listadomovimientos WHERE idDocumentoVenta= :numero_Venta";
                $statement = $connect->prepare($query);
                $statement->execute($data);

                while($registro = $statement->fetch())
            {
              echo "
              <table>
              <tr>
              <td width='150'>".$registro['claveProducto']."</td>
              <td width='150'>".$registro['nombreProducto']."</td>
              <td width='150'>".$registro['precioProducto']."</td>
              <td width='150'>".$registro['precioTotalProducto']."</td>
              <td width='150'></td>
              </tr>
              </table>
              ";
            }
          }?>

          <tr>
          <td><input type="text" name="subtotal_Venta" placeholder="Subtotal" value="<?php if(isset($subtotalVenta)){echo $subtotalVenta;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="iva_Venta" placeholder="IVA" value="<?php if(isset($ivaVenta)){echo $ivaVenta;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="total_Venta" placeholder="Total Venta" value="<?php if(isset($totalVenta)){echo $totalVenta;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>

          <tr>
            <td><button type="submit" name="btn-guardar">Guardar</button></td>
            <td><button type="submit" name="btn-nuevo">Nuevo</button></td>
            <td><button type="submit" name="btn-tabla">Tabla</button></td>
          </tr>
        </form>


      </div>

    </div>
  </body>
</html>
