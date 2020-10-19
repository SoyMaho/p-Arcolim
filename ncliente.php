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

            if(isset($_POST["btn-regCliente"])){

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

                  $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $query = "SELECT * FROM cat_clientes WHERE id_Cliente = :id_Cliente";
                  $statement = $connect->prepare($query);
                  $statement->execute(
                      [
                        'id_Cliente' => $id_Cliente,
                      ]
                     );
                    $count = $statement->rowCount();
                    if($count > 0)
                    {
                      echo '<script language="javascript">';
                      echo 'alert("El id de este cliente ya existe")';
                      echo '</script>';
                    }
                    else
                    {
                      $message = "Exito";
                      $data=[
                      'id_Direccion'=>$id_Cliente,
                      'calle_Cliente' => $calle_Cliente,
                      'numeroExt_Cliente'=>$numeroExt_Cliente,
                      'numeroInt_Cliente'=>$numeroInt_Cliente,
                      'colonia_Cliente'=>$colonia_Cliente,
                      'ciudad_Cliente'=>$ciudad_Cliente,
                      'estado_Cliente'=>$estado_Cliente,
                      ];
                      $data1 = [
                      'id_Cliente' => $id_Cliente,
                      'name_Cliente' => $name_Cliente,
                      'apellido_Paterno' => $apellido_Paterno,
                      'razonSocial_Cliente' => $razonSocial_Cliente,
                      'rfc_Cliente' => $rfc_Cliente,
                      'direccion_Cliente'=>$id_Cliente,
                      'email_Cliente' => $email_Cliente,
                      'tel_Cliente'=>$tel_Cliente,
                      ];



                      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $query = "INSERT INTO cat_direccionclientes(id_Direccion, calle_Cliente, numeroEx_Cliente, numeroInt_Cliente, colonia_Cliente, ciudad_Cliente, estado_Cliente) VALUES (:id_Direccion, :calle_Cliente, :numeroExt_Cliente, :numeroInt_Cliente, :colonia_Cliente, :ciudad_Cliente, :estado_Cliente)";
                      $statement = $connect->prepare($query);
                      $statement->execute($data);

                      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $query = "INSERT INTO cat_clientes (id_Cliente, nombre_Cliente, pApellido_Cliente, razonSocial_Cliente, rfc_Cliente, direccion_Cliente, correo_Cliente, tel_Cliente) VALUES (:id_Cliente, :name_Cliente, :apellido_Paterno, :razonSocial_Cliente, :rfc_Cliente, :direccion_Cliente, :email_Cliente,:tel_Cliente)";
                      $statement = $connect->prepare($query);
                      $statement->execute($data1);

                      echo '<script language="javascript">';
                      echo 'alert("Cliente Registrado Exitosamente")';
                      echo '</script>';

                    }
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
            <li> <a>Productos</a>
                <ul>

                  <li><a href="listadoproducts.php">Lista</a></li>
                  <li><a href="nproducts.php">Registrar Producto</a></li>

                </ul>
            </li>
            <li> <a href="/listadoproducts.php">Venta</a>
              <ul>
                <li><a href="/ncliente.php">Registrar Venta</a></li>
              </ul>
            </li>
            <li> <a href="/listadoproducts.php">Proveedores</a>
              <ul>
                <li><a href="/nproducts.php">Registrar Proveedor</a></li>
                <li><a href="/modproducts.php">Modificar Proveedor</a></li>
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
        <h1>Registrar Cliente</h1>
      </div>

      <div class="">
        <form class="" action="" method="post">
          <tr>
            <h3>Datos del cliente</h3>
          <td><input type="text" name="id_Cliente" placeholder="ID Cliente" value="<?php if(isset($id_Cliente)){echo $id_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="name_Cliente" placeholder="Nombre del cliente" value="<?php if(isset($name_Cliente)){echo $name_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
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
            <td><button type="submit" name="btn-regCliente">Registrar Cliente</button></td>
          </tr>
        </form>


      </div>

    </div>
  </body>
</html>
