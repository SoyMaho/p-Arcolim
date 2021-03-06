<?php
session_start();
include("conexion.php");
include_once 'sesion.php';
$sesion = new sesion ();
?>
<?php
try {
  if (!isset($_SESSION['user'])){
    header('Location: index.php');
  }
  else {
    $currentUser = $sesion->getCurrentUser();
    echo '<h2> Bienvenido </h2>' .$currentUser ;
    $id_p = trim($_POST['select_product']);
    $pname = trim($_POST['name_product']);
    $descP = trim($_POST['descripcion_Producto']);
    $costoP = trim($_POST['costo_Producto']);
    $precioP = trim($_POST['precio_Producto']);
    $unidadP = trim($_POST['unidad_Producto']);
    $existenciaP = trim($_POST['existencia_Producto']);


    if(isset($_POST["btn-signup"])){

          $id_p = trim($_POST['select_product']);
          if(empty($id_p))
          {
           $error = "Por favor selecciona un producto";
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
          else {
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
                 $descP = $datos[2];
                 $costoP = $datos[3];
                 $precioP = $datos[4];
                 $unidadP = $datos[5];
                 $existenciaP = $datos[6];
                 $estadoRegistroP = $datos[7];
                 $pOculto =$datos[8];

                 }
               }
             }





    }

    if(isset($_POST["btn-delete"])){
      $id_p = trim($_POST['select_product']);
      if(empty($id_p))
      {
       $error = "Por favor selecciona un producto";
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
      else {
       $data = [
       'id_p' => $id_p
       ,];

           $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
           $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $query = "SELECT id_Producto, estadoRegistroP FROM cat_producto WHERE id_Producto = :id_p";
           $statement = $connect->prepare($query);
           $statement->execute($data);

           while( $datos = $statement->fetch()){
           $estadoRegistroP = $datos[1];
           }

           $count = $statement->rowCount();
           if($count == 0)
           {
             echo '<script language="javascript">';
             echo 'alert("El producto no existe")';
             echo '</script>';



           }else {
             $id_p = trim($_POST['select_product']);

             if ($estadoRegistroP !=2) {

               $data = [
               'id_p' => $id_p
               ,];

                   $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                   $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                   //Update para cambiar el estado del cliente a "Eliminado"
                   $query = "UPDATE cat_producto SET estadoRegistroP = 3 WHERE id_Producto = :id_p";
                   $statement = $connect->prepare($query);
                   $statement->execute($data);

                   echo "<script>";
                   echo "alert('Producto Eliminado');";
                   echo 'window.location.href = "listadoproducts.php"';
                   echo "</script>";
             }else {
               echo '<script language="javascript">';
               echo 'alert("El producto tiene documentos asociados y no se puede eliminar, como alternativa se puede optar por inactivarlo")';
               echo '</script>';

             }

           }
     }
    }


    if (isset($_POST["btn-modif"])){

      $id_p = trim($_POST['select_product']);
      if(empty($id_p))
      {
       $error = "Por favor selecciona un producto";
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
       else if(empty($existenciaP))
       {
        $error = "Ingresa la existencia del producto";
        $code = 7;
       }
       else if(!is_numeric($existenciaP))
       {
        $error = "Solo se admiten numeros";
        $code = 7;
       }
       else if($existenciaP>99999)
       {
        $error = "La existencia no puede ser mayor a 99,999";
        $code = 7;
       }
       else if($existenciaP<-99999)
       {
        $error = "La existencia no puede ser menor a -99,999";
        $code = 7;
       }
       else {
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
           }else {

             $id_p = trim($_POST['select_product']);
             $pname = trim($_POST['name_product']);
             $descP = trim($_POST['descripcion_Producto']);
             $costoP = trim($_POST['costo_Producto']);
             $precioP = trim($_POST['precio_Producto']);
             $unidadP = trim($_POST['unidad_Producto']);
             $existenciaP = trim($_POST['existencia_Producto']);

             $data = [
             'name_product' => $pname,
             'descripcion_Producto' => $descP,
             'costo_Producto' => $costoP,
             'precio_Producto' => $precioP,
             'unidad_Producto' => $unidadP,
             'existencia_Producto' => $existenciaP
             ,'id_p' => $id_p,];

             $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
             $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $query = "UPDATE cat_producto SET nombre_Producto = :name_product, descripcion_Producto = :descripcion_Producto, costo_Producto = :costo_Producto, precio_Producto = :precio_Producto, unidad_Producto = :unidad_Producto, existencia_Producto = :existencia_Producto WHERE id_Producto = :id_p";
             $statement = $connect->prepare($query);
             $statement->execute($data);

             if (isset($_POST["check_estadoRegistro"])) {
               $data = [
               'id_p' => $id_p
               ,];
               $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
               $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $query = "UPDATE cat_producto SET pOculto =0  WHERE id_Producto = :id_p";
               $statement = $connect->prepare($query);
               $statement->execute($data);
             }else {
               $data1 = [
               'id_p' => $id_p
               ,];
               $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
               $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $query = "UPDATE cat_producto SET pOculto =1  WHERE id_Producto = :id_p";
               $statement = $connect->prepare($query);
               $statement->execute($data1);
             }

             echo '<script language="javascript">';
             echo 'alert("Producto Modificado Exitosamente")';
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
      <a href="home.php"><img src="img/arcolim_Logo.jpg" id="logo_Home" alt=""></a>
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
        <h1>Listado de Productos</h1>
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
          <!-- <tr>
          <td> <h3>Id Producto</h3> <input type="text" name="id_p" placeholder="ID Producto" value="<?php if(isset($id_p)){echo $id_p;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr> -->

          <tr>
              <td><select class="" name="select_product">
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
          <tr>
            <input class="inputShort"type="checkbox" name="check_estadoRegistro" id="cbox_estadoRegistro" value="2"<?php if ($pOculto==0) {echo "checked";} ?>/>
          </tr>
          <tr>
          <td> <h3>Nombre</h3> <input type="text" name="name_product" placeholder="" value="<?php if(isset($id_p)){echo $pname;}?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h3>Descripcion</h3><input type="text" name="descripcion_Producto" placeholder="" value="<?php if(isset($id_p)){echo $descP;}?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h3>Costo</h3><input type="text" name="costo_Producto" placeholder="" value="<?php if(isset($id_p)){echo $costoP;}?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h3>Precio</h3><input type="text" name="precio_Producto" placeholder="" value="<?php if(isset($id_p)){echo $precioP;}?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td> <h3>Unidad de medida</h3><input type="text" name="unidad_Producto" placeholder="" value="<?php if(isset($id_p)){echo $unidadP;}?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h3>Existencia</h3><input type="text" name="existencia_Producto" placeholder="" value="<?php if(isset($id_p)){echo $existenciaP;}?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <td><button type="submit" name="btn-signup">Seleccionar Producto</button></td>
            <td> <button type="submit" name="btn-delete">Eliminar Producto</button></td>
            <td> <button type="submit" name="btn-modif">Modificar Producto</button></td>
          </tr>

        </form>


      </div>

    </div>
  </body>
</html>
