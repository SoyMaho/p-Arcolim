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
    $id_Cliente ='';
    $name_Cliente= '';
    $apellido_Paterno = '';
    $razonSocial_Cliente = '';
    $rfc_Cliente = '';
    $email_Cliente = '';
    $tel_Cliente = '';
    $calle_Cliente = '';
    $numeroExt_Cliente = '';
    $numeroInt_Cliente = '';
    $colonia_Cliente = '';
    $ciudad_Cliente = '';
    $estado_Cliente = '';

    if(isset($_POST["btn-search"])){

          $id_Cliente = trim($_POST['id_Cliente']);
          if(empty($id_Cliente))
          {
           $error = "Por favor ingresa un ID";
           $code = 1;
          }
          else if(!is_numeric($id_Cliente))
          {
           $error = "Solo se admiten numeros";
           $code = 1;
         }else {
           $data = [
           'id_Cliente' => $id_Cliente
           ,];

               $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
               $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $query = "SELECT cat_clientes.id_Cliente, cat_clientes.nombre_Cliente, cat_clientes.pApellido_Cliente, cat_clientes.razonSocial_Cliente, cat_clientes.rfc_Cliente, cat_clientes.correo_Cliente, cat_clientes.tel_Cliente, cat_direccionclientes.calle_Cliente, cat_direccionclientes.numeroEx_Cliente, cat_direccionclientes.numeroInt_Cliente, cat_direccionclientes.colonia_Cliente, cat_direccionclientes.ciudad_Cliente, cat_direccionclientes.estado_Cliente FROM cat_clientes INNER JOIN cat_direccionclientes ON cat_clientes.id_Cliente = cat_direccionclientes.id_Direccion WHERE cat_clientes.id_Cliente = :id_Cliente AND cat_clientes.tipo_Entidad=2";
               $statement = $connect->prepare($query);
               $statement->execute($data);

               $count = $statement->rowCount();
               if($count == 0)
               {
                 echo '<script language="javascript">';
                 echo 'alert("El Proveedor no existe")';
                 echo '</script>';
               }
               else {
                 while( $datos = $statement->fetch()){
                 $name_Cliente = $datos[1];
                 $apellido_Paterno = $datos[2];
                 $razonSocial_Cliente = $datos[3];
                 $rfc_Cliente = $datos[4];
                 $email_Cliente = $datos[5];
                 $tel_Cliente = $datos[6];
                 $calle_Cliente = $datos[7];
                 $numeroExt_Cliente = $datos[8];
                 $numeroInt_Cliente = $datos[9];
                 $colonia_Cliente = $datos[10];
                 $ciudad_Cliente = $datos[11];
                 $estado_Cliente = $datos[12];
                 }
               }
         }





    }

    if(isset($_POST["btn-delete"])){
      $id_Cliente = trim($_POST['id_Cliente']);
      if(empty($id_Cliente))
      {
       $error = "Por favor ingresa un ID";
       $code = 1;
      }
      else if(!is_numeric($id_Cliente))
      {
       $error = "Solo se admiten numeros";
       $code = 1;
     }else {
       $data = [
       'id_Cliente' => $id_Cliente
       ,];

           $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
           $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $query = "SELECT * FROM cat_clientes WHERE id_Cliente = :id_Cliente AND tipo_Entidad=2";
           $statement = $connect->prepare($query);
           $statement->execute($data);

           $count = $statement->rowCount();
           if($count == 0)
           {
             echo '<script language="javascript">';
             echo 'alert("El proveedor no existe")';
             echo '</script>';
           }else {
             $id_Cliente = trim($_POST['id_Cliente']);

             $data1 = [
             'id_Direccion' => $id_Cliente
             ,];

             $data2 = [
             'id_Cliente' => $id_Cliente
             ,];

                 $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                 $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $query = "DELETE FROM cat_clientes WHERE id_Cliente = :id_Cliente";
                 $statement = $connect->prepare($query);
                 $statement->execute($data2);

                 $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                 $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $query = "DELETE FROM cat_direccionclientes WHERE id_Direccion = :id_Direccion";
                 $statement = $connect->prepare($query);
                 $statement->execute($data1);






                 echo '<script language="javascript">';
                 echo 'alert("Proveedor Eliminado")';
                 echo '</script>';
           }
     }


    }

    if (isset($_POST["btn-modif"])){

      $id_Cliente = trim($_POST['id_Cliente']);
      if(empty($id_Cliente))
      {
       $error = "Por favor ingresa un ID";
       $code = 1;
      }
      else if(!is_numeric($id_Cliente))
      {
       $error = "Solo se admiten numeros";
       $code = 1;
     }else {
       $data = [
       'id_Cliente' => $id_Cliente
       ,];

           $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
           $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $query = "SELECT * FROM cat_clientes WHERE id_Cliente = :id_Cliente AND tipo_Entidad=2";
           $statement = $connect->prepare($query);
           $statement->execute($data);

           $count = $statement->rowCount();
           if($count == 0)
           {
             echo '<script language="javascript">';
             echo 'alert("El proveedor no existe")';
             echo '</script>';



           }else {
             $id_Cliente = trim($_POST['id_Cliente']);
             $name_Cliente= trim($_POST['name_Cliente']);
             $apellido_Paterno = trim($_POST['apellido_Paterno']);
             $razonSocial_Cliente = trim($_POST['razonSocial_Cliente']);
             $rfc_Cliente = trim($_POST['rfc_Cliente']);
             $email_Cliente = trim($_POST['email_Cliente']);
             $tel_Cliente = trim($_POST['tel_Cliente']);
             $calle_Cliente = trim($_POST['calle_Cliente']);
             $numeroExt_Cliente = trim($_POST['numeroExt_Cliente']);
             $numeroInt_Cliente = trim($_POST['numeroInt_Cliente']);
             $colonia_Cliente = trim($_POST['colonia_Cliente']);
             $ciudad_Cliente = trim($_POST['ciudad_Cliente']);
             $estado_Cliente = trim($_POST['estado_Cliente']);

             $data=[

             'calle_Cliente' => $calle_Cliente,
             'numeroExt_Cliente'=>$numeroExt_Cliente,
             'numeroInt_Cliente'=>$numeroInt_Cliente,
             'colonia_Cliente'=>$colonia_Cliente,
             'ciudad_Cliente'=>$ciudad_Cliente,
             'estado_Cliente'=>$estado_Cliente,
             'id_Direccion'=>$id_Cliente,
             ];
             $data1 = [

             'name_Cliente' => $name_Cliente,
             'apellido_Paterno' => $apellido_Paterno,
             'razonSocial_Cliente' => $razonSocial_Cliente,
             'rfc_Cliente' => $rfc_Cliente,
             'direccion_Cliente'=>$id_Cliente,
             'email_Cliente' => $email_Cliente,
             'tel_Cliente'=>$tel_Cliente,
             'id_Cliente'=>$id_Cliente,
             ];

             $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
             $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $query = "UPDATE cat_direccionclientes SET calle_Cliente = :calle_Cliente, numeroEx_Cliente = :numeroExt_Cliente,
             numeroInt_Cliente = :numeroInt_Cliente, colonia_Cliente= :colonia_Cliente, ciudad_Cliente = :ciudad_Cliente,
             estado_Cliente = :estado_Cliente WHERE id_Direccion = :id_Direccion";
             $statement = $connect->prepare($query);
             $statement->execute($data);

             $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
             $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $query = "UPDATE cat_clientes SET nombre_Cliente = :name_Cliente, pApellido_Cliente = :apellido_Paterno,
             razonSocial_Cliente = :razonSocial_Cliente, rfc_Cliente= :rfc_Cliente, direccion_Cliente = :direccion_Cliente,
             correo_Cliente = :email_Cliente, tel_Cliente= :tel_Cliente WHERE id_Cliente = :id_Cliente";
             $statement = $connect->prepare($query);
             $statement->execute($data1);



             echo '<script language="javascript">';
             echo 'alert("Proveedor Modificado Exitosamente")';
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
                <li><a href="#">Registrar Venta</a></li>
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
        <h1>Listado de Proveedores</h1>
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
            <h3>Datos del Proveedor</h3>
          <td><input type="text" name="id_Cliente" placeholder="ID " value="<?php if(isset($id_Cliente)){echo $id_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="name_Cliente" placeholder="Nombre del Proveedor" value="<?php if(isset($name_Cliente)){echo $name_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="apellido_Paterno" placeholder="Apellido Paterno" value="<?php if(isset($apellido_Paterno)){echo $apellido_Paterno;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="razonSocial_Cliente" placeholder="Razon Social" value="<?php if(isset($razonSocial_Cliente)){echo $razonSocial_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="rfc_Cliente" placeholder="RFC" value="<?php if(isset($rfc_Cliente)){echo $rfc_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="email_Cliente" placeholder="Correo Electronico" value="<?php if(isset($email_Cliente)){echo $email_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="tel_Cliente" placeholder="Numero Telefonico" value="<?php if(isset($tel_Cliente)){echo $tel_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <h3>Direccion</h3>
          <td><input type="text" name="calle_Cliente" placeholder="Calle" value="<?php if(isset($calle_Cliente)){echo $calle_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="numeroExt_Cliente" placeholder="Numero Exterior" value="<?php if(isset($numeroExt_Cliente)){echo $numeroExt_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="numeroInt_Cliente" placeholder="Numero Interior" value="<?php if(isset($numeroInt_Cliente)){echo $numeroInt_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="colonia_Cliente" placeholder="Colonia" value="<?php if(isset($colonia_Cliente)){echo $colonia_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="ciudad_Cliente" placeholder="Ciudad" value="<?php if(isset($ciudad_Cliente)){echo $ciudad_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="estado_Cliente" placeholder="Estado" value="<?php if(isset($estado_Cliente)){echo $estado_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <td><button type="submit" name="btn-search">Buscar Proveedor</button></td>
            <td> <button type="submit" name="btn-delete">Eliminar Proveedor</button></td>
            <td> <button type="submit" name="btn-modif">Modificar Proveedor</button></td>
          </tr>

        </form>


      </div>

    </div>
  </body>
</html>
