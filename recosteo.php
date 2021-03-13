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

    if (isset($_POST['btn-recosteo'])) {
      $idProducto=trim($_POST['select_product']);

      if (empty($idProducto)) {
        $error = "Por favor selecciona un producto";
        $code = 1;
      }else {
      
      $dataSuma = [
    'idProducto'=>$idProducto
    ,];

      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //Se valida la cantidad de entradas totales del producto
      $query="SELECT costoProducto FROM listado_entrada WHERE idProductoEntrada=:idProducto AND estadoRegistroE !=3";
      $statement = $connect->prepare($query);
      $statement->execute($dataSuma);
      $count=$statement->rowCount();

      //Se suman los costos de cada entrada para el producto
      $dataSuma = [
    'idProducto'=>$idProducto
    ,];
      $querySuma= "SELECT SUM(costoProducto) AS SUMA FROM listado_entrada WHERE idProductoEntrada = :idProducto AND estadoRegistroE !=3";
      $statement = $connect->prepare($querySuma);
      $statement->execute($dataSuma);

      //Se recorre la consulta y se asigna al string suma, el cual se divide en la cantidad de entradas que no sean eliminadas

      while($datos = $statement->fetch()){
      $Suma = $datos[0];
      }
      $div=($Suma/$count);

      $dataSumaExistencia =[
        'costoProducto' =>$div,
        'idProducto'=>$idProducto
      ,];

      //Se actualiza la existencia
      $queryUpdateSuma = "UPDATE cat_producto
               SET costo_Producto = :costoProducto
               WHERE id_Producto = :idProducto";
               $statement2 = $connect->prepare($queryUpdateSuma);
               $statement2->execute($dataSumaExistencia);
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
            <li> <a href="">Reportes</a></li>
            <li> <a href="usuarios.php">Usuarios</a></li>
            <li><a href="">Utilerias</a>
              <ul>
                <li><a href="recosteo.php">Recosteo</a></li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>

      <div class="Main">
        <h1>Recosteo Promedio</h1>
        <p>Esta utileria te ayudara a calcular y asignar un costo promedio al producto que selecciones</p>
        <p>Tomando como base el costo asignado en cada documento de entrada creado para el producto</p>
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
              <div class="">
                <h3>Producto</h3>
                <td><select class="" name="select_product">
                  <option value="<?php if(isset($idProducto)){echo $idProducto;}  ?>"><?php if(isset($nameProduct)){echo $nameProduct;}  ?></option>
                  <?php
                      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $query = "SELECT id_Producto, nombre_Producto FROM cat_producto WHERE estadoRegistroP!=3 AND pOculto=0";
                      $statement = $connect->prepare($query);
                      $statement->execute();

                      while($registro = $statement->fetch())
                  {
                    echo"<option value=".$registro["id_Producto"].">".$registro["nombre_Producto"]."</option>";
                  }
                   ?>
                  </select>
                </td>
              </div>
              <tr>
                <td><button type="submit" name="btn-recosteo">Recosteo</button></td>
              </tr>
          </form>
        </div>
      </div>

    </div>
  </body>
</html>
