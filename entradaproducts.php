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

    $lastID=$funcionSQL->ultimoID('idEntrada','listado_entrada','idEntrada');

    $data=[
      'numeroEntrada'=>$lastID,
    ];

    $query = "SELECT e.idEntrada, e.fechaEntrada, c.id_Cliente,c.nombre_Cliente, p.id_Producto,p.nombre_Producto, e.cantidadEntrada,e.costoProducto, e.estadoRegistroE FROM cat_clientes AS c INNER JOIN listado_entrada AS e ON c.id_Cliente = e.idProveedorEntrada INNER JOIN cat_producto AS p ON e.idProductoEntrada=p.id_Producto WHERE e.idEntrada = :numeroEntrada AND e.estadoRegistroE!=3";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    while ($datos= $statement->fetch()){
      $numeroEntrada=$datos[0];
      $fechaEntrada=$datos[1];
      $id_Cliente=$datos[2];
      $nombreCliente=$datos[3];
      $idProducto=$datos[4];
      $nombreProducto=$datos[5];
      $cantidadEntrada=$datos[6];
      $costoProducto=$datos[7];
      $estadoRegistroE=$datos[8];
    }

    if (isset($_POST['btn-nuevaEntrada'])) {
      $fechaEntrada= trim(date('Y-m-d'));
      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "INSERT INTO listado_entrada (fechaEntrada, idProveedorEntrada, idProductoEntrada, cantidadEntrada, estadoRegistroE,costoProducto) VALUES ('$fechaEntrada',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);";
      $statement = $connect->prepare($query);
      $statement->execute();

      echo "<script>";
      echo 'window.location.href = "entradaproducts.php"';
      echo "</script>";
    }



    if (isset($_POST['btn-searchEntrada'])) {
      $numeroEntrada=(trim($_POST['numero_Entrada']));

        if(empty($numeroEntrada))
        {
          $code = 1;
          $error = "Por favor ingresa un Folio";
        }
        else if(!is_numeric($numeroEntrada))
        {
         $error = "Solo se admiten numeros";
          $code = 1;
        }
        else if($numeroEntrada>9999)
        {
          $error = "El Folio no puede ser mayor a 4 Digitos";
          $code = 1;
        }
        else if($numeroEntrada<1)
        {
          $error = "El ID no puede ser menor a 1";
          $code = 1;
        }else {

          $data=[
            'numeroEntrada'=>$numeroEntrada,
          ];

          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT estadoRegistroE FROM listado_entrada WHERE idEntrada = :numeroEntrada";
          $statement = $connect->prepare($query);
          $statement->execute($data);
          $count=$statement->rowCount();

          while( $datos = $statement->fetch()){
          $estadoRegistroE = $datos[0];
          }

          if ($count>0 && $estadoRegistroE!=3 ) {
            $query = "SELECT e.idEntrada, e.fechaEntrada, c.id_Cliente,c.nombre_Cliente, p.id_Producto,p.nombre_Producto, e.cantidadEntrada,e.costoProducto, e.estadoRegistroE FROM cat_clientes AS c INNER JOIN listado_entrada AS e ON c.id_Cliente = e.idProveedorEntrada INNER JOIN cat_producto AS p ON e.idProductoEntrada=p.id_Producto WHERE e.idEntrada = :numeroEntrada AND e.estadoRegistroE!=3";
            $statement = $connect->prepare($query);
            $statement->execute($data);
            while ($datos= $statement->fetch()){
              $numeroEntrada=$datos[0];
              $fechaEntrada=$datos[1];
              $id_Cliente=$datos[2];
              $nombreCliente=$datos[3];
              $idProducto=$datos[4];
              $nombreProducto=$datos[5];
              $cantidadEntrada=$datos[6];
              $costoProducto=$datos[7];
              $estadoRegistroE=$datos[8];
            }
          }else {
            echo "<script>";
            echo "alert('El folio del servicio no existe');";
            echo 'window.location.href = "entradaproducts.php"';
            echo "</script>";
          }
        }
      }

    if (isset($_POST["btn-guardarEntrada"])) {
      $numeroEntrada= trim($_POST['numero_Entrada']);
      $fechaEntrada =trim($_POST['fecha_Entrada']);
      $id_Cliente = trim($_POST['select_cliente']);
      $idProducto=trim($_POST['select_product']);
      $cantidadEntrada=trim($_POST['cantidad_Entrada']);
      $costoProducto = trim($_POST['costo_Producto']);
      $estadoRegistroE= trim($_POST['check_Ingresado']);

      if(empty($numeroEntrada))
      {
        $code = 1;
        $error = "Por favor ingresa un Folio";
      }
      else if(!is_numeric($numeroEntrada))
      {
       $error = "Solo se admiten numeros";
        $code = 1;
      }
      else if($numeroEntrada>9999)
      {
        $error = "El Folio no puede ser mayor a 4 Digitos";
        $code = 1;
      }
      else if($numeroEntrada<1)
      {
        $error = "El ID no puede ser menor a 1";
        $code = 1;
      }
      else if(empty($fechaEntrada))
      {
        $error= "Ingresa una fecha";
        $code= 2;
      }
      else if(empty($id_Cliente))
      {
        $error= "Selecciona un cliente";
        $code= 3;
      }
      else if(empty($idProducto))
      {
        $error= "Por favor selecciona un producto";
        $code= 4;
      }
      else if(empty($cantidadEntrada))
      {
        $error= "Ingresa la cantidad de la entrada";
        $code= 5;
      }
      else if(!is_numeric($cantidadEntrada))
      {
        $error= "Solo se admiten numeros en la cantidad de la entrada";
        $code= 5;
      }
      else if($cantidadEntrada<0)
      {
        $error= "La cantidad de la entrada no puede ser menor a 0";
        $code= 5;
      }
      else if(empty($costoProducto))
      {
        $error= "Ingresa el costo del producto";
        $code= 6;
      }
      else if(!is_numeric($costoProducto))
      {
        $error= "Solo se adminten numeros en el costo del producto";
        $code= 6;
      }
      else if($costoProducto<0)
      {
        $error= "El costo no puede ser menor a 0.00";
        $code= 6;
      }
      else {
      $data=[
        'numeroEntrada'=>$numeroEntrada,
        ];

      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT * FROM listado_entrada WHERE idEntrada = :numeroEntrada";
      $statement = $connect->prepare($query);
      $statement->execute($data);
      $count=$statement->rowCount();
      if ($count>0) {

        //Revisar estado actual del cliente
        $data = [
      'id_Cliente' => $id_Cliente,
        ];
        $query="SELECT estadoRegistroC FROM cat_clientes WHERE id_Cliente =:id_Cliente";
        $statement = $connect->prepare($query);
        $statement->execute($data);
        while($datos = $statement->fetch()){
        $estadoRegistro = $datos[0];
      }

      //Revisar estado actual del Producto
      $data = [
    'idProducto' => $idProducto,
      ];
      $query="SELECT estadoRegistroP FROM cat_producto WHERE id_Producto =:idProducto";
      $statement = $connect->prepare($query);
      $statement->execute($data);
      while($datos = $statement->fetch()){
      $estadoRegistroP = $datos[0];
    }

      //Si el estado del producto no es "Eliminado" , actualiza el valor a 2 "Asociado"
      if ($estadoRegistroP !=3) {
        $data = [
          'idProducto' => $idProducto,
        ];
        $query="UPDATE cat_producto SET estadoRegistroP =2 WHERE id_Producto =:idProducto";
        $statement = $connect->prepare($query);
        $statement->execute($data);
      }
      //Si el estado del cliente no es "Eliminado" , actualiza el valor a 2 "Asociado"
      if ($estadoRegistro!=3) {
        $data = [
          'id_Cliente' => $id_Cliente,
        ];
        $query = "UPDATE cat_clientes SET estadoRegistroC =2 WHERE id_Cliente =:id_Cliente";
        $statement = $connect->prepare($query);
        $statement->execute($data);
      }

        //Se asigna un valor a la variable
        if (isset($_POST['check_Ingresado'])) {
          $estadoRegistroE=2;
          $data=[
            'numeroEntrada'=>$numeroEntrada,
            'fechaEntrada'=>$fechaEntrada,
            'estadoRegistroE'=>$estadoRegistroE,
            'id_Cliente'=>$id_Cliente,
            'idProducto'=>$idProducto,
            'cantidadEntrada'=>$cantidadEntrada,
            'costoProducto'=>$costoProducto,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "UPDATE listado_entrada SET fechaEntrada=:fechaEntrada, estadoRegistroE=:estadoRegistroE, idProveedorEntrada=:id_Cliente,idProductoEntrada=:idProducto
          ,cantidadEntrada=:cantidadEntrada,costoProducto=:costoProducto WHERE idEntrada =:numeroEntrada";
          $statement = $connect->prepare($query);
          $statement->execute($data);

          //actualizacion de existencias

          $existenciaP = $funcionSQL ->existenciaProducto($idProducto);
          $existenciaActualP = $existenciaP + $cantidadEntrada;

          $dataSumaExistencia =[
            'existenciaActualP'=>$existenciaActualP,
            'idProducto'=>$idProducto
          ,];

          $queryUpdateSuma = "UPDATE cat_producto
                   SET existencia_Producto = :existenciaActualP
                   WHERE id_Producto = :idProducto";
          $statement2 = $connect->prepare($queryUpdateSuma);
          $statement2->execute($dataSumaExistencia);

        }else {

          $estadoRegistroE=1;
          $data=[
            'numeroEntrada'=>$numeroEntrada,
            'fechaEntrada'=>$fechaEntrada,
            'estadoRegistroE'=>$estadoRegistroE,
            'id_Cliente'=>$id_Cliente,
            'idProducto'=>$idProducto,
            'cantidadEntrada'=>$cantidadEntrada,
            'costoProducto'=>$costoProducto,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "UPDATE listado_entrada SET fechaEntrada=:fechaEntrada, estadoRegistroE=:estadoRegistroE, idProveedorEntrada=:id_Cliente,idProductoEntrada=:idProducto
          ,cantidadEntrada=:cantidadEntrada,costoProducto=:costoProducto WHERE idEntrada =:numeroEntrada";
          $statement = $connect->prepare($query);
          $statement->execute($data);
        }

        echo "<script>";
        echo "alert('Entrada Actualizada ');";
        echo 'window.location.href = "entradaproducts.php"';
        echo "</script>";
      }
      else {
        echo "<script>";
        echo "alert('El servicio no existe y no puede actualizarse, pulsa el boton Nuevo, para crear un registro ');";
        echo 'window.location.href = "entradaproducts.php"';
        echo "</script>";
      }
    }
    }

    if (isset($_POST['btn-deleteEntrada'])) {
      $numeroEntrada=(trim($_POST['numero_Entrada']));
      $data=[
        'numeroEntrada'=>$numeroEntrada,
      ];
      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT idEntrada,estadoRegistroE FROM listado_entrada WHERE idEntrada = :numeroEntrada";
      $statement = $connect->prepare($query);
      $statement->execute($data);
      $count=$statement->rowCount();

      if ($count>0) {
        while ($datos= $statement->fetch()){
          $numeroEntrada=$datos[0];
          $estadoRegistroE=$datos[1];
        }
        $data=[
          'numeroEntrada'=>$numeroEntrada,
        ];

        $query = "UPDATE listado_entrada SET estadoRegistroE=3  WHERE idEntrada = :numeroEntrada";
        $statement = $connect->prepare($query);
        $statement->execute($data);
        $count=$statement->rowCount();

        //Se crea nuevo registro si el registro "Eliminado" era el ultimo
        $lastID=$funcionSQL->ultimoID('idEntrada','listado_entrada','idEntrada');
        if ($lastID==$numeroEntrada) {
          $fechaEntrada= trim(date('Y-m-d'));
          $query = "INSERT INTO listado_entrada (nombre_Servicio, tipo_Servicio,descripcion_Servicio, costo_Producto, cliente_Servicio, fecha_Realizacion, estadoRegistroE) VALUES (DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,'$fechaEntrada',DEFAULT);";
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
    <title>Registrar Entrada</title>
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
        <h1>Registrar Entrada</h1>
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
            <input id="" class="inputShort" type="text" name="numero_Entrada" placeholder="Folio" value="<?php if(isset($numeroEntrada)){echo $numeroEntrada;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />
            <button type="submit" class="boton" name="btn-searchEntrada">Buscar Entrada</button>
            <button type="submit" class="boton"name="btn-nuevaEntrada">Nuevo</button>
            <button type="submit" class="boton"name="btn-deleteEntrada" <?php if ($estadoRegistroE==2) {echo "disabled";} ?>>Borrar</button>
          </div>

          <div id="venta" class="elementForm">
            <h3 id="labelFecha">Fecha</h3>
            <input id="inputFechaVenta"type="date" name="fecha_Entrada" value="<?php if(isset($fechaEntrada)){echo $fechaEntrada;}?>"/>
            <!-- <input class="inputShort" id="" type="text" name="fecha_Entrada" placeholder="Fecha" value="<?php if(isset($fechaEntrada)){echo $fechaEntrada;} ?>" /> -->
            <h3>Realizado</h3>
            <input class="inputShort"type="checkbox" name="check_Ingresado" id="cboxEntregado"<?php if ($estadoRegistroE==2) {echo "checked";} ?>/>
          </div>
          <div id="venta" class="elementForm">
             <h3>Cliente</h3> <!---->
            <select class="inputShort" name="select_cliente">
              <option value="<?php if(isset($id_Cliente)){echo $id_Cliente;}  ?>"><?php if(isset($nombreCliente)){echo $nombreCliente;}  ?></option>
              <?php
                  $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $query = "SELECT id_Cliente, nombre_Cliente FROM cat_clientes where tipo_Entidad=2 AND oculto=0 AND estadoRegistroC!=3";
                  $statement = $connect->prepare($query);
                  $statement->execute();

                  while($registro = $statement->fetch())
              {
                echo"
                <option value=".$registro["id_Cliente"].">".$registro["nombre_Cliente"]."</option>";
              }
               ?>
              </select>

          </div>
          <div id="horizontal" class="elementForm">
            <h3>Producto</h3>
            <select class="inputShort" name="select_product">
              <option value="<?php if(isset($idProducto)){echo $idProducto;}  ?>"><?php if(isset($nombreProducto)){echo $nombreProducto;}  ?></option>
              <?php
                  $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $query = "SELECT id_Producto, nombre_Producto FROM cat_producto WHERE estadoRegistroP!=3 AND pOculto=0";
                  $statement = $connect->prepare($query);
                  $statement->execute();

                  while($registro = $statement->fetch())
              {
                echo"
                <option value=".$registro["id_Producto"].">".$registro["nombre_Producto"]."</option>";
              }
               ?>
              </select>
          </div>
          <p class="elementForm">
            <h3>Cantidad</h3><input class="inputShort" type="text" name="cantidad_Entrada" placeholder="Precio" value="<?php if(isset($cantidadEntrada)){echo $cantidadEntrada;} ?>"  <?php if(isset($code) && $code == 6){ echo "autofocus"; }  ?> /></td>
            <h3>Precio</h3><input class="inputShort" type="text" name="costo_Producto" placeholder="Precio" value="<?php if(isset($costoProducto)){echo $costoProducto;} ?>"  <?php if(isset($code) && $code == 6){ echo "autofocus"; }  ?> /></td>
          </p>
          <div class="elementForm">
            <button class="boton" type="submit" name="btn-guardarEntrada" <?php if ($estadoRegistroE==2) {echo "disabled";} ?>>Guardar </button>
          </div>
        </form>
      </div>



  </body>
</html>
