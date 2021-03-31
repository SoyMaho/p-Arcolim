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

      //Se instancia la clase y se utiliza el metodo ultimo ID
      $idAutoCliente = $funcsql ->ultimoId("id_Cliente","cat_clientes","id_Cliente");
      $id_Cliente = $idAutoCliente+1;
    if(isset($_POST["btn-regCliente"])){
          //Se elimina por que el ID es autogenerado
          // $id_Cliente = trim($_POST['id_Cliente']);
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
          $idEstadoCliente = trim($_POST['estado_Cliente']);

          if(empty($id_Cliente))
          {
           $error = "Por favor ingresa un ID";
           $code = 1;
          }
          else if(!is_numeric($id_Cliente))
          {
           $error = "Solo se admiten numeros";
           $code = 1;
          }
          else if($id_Cliente>9999)
          {
           $error = "El ID del cliente no puede ser mayor a 4 Digitos";
           $code = 1;
          }
           else if($id_Cliente<1)
           {
            $error = "El ID no puede ser menor a 1";
            $code = 1;
           }
           else if(empty($name_Cliente))
           {
            $error = "Ingresa el nombre del cliente";
            $code = 2;
           }
           else if(!ctype_alpha($name_Cliente))
           {
            $error = "Solo se admiten letras";
            $code = 2;
           }
           else if(strlen($name_Cliente)>100)
           {
            $error = "El nombre del Cliente no puede exceder 100 caracteres";
            $code = 2;
           }
           else if(empty($apellido_Paterno))
           {
            $error = "Ingresa tu apellido Paterno";
            $code = 3;
           }
           else if(!ctype_alpha($apellido_Paterno))
           {
            $error = "Solo se admiten letras en este campo";
            $code = 3;
           }
           else if(strlen($apellido_Paterno)>100)
           {
            $error = "El Apellido del Cliente no puede exceder 100 caracteres";
            $code = 3;
           }
           else if(empty($razonSocial_Cliente))
           {
            $error = "Ingresa la razon social";
            $code = 4;
           }
           else if(strlen($razonSocial_Cliente)>250)
           {
            $error = "La razon social no puede exceder 250 caracteres";
            $code = 4;
           }
           else if(empty($rfc_Cliente))
            {
            $error = "Ingresa el RFC";
            $code = 5;
            }
            else if(strlen($rfc_Cliente)>13)
            {
             $error = "El RFC no puede exceder los 13 caracteres";
             $code = 5;
            }
            else if(strlen($rfc_Cliente)<12)
            {
             $error = "El RFC no puede ser menor a 12 caracteres";
             $code = 5;
            }
           else if(empty($email_Cliente))
           {
            $error = "Ingresa tu Correo electronico";
            $code = 6;
           }
           else if(!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $email_Cliente))
           {
            $error = "La direccion de correo no es valida";
            $code = 6;
           }
           else if(empty($tel_Cliente))
           {
            $error = "Ingresa tu numero telefonico";
            $code = 7;
           }
           else if(!is_numeric($tel_Cliente))
           {
            $error = "Solo se admiten numeros";
            $code = 7;
           }
           else if(strlen($tel_Cliente)!=10)
           {
            $error = "El numero telefonico debe contener 10 digitos";
            $code = 7;
           }
           else if(empty($calle_Cliente))
           {
            $error = "Ingresa la calle";
            $code = 8;
           }
           else if(strlen($calle_Cliente)>50)
           {
            $error = "La calle no puede exceder los 50 caracteres";
            $code = 8;
           }
           else if(empty($numeroExt_Cliente))
            {
            $error = "Ingresa el numero Exterior";
            $code = 9;
            }
            else if(strlen($numeroExt_Cliente)>5)
            {
             $error = "El numero exterior no puede ser mayor a 5 digitos";
             $code = 9;
            }
             else if(strlen($numeroInt_Cliente)>5)
             {
              $error = "El numero interior no puede ser mayor a 5 digitos";
              $code = 10;
             }
            else if(empty($colonia_Cliente))
             {
             $error = "Ingresa la colonia";
             $code = 11;
             }
             else if(strlen($colonia_Cliente)>50)
             {
              $error = "La colonia no puede exceder los 50 Caracteres";
              $code = 11;
             }
             else if(empty($ciudad_Cliente))
              {
              $error = "Ingresa la ciudad";
              $code = 12;
              }
              else if(strlen($ciudad_Cliente)>50)
              {
               $error = "La ciudad no puede exceder los 50 Caracteres";
               $code = 12;
              }
              else if(empty($idEstadoCliente))
               {
               $error = "Selecciona un estado";
               $code = 13;
               }
           else {
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
                 'estado_Cliente'=>$idEstadoCliente,
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
                 'tipo_Entidad' => '1',
                 'estadoRegistroC'=>'1',
                 ];



                 $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                 $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $query = "INSERT INTO cat_direccionclientes(id_Direccion, calle_Cliente, numeroEx_Cliente, numeroInt_Cliente, colonia_Cliente, ciudad_Cliente, estado_Cliente) VALUES (:id_Direccion, :calle_Cliente, :numeroExt_Cliente, :numeroInt_Cliente, :colonia_Cliente, :ciudad_Cliente, :estado_Cliente)";
                 $statement = $connect->prepare($query);
                 $statement->execute($data);

                 $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                 $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $query = "INSERT INTO cat_clientes (id_Cliente, nombre_Cliente, pApellido_Cliente, razonSocial_Cliente, rfc_Cliente, direccion_Cliente, correo_Cliente, tel_Cliente, tipo_Entidad,estadoRegistroC) VALUES (:id_Cliente, :name_Cliente, :apellido_Paterno, :razonSocial_Cliente, :rfc_Cliente, :direccion_Cliente, :email_Cliente,:tel_Cliente,:tipo_Entidad,:estadoRegistroC)";
                 $statement = $connect->prepare($query);
                 $statement->execute($data1);

                 echo '<script language="javascript">';
                 echo 'alert("Cliente Registrado Exitosamente")';
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
        <h1>Registrar Cliente</h1>
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
            <h3>Datos del cliente</h3>
          <td><h4>Nombre</h4><input type="text" name="name_Cliente" placeholder="Nombre del cliente" value="<?php if(isset($name_Cliente)){echo $name_Cliente;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>Apellido Paterno</h4><input type="text" name="apellido_Paterno" placeholder="Apellido Paterno" value="<?php if(isset($apellido_Paterno)){echo $apellido_Paterno;} ?>"  <?php if(isset($code) && $code == 3){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>Razon Social</h4><input type="text" name="razonSocial_Cliente" placeholder="Razon Social" value="<?php if(isset($razonSocial_Cliente)){echo $razonSocial_Cliente;} ?>"  <?php if(isset($code) && $code == 4){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>RFC</h4><input type="text" name="rfc_Cliente" placeholder="RFC" value="<?php if(isset($rfc_Cliente)){echo $rfc_Cliente;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>Correo Electronico</h4><input type="text" name="email_Cliente" placeholder="Correo Electronico" value="<?php if(isset($email_Cliente)){echo $email_Cliente;} ?>"  <?php if(isset($code) && $code == 6){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>Numero Telefonico</h4><input type="text" name="tel_Cliente" placeholder="Numero Telefonico" value="<?php if(isset($tel_Cliente)){echo $tel_Cliente;} ?>"  <?php if(isset($code) && $code == 7){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <h3>Direccion</h3>
          <td><h4>Calle</h4><input type="text" name="calle_Cliente" placeholder="Calle" value="<?php if(isset($calle_Cliente)){echo $calle_Cliente;} ?>"  <?php if(isset($code) && $code == 8){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>Numero Ex.</h4><input type="text" name="numeroExt_Cliente" placeholder="Numero Exterior" value="<?php if(isset($numeroExt_Cliente)){echo $numeroExt_Cliente;} ?>"  <?php if(isset($code) && $code == 9){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>Numero Int.</h4><input type="text" name="numeroInt_Cliente" placeholder="Numero Interior" value="<?php if(isset($numeroInt_Cliente)){echo $numeroInt_Cliente;} ?>"  <?php if(isset($code) && $code == 10){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>Colonia</h4><input type="text" name="colonia_Cliente" placeholder="Colonia" value="<?php if(isset($colonia_Cliente)){echo $colonia_Cliente;} ?>"  <?php if(isset($code) && $code == 11){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><h4>Ciudad</h4><input type="text" name="ciudad_Cliente" placeholder="Ciudad" value="<?php if(isset($ciudad_Cliente)){echo $ciudad_Cliente;} ?>"  <?php if(isset($code) && $code == 12){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <h4>Estado</h4>
            <select class="" name="estado_Cliente">
              <option value="<?php if(isset($idEstadoCliente)){echo $idEstadoCliente;}  ?>"><?php if(isset($estado_Cliente)){echo $estado_Cliente;}  ?></option>
              <option value="1">Aguascalientes</option>
              <option value="2">Baja California</option>
              <option value="3">Baja California Sur</option>
              <option value="4">Campeche</option>
              <option value="5">Coahuila</option>
              <option value="6">Colima</option>
              <option value="7">Chiapas</option>
              <option value="8">Chihuahua</option>
              <option value="9">CDMX</option>
              <option value="10">Durango</option>
              <option value="11">Guanajuato</option>
              <option value="12">Guerrero</option>
              <option value="13">Hidalgo</option>
              <option value="14">Jalisco</option>
              <option value="15">Estado de Mexico</option>
              <option value="16">Michoacan</option>
              <option value="17">Morelos</option>
              <option value="18">Nayarit</option>
              <option value="19">Nuevo Leon</option>
              <option value="20">Oaxaca</option>
              <option value="21">Puebla</option>
              <option value="22">Queretaro</option>
              <option value="23">Quintana Roo</option>
              <option value="24">San Luis Potosi</option>
              <option value="25">Sinaloa</option>
              <option value="26">Sonora</option>
              <option value="27">Tabasco</option>
              <option value="28">Tamaulipas</option>
              <option value="29">Tlaxcala</option>
              <option value="30">Veracruz</option>
              <option value="31">Yucatan</option>
              <option value="32">Zacatecas</option>
            </select>
          </tr>
          <tr>
            <td><button type="submit" name="btn-regCliente">Registrar Cliente</button></td>
          </tr>
        </form>


      </div>

    </div>
  </body>
</html>
