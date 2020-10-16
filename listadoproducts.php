<?php
session_start();
include("conexion.php");
include_once 'sesion.php';
$sesion = new sesion ();

$currentUser = $sesion->getCurrentUser();




  //Si hay sesion , entonces se muestra la pagina y el usuario ingresado, de lo contrario retorna a index


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

        <?php
        try {
          if (!isset($_SESSION['user'])){
            header('Location: index.php');


          }
          else {
            echo '<h2> Bienvenido </h2>' .$currentUser ;
            $id_p = '';
            $pname = '';
            $descP = '';
            $costoP = '';
            $precioP = '';
            $unidadP = '';
            $existenciaP = '';

            if(isset($_POST["btn-signup"])){

                  $id_p = trim($_POST['id_p']);
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
                        // $id_p = '';
                        // $pname = '';
                        // $descP = '';
                        // $costoP = '';
                        // $precioP = '';
                        // $unidadP = '';
                        // $existenciaP = '';


                      }
                      else {
                        while( $datos = $statement->fetch()){
                        $pname = $datos[1];
                        $descP = $datos[2];
                        $costoP = $datos[3];
                        $precioP = $datos[4];
                        $unidadP = $datos[5];
                        $existenciaP = $datos[6];

                        }
                      }




            }

            if(isset($_POST["btn-delete"])){
              $id_p = trim($_POST['id_p']);
              $data = [
              'id_p' => $id_p
              ,];

                  $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $query = "DELETE FROM cat_producto WHERE id_Producto = :id_p";
                  $statement = $connect->prepare($query);
                  $statement->execute($data);
                  echo '<script language="javascript">';
                  echo 'alert("Producto Eliminado")';
                  echo '</script>';



            }

            if (isset($_POST["btn-modif"])){
              $id_p = trim($_POST['id_p']);
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

              echo '<script language="javascript">';
              echo 'alert("Producto Modificado Exitosamente")';
              echo '</script>';


            }

          }



        } catch(PDOException $error)
          {
               $message = $error->getMessage();
          }

         ?>



         <a href="logout.php"> Salir</a>
      </div>
    </header>



    <div class="work_Section">
      <div class="NavBar">
        <nav>
          <ul>
            <li> <a href="listadoproducts.php">Productos</a>
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
        <h1>Listado de Productos</h1>
      </div>

      <div class="">
        <form class="" action="" method="post">
          <tr>
          <td> <h3>Id Producto</h3> <input type="text" name="id_p" placeholder="ID Producto" value="<?php if(isset($id_p)){echo $id_p;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td> <h3>Nombre</h3> <input type="text" name="name_product" placeholder="Nombre del producto" value="<?php if(isset($id_p)){echo $pname;}?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
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
            <td><button type="submit" name="btn-signup">Buscar Producto</button></td>
            <td> <button type="submit" name="btn-delete">Eliminar Producto</button></td>
            <td> <button type="submit" name="btn-modif">Modificar Producto</button></td>
          </tr>

        </form>


      </div>

    </div>
  </body>
</html>
