<?php
session_start();
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
try {
  if (!isset($_SESSION['user'])){
    header('Location: index.php');
  }
  //Condicion para Evitar que el usuario sin privilegios, ingrese a la pagina de Usuarios
  else if ($_SESSION['tipoUsuario']!=1) {
      header('Location: index.php');
    }
    else {
    $currentUser = $sesion->getCurrentUser();
    echo '<h2> Bienvenido </h2>' .$currentUser;

    if(isset($_POST["btn-regUser"])){

          $userName = trim($_POST['nombre_Usuario']);
          $userMail = trim($_POST['correo_Usuario']);
          $userPass = trim($_POST['pass_Usuario']);
          $userType = trim($_POST['tipoUsuario']);

          if(empty($userName))
          {
           $error = "Por favor ingresa un nombre de usuario";
           $code = 1;
          }
          else if(strlen($userName)>100)
          {
           $error = "El nombre del usuario no puede exceder 100 caracteres";
           $code = 1;
          }
          else if(empty($userMail))
          {
           $error = "Ingresa tu Correo electronico";
           $code = 2;
          }
          else if(!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $userMail))
          {
           $error = "La direccion de correo no es valida";
           $code = 2;
          }
          else if(strlen($userPass)>50)
          {
           $error = "La contraseña no puede exceder 50 caracteres";
           $code = 3;
          }
          else if(strlen($userPass)<6)
          {
           $error = "La contraseña no puede ser menor a 6 caracteres";
           $code = 3;
          }
          else if(!preg_match('`[a-z]`',$userPass))
          {
           $error = "La contraseña debe tener al menos una letra minuscula";
           $code = 3;
          }
          else if(!preg_match('`[A-Z]`',$userPass))
          {
           $error = "La contraseña debe tener al menos una letra mayuscula";
           $code = 3;
          }
          else if(!preg_match('`[0-9]`',$userPass))
          {
           $error = "La contraseña debe tener al menos un numero";
           $code = 3;
          }
          else {
               $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
               $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $query = "SELECT * FROM users WHERE nombre_Usuario = :nombre_Usuario";
                 $statement = $connect->prepare($query);
                 $statement->execute(
                   [
                     'nombre_Usuario' => $userName,
                   ]

                  );
                 $count = $statement->rowCount();
                 if($count > 0)
                 {
                   echo '<script language="javascript">';
                   echo 'alert("Este usuario ya esta registrado")';
                   echo '</script>';
                 }
                 else
                 {
                   $message = "Exito";
                   $data = [
                   'nombre_Usuario' => $userName,
                   'correo_Usuario' => $userMail,
                   'pass_Usuario' => $userPass,
                   'tipoUsuario' => $userType
                   ,];

                   $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                   $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   $query = "INSERT INTO users (nombre_Usuario,correo_Usuario,password_Usuario,tipo_Usuario) VALUES (:nombre_Usuario,:correo_Usuario,:pass_Usuario,:tipoUsuario)";
                   $statement = $connect->prepare($query);
                   $statement->execute($data);

                   echo '<script language="javascript">';
                   echo 'alert("Usuario Registrado Exitosamente")';
                   echo '</script>';

                 }
             }


    }

    if (isset($_POST["btn-searchUser"])) {

      $userName = trim($_POST['nombre_Usuario']);
      $userMail = trim($_POST['correo_Usuario']);
      $userPass = trim($_POST['pass_Usuario']);
      $userType = trim($_POST['tipoUsuario']);


            if(empty($userName))
            {
             $error = "Por favor ingresa un nombre";
             $code = 1;
            }else {
              $data = [
              'nombre_Usuario' => $userName
              ,];

                  $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $query = "SELECT nombre_Usuario,correo_Usuario,password_Usuario,tipo_Usuario FROM users WHERE nombre_Usuario = :nombre_Usuario";
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
                    $userName = $datos[0];
                    $userMail = $datos[1];
                    $userPass = $datos[2];
                    $userType = $datos[3];
                    }
                  }
               }




    }

    if (isset($_POST["btn-deleteUser"])) {

        $userName = trim($_POST['nombre_Usuario']);
        if(empty($userName))
        {
         $error = "Por favor ingresa un nombre de usuario";
         $code = 1;
        }
        else {
         $data = [
         'nombre_Usuario' => $userName
         ,];

             $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
             $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $query = "SELECT * FROM users WHERE nombre_Usuario = :nombre_Usuario";
             $statement = $connect->prepare($query);
             $statement->execute($data);

             $count = $statement->rowCount();
             if($count == 0)
             {
               echo '<script language="javascript">';
               echo 'alert("El usuario no esta registrado")';
               echo '</script>';



             }else {
               $userName = trim($_POST['nombre_Usuario']);
               $data = [
               'nombre_Usuario' => $userName
               ,];

                   $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                   $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   $query = "DELETE FROM users WHERE nombre_Usuario = :nombre_Usuario";
                   $statement = $connect->prepare($query);
                   $statement->execute($data);
                   echo '<script language="javascript">';
                   echo 'alert("Usuario Eliminado")';
                   echo '</script>';
             }
       }

    }

    if (isset($_POST["btn-editUser"])) {
      $userName = trim($_POST['nombre_Usuario']);
      $userMail = trim($_POST['correo_Usuario']);
      $userPass = trim($_POST['pass_Usuario']);
      $userType = trim($_POST['tipoUsuario']);
      if(empty($userName))
      {
       $error = "Por favor ingresa un nombre de usuario";
       $code = 1;
      }
      else if(strlen($userName)>100)
      {
       $error = "El nombre del usuario no puede exceder 100 caracteres";
       $code = 1;
      }
      else if(empty($userMail))
      {
       $error = "Ingresa tu Correo electronico";
       $code = 2;
      }
      else if(!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $userMail))
      {
       $error = "La direccion de correo no es valida";
       $code = 2;
      }
      else if(strlen($userPass)>50)
      {
       $error = "La contraseña no puede exceder 50 caracteres";
       $code = 3;
      }
      else if(strlen($userPass)<6)
      {
       $error = "La contraseña no puede ser menor a 6 caracteres";
       $code = 3;
      }
      else if(!preg_match('`[a-z]`',$userPass))
      {
       $error = "La contraseña debe tener al menos una letra minuscula";
       $code = 3;
      }
      else if(!preg_match('`[A-Z]`',$userPass))
      {
       $error = "La contraseña debe tener al menos una letra mayuscula";
       $code = 3;
      }
      else if(!preg_match('`[0-9]`',$userPass))
      {
       $error = "La contraseña debe tener al menos un numero";
       $code = 3;
      }
      else {
      $data = [
      'nombre_Usuario' => $userName
      ,];

          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT * FROM users WHERE nombre_Usuario = :nombre_Usuario";
          $statement = $connect->prepare($query);
          $statement->execute($data);

          $count = $statement->rowCount();
          if($count == 0)
          {
            echo '<script language="javascript">';
            echo 'alert("El usuario no esta registrado")';
            echo '</script>';
          }else {


            $data = [
            'nombre_Usuario' => $userName,
            'correo_Usuario' => $userMail,
            'pass_Usuario' => $userPass,
            'tipoUsuario' => $userType,
            ];

            $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "UPDATE users SET nombre_Usuario = :nombre_Usuario, correo_Usuario = :correo_Usuario, password_Usuario = :pass_Usuario, tipo_Usuario = :tipoUsuario WHERE nombre_Usuario = :nombre_Usuario";
            $statement = $connect->prepare($query);
            $statement->execute($data);

            echo '<script language="javascript">';
            echo 'alert("Usuario Modificado Exitosamente")';
            echo '</script>';
          }

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
              <?php
              if ($_SESSION['tipoUsuario']!=2) {
                echo "<li>";
                  echo "<a>Reportes</a>";
                  echo "<ul>";
                    echo "<li><a href='reportventasproduct.php'>Ventas por producto</a></li>";
                    echo "<li><a href='reportpedidoscliente.php'>Pedidos por cliente</a> </li>";
                    echo "<li> <a href='reportcostoproducto.php'>Costo por producto</a> </li>";
                    echo "<li> <a href='reportservicioscliente.php'>Servicios por cliente</a> </li>";
                    echo "<li><a href='reportservicioservices.php'>Servicios por servicio</a></li>";
                    echo "<li><a href='reportclientes.php'>Reporte de clientes</a></li>";
                  echo "</ul>";
                echo "</li>";
              }
              ?>
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
        <h1>Control de usuarios</h1>
        <?php
        //Tabla Sin if para mostrar los ultimos movimientos de la venta


            $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT users.nombre_Usuario, users.correo_Usuario, users.password_Usuario, tipo_usuario.tipo_Usuario FROM users INNER JOIN tipo_usuario ON users.tipo_Usuario = tipo_usuario.id_tipoUsuario";
            $statement = $connect->prepare($query);
            $statement->execute();
            echo "<div id='tablaUser'>
            <h3>Usuarios Registrados</h3>
            <table>
            <tr>
            <td width='150'>Nombre</td>
            <td width='150'>Correo Electronico</td>
            <td width='150'>Contraseña</td>
            <td width='150'>Tipo de usuario</td>
            <td width='300'></td>
            </tr>";
            while($registro = $statement->fetch())
        {
          echo"
          <tr>
          <td width='150'>".$registro[0]."</td>
          <td width='150'>".$registro[1]."</td>
          <td width='150'>".$registro[2]."</td>
          <td width='150'>".$registro[3]."</td>
          <td width='300'>
          </td>
          </tr>
          ";
        }
        echo "</table></div>>";
         ?>
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
            <h3>Datos del usuario</h3>
          <td><input type="text" name="nombre_Usuario" placeholder="Nombre del Usuario" value="<?php if(isset($userName)){echo $userName;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="correo_Usuario" placeholder="Correo Electronico" value="<?php if(isset($userMail)){echo $userMail;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="pass_Usuario" placeholder="Contraseña" value="<?php if(isset($userPass)){echo $userPass;} ?>"  <?php if(isset($code) && $code == 3){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <h3>Tipo de usuario</h3>
            <td> <select class="" name="tipoUsuario">
                <option value="1">Administrador</option>
                <option value="2">Empleado</option>
                <option value="3">Supervisor</option>
                </select> </td>
          </tr>
          <div id="horizontal">
            <td><button type="submit" class="boton" name="btn-searchUser">Seleccionar Usuario</button></td>
            <td><button type="submit" class="boton" name="btn-regUser">Registrar Usuario</button></td>
            <td><button type="submit" class="boton" name="btn-editUser">Editar Usuario</button></td>
            <td><button type="submit" class="boton" name="btn-deleteUser">Eliminar Usuario</button></td>
          </div>
        </form>


      </div>

    </div>

  </body>
</html>
