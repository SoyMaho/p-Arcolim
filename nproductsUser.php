<?php
session_start();
include("conexion.php");
include_once 'sesion.php';
include("funcsql.php");
$sesion = new sesion ();
$funcsql = new funcionSQL();
?>
<?php
try {
  if (!isset($_SESSION['user'])){
    header('Location: index.php');
  }
  else {
    $currentUser = $sesion->getCurrentUser();
    echo '<h2> Bienvenido </h2>' .$currentUser ;


    $idAutoProducto= $funcsql ->ultimoId("id_Producto","cat_producto","id_Producto");
    $id_p = $idAutoProducto+1;

    if(isset($_POST["btn-signup"])){
          // Se elimina por que el ID es autoGenerado
          // $id_p = trim($_POST['id_p']);
          $pname = trim($_POST['name_product']);
          $descP = trim($_POST['descripcion_Producto']);
          $costoP = trim($_POST['costo_Producto']);
          $precioP = trim($_POST['precio_Producto']);
          $unidadP = trim($_POST['unidad_Producto']);

          if(empty($id_p))
          {
           $error = "Por favor ingresa un ID";
           $code = 1;
          }
          else if(!is_numeric($id_p))
          {
           $error = "Solo se admiten numeros";
           $code = 1;
          }
          else if($id_p>9999)
          {
           $error = "El ID no puede ser mayor a 4 Digitos";
           $code = 1;
          }
          else if($id_p<1)
          {
           $error = "El ID no puede ser menor a 1";
           $code = 1;
          }
           else if(empty($pname))
           {
            $error = "Ingresa el nombre del producto";
            $code = 2;
           }
           else if(strlen($pname)>100)
           {
            $error = "El nombre del producto no puede exceder 100 caracteres";
            $code = 2;
           }
           else if(empty($descP))
           {
            $error = "Ingresa la descripcion del producto";
            $code = 3;
           }
           else if(strlen($descP)>150)
           {
            $error = "La descripcion del producto no puede exceder 150 caracteres";
            $code = 3;
           }
           else if(empty($costoP))
           {
            $error = "Ingresa el costo";
            $code = 4;
           }
           else if(!is_numeric($costoP))
           {
            $error = "Solo se admiten numeros";
            $code = 4;
           }
           else if($costoP>9999999)
           {
            $error = "El costo no puede ser mayor a 9,999,999.00";
            $code = 4;
           }
           else if($costoP<0)
           {
            $error = "El costo no puede ser menor a 0.00";
            $code = 4;
           }
           else if(empty($precioP))
           {
            $error = "Ingresa el precio";
            $code = 5;
           }
           else if(!is_numeric($precioP))
           {
            $error = "Solo se admiten numeros";
            $code = 5;
           }
           else if($precioP>9999999)
           {
            $error = "El precio no puede ser mayor a 9,999,999.00";
            $code = 5;
           }
           else if($precioP<0)
           {
            $error = "El precio no puede ser menor a 0.00";
            $code = 5;
           }
           else if(empty($unidadP))
           {
            $error = "Ingresa la unidad del producto";
            $code = 6;
           }
           else if(strlen($unidadP)>10)
           {
            $error = "La unidad del producto no puede exceder 10 caracteres";
            $code = 2;
           }
            else {
               $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
               $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $query = "SELECT * FROM cat_producto WHERE id_Producto = :id_p";
                 $statement = $connect->prepare($query);
                 $statement->execute(
                   [
                     'id_p' => $id_p,
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
                   echo 'alert("El id de este producto ya existe")';
                   echo '</script>';
                 }
                 else
                 {
                   $message = "Exito";
                   $data = [
                   'id_p' => $id_p,
                   'name_product' => $pname,
                   'descripcion_Producto' => $descP,
                   'costo_Producto' => $costoP,
                   'precio_Producto' => $precioP,
                   'unidad_Producto' => $unidadP,
                   ];

                   $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                   $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   $query = "INSERT INTO cat_producto (id_Producto, nombre_Producto, descripcion_Producto, costo_Producto, precio_Producto, unidad_Producto, existencia_Producto) VALUES (:id_p, :name_product, :descripcion_Producto, :costo_Producto, :precio_Producto, :unidad_Producto, DEFAULT)";
                   $statement = $connect->prepare($query);
                   $statement->execute($data);

                   echo '<script language="javascript">';
                   echo 'alert("Producto Registrado Exitosamente")';
                   echo '</script>';

                 }
             }


    }


  }



} catch(PDOException $error)
  {
       $message = $error->getMessage();
  }

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/main.css">
    <style type="text/css">
    <?php
    if(isset($error))
    {
     ?>
     input:focus
     {
      border:solid red 1px;
     }
     <?php
    }
    ?>
    </style>
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
                  <li><a href="listadoproductsUser.php">Listado</a></li>
                  <li><a href="nproductsUser.php">Registrar</a></li>
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
          </ul>
        </nav>
      </div>

      <div class="Main">
        <h1>Registrar Producto</h1>
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
          <!-- Se eliminar por que el ID es autogenerado <tr>
          <td><h3>Id Producto</h3><input type="text" name="id_p" placeholder="ID Producto" value="<?php if(isset($id_p)){echo $id_p;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr> -->
          <tr>
          <td><h3>Nombre</h3><input type="text" name="name_product" placeholder="Nombre del producto" value="<?php if(isset($pname)){echo $pname;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h3>Descripcion</h3><input type="text" name="descripcion_Producto" placeholder="Descripcion del producto" value="<?php if(isset($descP)){echo $descP;} ?>"  <?php if(isset($code) && $code == 3){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h3>Costo</h3><input type="text" name="costo_Producto" placeholder="Costo del producto" value="<?php if(isset($costoP)){echo $costoP;} ?>"  <?php if(isset($code) && $code == 4){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h3>Precio</h3><input type="text" name="precio_Producto" placeholder="Precio del producto" value="<?php if(isset($precioP)){echo $precioP;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h3>Unidad de medida</h3><input type="text" name="unidad_Producto" placeholder="Unidad del producto" value="<?php if(isset($unidadP)){echo $unidadP;} ?>"  <?php if(isset($code) && $code == 6){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <td><button type="submit" name="btn-signup">Registrar Producto</button></td>
          </tr>
        </form>


      </div>

    </div>
  </body>
</html>