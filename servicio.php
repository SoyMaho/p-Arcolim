<?php
session_start();
include("conexion.php");
include("sesion.php");
include("funcsql.php");
$sesion = new sesion ();
$funcionSQL=new funcionSQL();
try {
  if (!isset($_SESSION['user'])) {
    header('Location: index.php');
  }else {
    $currentUser = $sesion->getCurrentUser();
    echo '<h2> Bienvenido </h2>' .$currentUser;
    $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $lastID=$funcionSQL->ultimoID('id_Servicio','listado_servicio','id_Servicio');

    $data=[
      'numeroServicio'=>$lastID,
    ];

    $query = "SELECT s.id_Servicio, s.nombre_Servicio, s.tipo_Servicio, s.descripcion_Servicio, s.precio_Servicio,c.id_Cliente,c.nombre_Cliente,s.fecha_Realizacion, s.estado_Servicio FROM cat_clientes AS c INNER JOIN listado_servicio AS s ON c.id_Cliente = s.cliente_Servicio WHERE s.id_Servicio = :numeroServicio AND s.estado_Servicio!=3";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    while ($datos= $statement->fetch()){
      $numeroServicio=$datos[0];
      $nombreServicio=$datos[1];
      $tipoServicio=$datos[2];
      $descServicio=$datos[3];
      $precioServicio=$datos[4];
      $id_Cliente=$datos[5];
      $nombreCliente=$datos[6];
      $fechaServicio=$datos[7];
      $estadoRegistroS=$datos[8];
    };

    if (isset($_POST['btn-nuevoServicio'])) {
      $fechaServicio= trim(date('Y-m-d'));
      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "INSERT INTO listado_servicio (nombre_Servicio, tipo_Servicio,descripcion_Servicio, precio_Servicio, cliente_Servicio, fecha_Realizacion, estado_Servicio) VALUES (DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,'$fechaServicio',DEFAULT);";
      $statement = $connect->prepare($query);
      $statement->execute();

      echo "<script>";
      echo 'window.location.href = "servicio.php"';
      echo "</script>";





    }

    // if(isset($_POST["btn-searchCliente"])){
    //
    //       $id_Cliente = trim($_POST['select_cliente']);
    //       $nombreCliente = trim($_POST['nombre_Cliente']);
    //       $numeroServicio= trim($_POST['numero_Servicio']);
    //       $precioServicio = trim($_POST['precio_Servicio']);
    //       $estadoRegistroS = trim($_POST['check_Realizado']);
    //       $fechaServicio =trim($_POST['fecha_Servicio']);
    //       $tipoServicio = trim($_POST['select_TipoServicio']);
    //       $nombreServicio = trim($_POST['name_Servicio']);
    //       $descServicio = trim($_POST['descripcion_Servicio']);
    //
    //
    //       if(empty($id_Cliente))
    //       {
    //        $error = "Por favor selecciona un cliente";
    //        $code = 1;
    //       }
    //       else {
    //         $data = [
    //         'id_Cliente' => $id_Cliente
    //         ,];
    //
    //             $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
    //             $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //             $query = "SELECT * FROM cat_clientes WHERE id_Cliente = :id_Cliente";
    //             $statement = $connect->prepare($query);
    //             $statement->execute($data);
    //
    //             $count = $statement->rowCount();
    //             if($count == 0)
    //             {
    //               echo '<script language="javascript">';
    //               echo 'alert("El cliente no existe")';
    //               echo '</script>';
    //             }
    //             else {
    //               while( $datos = $statement->fetch()){
    //               $nombreCliente = $datos[1];
    //
    //
    //               }
    //             }
    //          }
    //
    //
    // }

    if (isset($_POST['btn-searchServicio'])) {
      $numeroServicio=(trim($_POST['numero_Servicio']));

    if(empty($numeroServicio))
    {
      $code = 1;
      $error = "Por favor ingresa un ID";
    }
    else if(!is_numeric($numeroServicio))
    {
     $error = "Solo se admiten numeros";
      $code = 1;
    }
    else if($numeroServicio>9999)
    {
      $error = "El ID no puede ser mayor a 4 Digitos";
      $code = 1;
    }
    else if($numeroServicio<1)
    {
      $error = "El ID no puede ser menor a 1";
      $code = 1;
    }else {

      $data=[
        'numeroServicio'=>$numeroServicio,
      ];

      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT estado_Servicio FROM listado_servicio WHERE id_Servicio = :numeroServicio";
      $statement = $connect->prepare($query);
      $statement->execute($data);
      $count=$statement->rowCount();

      while( $datos = $statement->fetch()){
      $estadoRegistroS = $datos[0];
      }

      if ($count>0 && $estadoRegistroS!=3 ) {
        $query = "SELECT s.id_Servicio, s.nombre_Servicio, s.tipo_Servicio, s.descripcion_Servicio, s.precio_Servicio,c.id_Cliente,c.nombre_Cliente,s.fecha_Realizacion, s.estado_Servicio FROM cat_clientes AS c INNER JOIN listado_servicio AS s ON c.id_Cliente = s.cliente_Servicio WHERE s.id_Servicio = :numeroServicio";
        $statement = $connect->prepare($query);
        $statement->execute($data);
        while ($datos= $statement->fetch()){
          $numeroServicio=$datos[0];
          $nombreServicio=$datos[1];
          $tipoServicio=$datos[2];
          $descServicio=$datos[3];
          $precioServicio=$datos[4];
          $id_Cliente=$datos[5];
          $nombreCliente=$datos[6];
          $fechaServicio=$datos[7];
          $estadoRegistroS=$datos[8];
        };
      }else {
        echo "<script>";
        echo "alert('El folio del servicio no existe');";
        echo 'window.location.href = "servicio.php"';
        echo "</script>";
      }
    }
  }

    if (isset($_POST["btn-guardarServicio"])) {
      $numeroServicio= trim($_POST['numero_Servicio']);
      $fechaServicio =trim($_POST['fecha_Servicio']);
      $id_Cliente = trim($_POST['select_cliente']);
      $nombreCliente = trim($_POST['nombre_Cliente']);
      $tipoServicio = trim($_POST['select_TipoServicio']);
      $nombreServicio = trim($_POST['name_Servicio']);
      $precioServicio = trim($_POST['precio_Servicio']);
      $descServicio = trim($_POST['descripcion_Servicio']);
      $precioServicio=trim($_POST['precio_Servicio']);
      $estadoRegistroS= trim($_POST['check_Realizado']);

      if(empty($numeroServicio))
      {
        $code = 1;
        $error = "Por favor ingresa un Folio";
      }
      else if(!is_numeric($numeroServicio))
      {
       $error = "Solo se admiten numeros";
        $code = 1;
      }
      else if($numeroServicio>9999)
      {
        $error = "El Folio no puede ser mayor a 4 Digitos";
        $code = 1;
      }
      else if($numeroServicio<1)
      {
        $error = "El ID no puede ser menor a 1";
        $code = 1;
      }
      else if(empty($fechaServicio))
      {
        $error= "Ingresa una fecha";
        $code= 2;
      }
      else if(empty($id_Cliente))
      {
        $error= "Selecciona un cliente";
        $code= 3;
      }
      else if(empty($nombreServicio))
      {
        $error= "Ingresa una referencia para el servicio";
        $code= 4;
      }
      else if(empty($descServicio))
      {
        $error= "Ingresa la descripcion del servicio";
        $code= 5;
      }
      else if(empty($precioServicio))
      {
        $error= "Ingresa el precio del servicio";
        $code= 6;
      }
      else if(!is_numeric($precioServicio))
      {
        $error= "Solo se adminten numeros en el precio del servicio";
        $code= 6;
      }
      else if($precioServicio<0)
      {
        $error= "El precio no puede ser menor a 0.00";
        $code= 6;
      }
      else {
      $data=[
        'numeroServicio'=>$numeroServicio,
        ];

      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT * FROM listado_servicio WHERE id_Servicio = :numeroServicio";
      $statement = $connect->prepare($query);
      $statement->execute($data);
      $count=$statement->rowCount();
      if ($count>0) {
        //Se asigna un valor a la variable
        if (isset($_POST['check_Realizado'])) {
          $estadoRegistroS=2;
          $data=[
            'numeroServicio'=>$numeroServicio,
            'fechaServicio'=>$fechaServicio,
            'estadoRegistroS'=>$estadoRegistroS,
            'id_Cliente'=>$id_Cliente,
            'tipoServicio'=>$tipoServicio,
            'nombreServicio'=>$nombreServicio,
            'descServicio'=>$descServicio,
            'precioServicio'=>$precioServicio,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "UPDATE listado_servicio SET nombre_Servicio=:nombreServicio, tipo_Servicio=:tipoServicio, descripcion_Servicio=:descServicio,
          precio_Servicio=:precioServicio, cliente_Servicio=:id_Cliente, fecha_Realizacion =:fechaServicio, estado_Servicio=:estadoRegistroS WHERE id_Servicio =:numeroServicio";
          $statement = $connect->prepare($query);
          $statement->execute($data);

        }else {

          $estadoRegistroS=1;
          $data=[
            'numeroServicio'=>$numeroServicio,
            'fechaServicio'=>$fechaServicio,
            'estadoRegistroS'=>$estadoRegistroS,
            'id_Cliente'=>$id_Cliente,
            'tipoServicio'=>$tipoServicio,
            'nombreServicio'=>$nombreServicio,
            'descServicio'=>$descServicio,
            'precioServicio'=>$precioServicio,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "UPDATE listado_servicio SET nombre_Servicio=:nombreServicio, tipo_Servicio=:tipoServicio, descripcion_Servicio=:descServicio,
          precio_Servicio=:precioServicio, cliente_Servicio=:id_Cliente, fecha_Realizacion =:fechaServicio, estado_Servicio=:estadoRegistroS WHERE id_Servicio =:numeroServicio";
          $statement = $connect->prepare($query);
          $statement->execute($data);
        }

        echo "<script>";
        echo "alert('Servicio Actualizado ');";
        echo 'window.location.href = "servicio.php"';
        echo "</script>";
      }
      else {
        echo "<script>";
        echo "alert('El servicio no existe y no puede actualizarse, pulsa el boton Nuevo, para crear un registro ');";
        echo 'window.location.href = "servicio.php"';
        echo "</script>";
      }
    }
    }

    if (isset($_POST['btn-deleteServicio'])) {
      $numeroServicio=(trim($_POST['numero_Servicio']));
      $data=[
        'numeroServicio'=>$numeroServicio,
      ];
      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT id_Servicio,estado_Servicio FROM listado_servicio WHERE id_Servicio = :numeroServicio";
      $statement = $connect->prepare($query);
      $statement->execute($data);
      $count=$statement->rowCount();

      if ($count>0) {
        while ($datos= $statement->fetch()){
          $numeroServicio=$datos[0];
          $estadoRegistroS=$datos[1];
        };
        $data=[
          'numeroServicio'=>$numeroServicio,
        ];

        $query = "UPDATE listado_servicio SET estado_Servicio=3  WHERE id_Servicio = :numeroServicio";
        $statement = $connect->prepare($query);
        $statement->execute($data);
        $count=$statement->rowCount();

        //Se crea nuevo registro si el registro "Eliminado" era el ultimo
        $lastID=$funcionSQL->ultimoID('id_Servicio','listado_servicio','id_Servicio');
        if ($lastID==$numeroServicio) {
          $fechaServicio= trim(date('Y-m-d'));
          $query = "INSERT INTO listado_servicio (nombre_Servicio, tipo_Servicio,descripcion_Servicio, precio_Servicio, cliente_Servicio, fecha_Realizacion, estado_Servicio) VALUES (DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,'$fechaServicio',DEFAULT);";
          $statement = $connect->prepare($query);
          $statement->execute();
          echo "<script>";
          echo "alert('Servicio Eliminado ');";
          echo 'window.location.href = "servicio.php"';
          echo "</script>";
        }else {
          echo "<script>";
          echo "alert('Servicio Eliminado ');";
          echo 'window.location.href = "servicio.php"';
          echo "</script>";
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
    <title>Registrar Servicios</title>
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
        <h1>Registrar servicio al cliente</h1>
      </div>
      <div class="">
        <form id="regServicio" class="" action="" method="post">
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
          <div id="venta" class="elementForm">
            <h3>Folio</h3>
            <input id="" class="inputShort" type="text" name="numero_Servicio" placeholder="Folio" value="<?php if(isset($numeroServicio)){echo $numeroServicio;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />
            <button type="submit" class="boton" name="btn-searchServicio">Buscar Servicio</button>
            <button type="submit" class="boton"name="btn-nuevoServicio">Nuevo</button>
            <button type="submit" class="boton"name="btn-deleteServicio" <?php if ($estadoRegistroS==2) {echo "disabled";} ?>>Borrar</button>
          </div>

          <div id="venta" class="elementForm">
            <h3 id="labelFecha">Fecha de Realizacion</h3> <input class="inputShort" id="" type="text" name="fecha_Servicio" placeholder="Fecha" value="<?php if(isset($fechaServicio)){echo $fechaServicio;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> />
            <h3>Realizado</h3>
            <input class="inputShort"type="checkbox" name="check_Realizado" id="cboxEntregado"<?php if ($estadoRegistroS==2) {echo "checked";} ?>/>
          </div>
          <div id="venta" class="elementForm">
             <h3>Cliente</h3> <!---->
            <select class="inputShort" name="select_cliente">
              <option value="<?php if(isset($id_Cliente)){echo $id_Cliente;}  ?>"><?php if(isset($nombreCliente)){echo $nombreCliente;}  ?></option>
              <?php
                  $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $query = "SELECT id_Cliente, nombre_Cliente FROM cat_clientes where tipo_Entidad=1 AND oculto=0 AND estadoRegistroC!=3";
                  $statement = $connect->prepare($query);
                  $statement->execute();

                  while($registro = $statement->fetch())
              {
                echo"
                <option value=".$registro["id_Cliente"].">".$registro["nombre_Cliente"]."</option>";
              }
               ?>
              </select>
              <!-- <button type="submit" name="btn-searchCliente">Buscar Cliente</button> -->
          </div>
          <div id="horizontal" class="elementForm">
            <h3>Tipo de Servicio</h3>
            <select class="inputLong" name="select_TipoServicio">
              <option value="Limpieza General">Limpieza General</option>
              <option value="Limpieza Automovil">Limpieza Automovil</option>
              <option value="Pulido de Pisos">Pulido de Pisos</option>
              <option value="Limpieza de Alfombras">Limpieza de Alfombras</option>
              </select>
            <h3>Referencia</h3><input class="inputLong" type="text" name="name_Servicio" placeholder="Referencia del Servicio" value="<?php if(isset($nombreServicio)){echo $nombreServicio;} ?>"  <?php if(isset($code) && $code == 4){ echo "autofocus"; }  ?> /></td>
          </div>
          <div class="descripcion" class="elementForm">
            <h3>Descripcion</h3>
            <textarea name="descripcion_Servicio" rows="8" cols="80" <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> > <?php if(isset($descServicio)){echo $descServicio;}?> </textarea>
          </div>
          <p class="elementForm">
            <h3>Precio</h3><input class="inputShort" type="text" name="precio_Servicio" placeholder="Precio" value="<?php if(isset($precioServicio)){echo $precioServicio;} ?>"  <?php if(isset($code) && $code == 6){ echo "autofocus"; }  ?> /></td>
          </p>
          <div class="elementForm">
            <button class="boton" type="submit" name="btn-guardarServicio" <?php if ($estadoRegistroS==2) {echo "disabled";} ?>>Guardar </button>
          </div>
        </form>
      </div>



  </body>
</html>
