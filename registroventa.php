<?php
session_start();
include("conexion.php");
include("sesion.php");
include("funcsql.php");
$sesion = new sesion ();
$funcsql = new funcionSQL ();
try {
  if (!isset($_SESSION['user'])){
    header('Location: index.php');
  }
  else {
    $currentUser = $sesion->getCurrentUser();
    echo '<h2> Bienvenido </h2>' .$currentUser;
    $nMovimientoVenta=0;

    $funcionsql = new funcionSQL();
    //Ejemplo Funcion UltimoID echo $funcionsql ->ultimoId('idventa','listado_venta','numeroVenta');

    //Ultima Venta
    $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query1 = "SELECT MAX(idVenta) AS id FROM listado_venta";

    $statement = $connect->prepare($query1);
    $statement->execute();
    $count = $statement->rowCount();

    while( $datos = $statement->fetch()){
    $id = $datos[0];
    }
    $numeroVenta=$id;

        $data = [
      'numero_Venta' => $numeroVenta
      ,];

      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT id_ClienteVenta, subtotalVenta, ivaVenta, totalVenta, numeroVenta,fechaVenta, estadoRegistroV FROM listado_venta WHERE numeroVenta = :numero_Venta";
      $statement = $connect->prepare($query);
      $statement->execute($data);

      while( $datos = $statement->fetch()){
      $id_Cliente = $datos[0];
      $subtotalVenta = $datos[1];
      $ivaVenta = $datos[2];
      $totalVenta = $datos[3];
      $numeroVenta = $datos[4];
      $fechaVenta = $datos[5];
      $estadoRegistroV = $datos[6];
    }

    $query1 = "SELECT MAX(idVenta) AS id FROM listado_venta";

    $statement = $connect->prepare($query1);
    $statement->execute();
    $count = $statement->rowCount();

    while( $datos = $statement->fetch()){
    $id = $datos[0];
    }
    $numeroVenta=$id;

        $data = [
      'numero_Venta' => $numeroVenta
      ,];

    $query = "SELECT SUM(precioTotalProducto) as subtotal FROM listadomovimientos WHERE idDocumentoVenta = :numero_Venta";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    while( $subtotal = $statement->fetch()){
    $subtotalVenta = $subtotal[0];
     }
    $ivaVenta = $subtotalVenta * .16;
    $totalVenta = $subtotalVenta + $ivaVenta;

    //Ultimo Movimiento
    $query1 = "SELECT MAX(idMovimiento) AS id FROM listadomovimientos";

    $statement = $connect->prepare($query1);
    $statement->execute();
    $count = $statement->rowCount();

    while( $datos = $statement->fetch()){
    $id = $datos[0];
    }
    $numeroidMovimiento=$id;

        $data = [
      'numero_idmovimiento' => $numeroidMovimiento
      ,];

      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT claveProducto, nombreProducto, cantidadProducto, precioProducto, precioTotalProducto FROM listadomovimientos WHERE idMovimiento = :numero_idmovimiento";
      $statement = $connect->prepare($query);
      $statement->execute($data);

      while( $datos = $statement->fetch()){
      $id_p = $datos[0];
      $pname = $datos[1];
      $cantidadP = $datos[2];
      $precioP = $datos[3];
      $precioTotal = $datos[4];
    }

    //Cliente Venta
    $data = [
    'id_cliente' => $id_Cliente
    ,];
    $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT nombre_Cliente FROM cat_clientes WHERE id_Cliente = :id_cliente";
    $statement = $connect->prepare($query);
    $statement->execute($data);

    while( $datos = $statement->fetch()){
    $nombreCliente = $datos[0];
    }







    if(isset($_POST["botonBorrarMov"])){
      $idMovimiento = $_POST['id_Movimiento'];
      $id_p = trim($_POST['select_product']);
      $pname = trim($_POST['name_product']);
      $descP = trim($_POST['descripcion_Producto']);
      $costoP = trim($_POST['costo_Producto']);
      $precioP = trim($_POST['precio_Producto']);
      $unidadP = trim($_POST['unidad_Producto']);
      $existenciaP = trim($_POST['existencia_Producto']);
      $numeroVenta= trim($_POST['numero_Venta']);
      $cantidadP = trim($_POST['cantidad_Producto']);
      $id_Cliente = trim($_POST['select_cliente']);
      $nombreCliente = trim($_POST['nombre_Cliente']);
      $subtotalVenta = trim($_POST['subtotal_Venta']);
      $ivaVenta = trim($_POST['iva_Venta']);
      $totalVenta = trim($_POST['total_Venta']);
      $estadoRegistroV = trim($_POST['check_Entregado']);
      $fechaVenta = trim($_POST['fecha_Venta']);

      $data1 = [
      'id_Movimiento' => $idMovimiento
      ,];
        $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "DELETE FROM listadomovimientos WHERE idMovimiento = :id_Movimiento";
          $statement = $connect->prepare($query);
          $statement->execute($data1);


          header('Location: registroventa.php');
    }

    if(isset($_POST["btn-search"])){

          $id_p = trim($_POST['select_product']);
          $pname = trim($_POST['name_product']);
          $descP = trim($_POST['descripcion_Producto']);
          $costoP = trim($_POST['costo_Producto']);
          $precioP = trim($_POST['precio_Producto']);
          $unidadP = trim($_POST['unidad_Producto']);
          $existenciaP = trim($_POST['existencia_Producto']);
          $numeroVenta= trim($_POST['numero_Venta']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $id_Cliente = trim($_POST['select_cliente']);
          $nombreCliente = trim($_POST['nombre_Cliente']);
          $subtotalVenta = trim($_POST['subtotal_Venta']);
          $ivaVenta = trim($_POST['iva_Venta']);
          $totalVenta = trim($_POST['total_Venta']);
          $estadoRegistroV = trim($_POST['check_Entregado']);
          $fechaVenta = trim($_POST['fecha_Venta']);
          $precioTotal = 0 ;

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
          }else {
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
                  $precioP = $datos[4];


                  }
                }
             }



    }



    if (isset($_POST["btn-nuevo"])){
      $id_p = '';
      $pname = '';
      $cantidadP = 0;
      $precioP = 0;
      $precioTotal = 0;
      $subtotalVenta = 0;
      $ivaVenta = 0;
      $totalVenta = 0;
      $estadoRegistroV=1;
      $fechaVenta= trim(date('Y-m-d H:i:s'));
      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query1 = "SELECT MAX(idVenta) AS id FROM listado_venta";

      $statement = $connect->prepare($query1);
      $statement->execute();
      $count = $statement->rowCount();

      while( $datos = $statement->fetch()){
      $id = $datos[0];
      }
      $incremento=1;
      $numeroVenta=$id+$incremento;

      $data = [
    'numero_Venta' => $numeroVenta,
    'fecha_Venta' => $fechaVenta,
    'id_Cliente' => '0',
    'subtotal_Venta' => '0.00',
    'iva_Venta' => '0.00',
    'total_Venta' => '0.00',
    'estadoRegistroV' => '1'
    ,];

        $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "INSERT INTO listado_venta(fechaVenta, id_ClienteVenta, subtotalVenta, ivaVenta, totalVenta, numeroVenta, estadoRegistroV)
        VALUES (:fecha_Venta, :id_Cliente, :subtotal_Venta, :iva_Venta, :total_Venta, :numero_Venta, :estadoRegistroV)";
        $statement = $connect->prepare($query);
        $statement->execute($data);




    }

    if(isset($_POST["btn-searchCliente"])){

          $id_Cliente = trim($_POST['select_cliente']);
          $id_p = trim($_POST['select_product']);
          $pname = trim($_POST['name_product']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $precioP = trim($_POST['precio_Producto']);
          $precioTotal = trim($_POST['precio_Total']);
          $numeroVenta= trim($_POST['numero_Venta']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $subtotalVenta = trim($_POST['subtotal_Venta']);
          $ivaVenta = trim($_POST['iva_Venta']);
          $totalVenta = trim($_POST['total_Venta']);
          $estadoRegistroV = trim($_POST['check_Entregado']);
          $fechaVenta = trim($_POST['fecha_Venta']);


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
          $error = "El ID del cliente no puede ser menor a 1";
          $code = 1;
         }
         else {
            $data = [
            'id_Cliente' => $id_Cliente
            ,];

                $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT * FROM cat_clientes WHERE id_Cliente = :id_Cliente";
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
                  $nombreCliente = $datos[1];


                  }
                }
             }


    }

    if(isset($_POST["btn-guardar"])){
          $id_p = trim($_POST['select_product']);
          $pname = trim($_POST['name_product']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $precioP = trim($_POST['precio_Producto']);
          $precioTotal = trim($_POST['precio_Total']);
          $id_Cliente = trim($_POST['select_cliente']);
          $numeroVenta = trim($_POST['numero_Venta']);
          $fechaVenta = trim($_POST['fecha_Venta']);
          $nombreCliente = trim($_POST['nombre_Cliente']);
          $subtotalVenta = trim($_POST['subtotal_Venta']);
          $ivaVenta = trim($_POST['iva_Venta']);
          $totalVenta = trim($_POST['total_Venta']);
          $estadoRegistroV = trim($_POST['check_Entregado']);
          $fechaVenta = trim($_POST['fecha_Venta']);

          if(empty($numeroVenta))
          {
           $error = "Por favor ingresa un ID";
           $code = 1;
          }
          else if(!is_numeric($numeroVenta))
          {
           $error = "Solo se admiten numeros";
           $code = 1;
          }
          else if($numeroVenta>9999)
          {
           $error = "El ID no puede ser mayor a 4 Digitos";
           $code = 1;
          }
          else if($numeroVenta<1)
          {
           $error = "El ID no puede ser menor a 1";
           $code = 1;
         }
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
           $error = "El ID del cliente no puede ser menor a 1";
           $code = 1;
          }
          else if(empty($subtotalVenta))
          {
           $error = "El subtotal no puede estar vacio";
           $code = 1;
          }
          else if($subtotalVenta<0)
          {
           $error = "El subtotal no puede ser menor a 0.00";
           $code = 1;
          }
          else if($subtotalVenta>9999999)
          {
           $error = "El subtotal no puede ser mayor a 9,999,999.00";
           $code = 1;
          }
          else if(!is_numeric($subtotalVenta))
          {
           $error = "Solo se admiten numeros en el Subtotal";
           $code = 1;
          }
          else if(empty($ivaVenta))
          {
           $error = "El IVA no puede estar vacio";
           $code = 1;
          }
          else if($ivaVenta<0)
          {
           $error = "El IVA no puede ser menor a 0.00";
           $code = 1;
          }
          else if($ivaVenta>9999999)
          {
           $error = "El IVA no puede ser mayor a 9,999,999.0";
           $code = 1;
          }
          else if(!is_numeric($ivaVenta))
          {
           $error = "Solo se admiten numeros en el IVA";
           $code = 1;
          }
          else if(empty($totalVenta))
          {
           $error = "El Total de la venta no puede estar vacio";
           $code = 1;
          }
          else if($totalVenta<0)
          {
           $error = "El Total de la venta no puede ser menor a 0.00";
           $code = 1;
          }
          else if($totalVenta>9999999)
          {
           $error = "El Total de la venta no puede ser mayor a 9,999,999.0";
           $code = 1;
          }
          else if(!is_numeric($totalVenta))
          {
           $error = "Solo se admiten numeros en el Total de la venta";
           $code = 1;
          }
          else {
            $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM listado_venta WHERE numeroVenta = :numero_Venta";
            $statement = $connect->prepare($query);
            $statement->execute(
              [
                'numero_Venta' => $numeroVenta,
              ]
             );
            $count = $statement->rowCount();
            if($count > 0)
            {
              echo '<script language="javascript">';
              echo 'alert("Venta Guardada")';
              echo '</script>';

              $data = [
            'id_Cliente' => $id_Cliente,
            'subtotal_Venta' => $subtotalVenta,
            'iva_Venta' => $ivaVenta,
            'total_Venta' => $totalVenta,
            'estadoRegistroV' => 1
            ,];

                $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "UPDATE listado_venta
                SET id_ClienteVenta = :id_Cliente,
                subtotalVenta = :subtotal_Venta,
                ivaVenta = :iva_Venta,
                totalVenta = :total_Venta,
                estadoRegistroV = :estadoRegistroV
                WHERE idVenta = $numeroVenta";
                $statement = $connect->prepare($query);
                $statement->execute($data);

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
            'id_p' => $id_p,
              ];
              $query="SELECT estadoRegistroP FROM cat_producto WHERE id_Producto =:id_p";
              $statement = $connect->prepare($query);
              $statement->execute($data);
              while($datos = $statement->fetch()){
              $estadoRegistroP = $datos[0];
            }

              //Si el estado del producto no es "Eliminado" , actualiza el valor a 2 "Asociado"
              if ($estadoRegistroP !=3) {
                $data = [
              'id_p' => $id_p,
                ];
                $query="UPDATE cat_producto SET estadoRegistroP =2 WHERE id_Producto =:id_p";
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

                if (isset($_POST["check_Entregado"])) {
                    $data = [
                  'estadoRegistroV'=> 2,
                  'numeroVenta'=>$numeroVenta
                  ,];
                      $query = "UPDATE listado_venta
                               SET estadoRegistroV = :estadoRegistroV
                               WHERE idVenta = :numeroVenta";
                      $statement = $connect->prepare($query);
                      $statement->execute($data);

                      //inicia proceso de Suma de cantidad
                      $dataSuma = [
                    'numeroVenta'=>$numeroVenta
                    ,];
                      $querySuma= "SELECT claveProducto,SUM(cantidadProducto) AS SUMA FROM listadomovimientos WHERE idDocumentoVenta = :numeroVenta GROUP BY claveProducto";
                      $statement = $connect->prepare($querySuma);
                      $statement->execute($dataSuma);

                      while($datos = $statement->fetch()){
                      $id_p = $datos[0];
                      $Suma = $datos[1];

                      $existenciaP = $funcionsql ->existenciaProducto($id_p);
                      $existenciaActualP = $existenciaP - $Suma;

                      $dataSumaExistencia =[
                        'existenciaActualP' =>$existenciaActualP,
                        'id_p'=>$id_p
                      ,];

                      $queryUpdateSuma = "UPDATE cat_producto
                               SET existencia_Producto = :existenciaActualP
                               WHERE id_Producto = :id_p";
                               $statement2 = $connect->prepare($queryUpdateSuma);
                               $statement2->execute($dataSumaExistencia);
                      }
                }
              }
              else {
                if (isset($_POST["check_Entregado"])) {
                    $data = [
                  'estadoRegistroV'=> 2,
                  'numeroVenta'=>$numeroVenta
                  ,];
                      $query = "UPDATE listado_venta
                               SET estadoRegistroV = :estadoRegistroV
                               WHERE idVenta = :numeroVenta";
                      $statement = $connect->prepare($query);
                      $statement->execute($data);

                      //inicia proceso de Suma de cantidad
                      $dataSuma = [
                    'numeroVenta'=>$numeroVenta
                    ,];
                      $querySuma= "SELECT claveProducto,SUM(cantidadProducto) AS SUMA FROM listadomovimientos WHERE idDocumentoVenta = :numeroVenta GROUP BY claveProducto";
                      $statement = $connect->prepare($querySuma);
                      $statement->execute($dataSuma);

                      while($datos = $statement->fetch()){
                      $id_p = $datos[0];
                      $Suma = $datos[1];

                      $existenciaP = $funcionsql ->existenciaProducto($id_p);
                      $existenciaActualP = $existenciaP - $Suma;

                      $dataSumaExistencia =[
                        'existenciaActualP' =>$existenciaActualP,
                        'id_p'=>$id_p
                      ,];

                      $queryUpdateSuma = "UPDATE cat_producto
                               SET existencia_Producto = :existenciaActualP
                               WHERE id_Producto = :id_p";
                               $statement2 = $connect->prepare($queryUpdateSuma);
                               $statement2->execute($dataSumaExistencia);
                      }
                }

              }
            }
            header('Location: registroventa.php');
         }



    }


    if(isset($_POST["btn-agregar"])){

          $id_p = trim($_POST['select_product']);
          $pname = trim($_POST['name_product']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $precioP = trim($_POST['precio_Producto']);
          $precioTotal = trim($_POST['precio_Total']);
          $numeroVenta= trim($_POST['numero_Venta']);
          $cantidadP = trim($_POST['cantidad_Producto']);
          $id_Cliente = trim($_POST['select_cliente']);
          $nombreCliente = trim($_POST['nombre_Cliente']);
          $subtotalVenta = trim($_POST['subtotal_Venta']);
          $ivaVenta = trim($_POST['iva_Venta']);
          $totalVenta = trim($_POST['total_Venta']);
          $estadoRegistroV = trim($_POST['check_Entregado']);
          $fechaVenta = trim($_POST['fecha_Venta']);

          $precioTotal = $precioP * $cantidadP;
          if(empty($id_p))
          {
           $error = "Por favor ingresa un ID del producto";
           $code = 1;
          }else {
            //obtener Ultimo ID no sirve para el boton Agregar por que agrega movimientos al ultimo ID independiente de la venta en que se encuentre
            // $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
            // $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //
            // $query1 = "SELECT MAX(idVenta) AS id FROM listado_venta";
            //
            // $statement = $connect->prepare($query1);
            // $statement->execute();
            // $count = $statement->rowCount();
            //
            // while( $datos = $statement->fetch()){
            // $id = $datos[0];
            // }

            $data = [
            'id_p' => $id_p,
            'pname' => $pname,
            'cantidadP' => $cantidadP,
            'precioP' => $precioP,
            'precioTotal' => $precioTotal,
            'numeroVenta'=> $numeroVenta,
          ];

            $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO listadomovimientos(claveProducto, nombreProducto, cantidadProducto, precioProducto, precioTotalProducto, idDocumentoVenta)
            VALUES (:id_p, :pname, :cantidadP, :precioP, :precioTotal, :numeroVenta)";
            $statement = $connect->prepare($query);
            $statement->execute($data);

            //Inicia update Cliente
            $data = [
          'id_Cliente' => $id_Cliente
          ,];

              $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
              $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $query = "UPDATE listado_venta
              SET id_ClienteVenta = :id_Cliente
              WHERE idVenta = $numeroVenta";
              $statement = $connect->prepare($query);
              $statement->execute($data);

    }
  }

  if(isset($_POST["btn-searchVenta"])){

      $numeroVenta = trim($_POST['numero_Venta']);

      if(empty($numeroVenta))
      {
       $error = "Por favor ingresa un ID";
       $code = 1;
      }
      else if(!is_numeric($numeroVenta))
      {
       $error = "Solo se admiten numeros";
       $code = 1;
      }
      else if($numeroVenta>9999)
      {
       $error = "El ID no puede ser mayor a 4 Digitos";
       $code = 1;
      }
      else if($numeroVenta<1)
      {
       $error = "El ID no puede ser menor a 1";
       $code = 1;
      }
      else {
        $data = [
      'numero_Venta' => $numeroVenta
      ,];

      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT id_ClienteVenta, subtotalVenta, ivaVenta, totalVenta, numeroVenta, fechaVenta, estadoRegistroV FROM listado_venta WHERE numeroVenta = :numero_Venta";
      $statement = $connect->prepare($query);
      $statement->execute($data);

      $count = $statement->rowCount();
      if ($count ==0 ) {

        $fechaVenta="";
        $id_p = "";
        $pname = "";
        $descP = "";
        $costoP = "";
        $precioP ="";
        $unidadP = "";
        $existenciaP = "";
        $numeroVenta= "";
        $cantidadP = "";
        $id_Cliente = "";
        $nombreCliente = "";
        $subtotalVenta = "";
        $ivaVenta = "";
        $totalVenta = "";
        $precioTotal = "" ;

        echo "<script>";
        echo "alert('EL ID venta no esta registrado');";
        echo 'window.location.href = "registroventa.php"';
        echo "</script>";

      }else {
        while( $datos = $statement->fetch()){
        $id_Cliente = $datos[0];
        $subtotalVenta = $datos[1];
        $ivaVenta = $datos[2];
        $totalVenta = $datos[3];
        $numeroVenta = $datos[4];
        $fechaVenta = $datos[5];
        $estadoRegistroV = $datos[6];
      }

          $data = [
        'numero_Venta' => $numeroVenta
        ,];

      $query = "SELECT SUM(precioTotalProducto) as subtotal FROM listadomovimientos WHERE idDocumentoVenta = :numero_Venta";
      $statement = $connect->prepare($query);
      $statement->execute($data);
      while( $subtotal = $statement->fetch()){
      $subtotalVenta = $subtotal[0];
       }
      $ivaVenta = $subtotalVenta * .16;
      $totalVenta = $subtotalVenta + $ivaVenta;

      // Movimiento
      $numeroidMovimiento=$numeroVenta;

          $data = [
        'numero_idmovimiento' => $numeroidMovimiento
        ,];

        $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT claveProducto, nombreProducto, cantidadProducto, precioProducto, precioTotalProducto FROM listadomovimientos WHERE idDocumentoVenta = :numero_idmovimiento";
        $statement = $connect->prepare($query);
        $statement->execute($data);

        while( $datos = $statement->fetch()){
        $id_p = $datos[0];
        $pname = $datos[1];
        $cantidadP = $datos[2];
        $precioP = $datos[3];
        $precioTotal = $datos[4];
      }

      //Cliente Venta
      $data = [
      'id_cliente' => $id_Cliente
      ,];
      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "SELECT nombre_Cliente FROM cat_clientes WHERE id_Cliente = :id_cliente";
      $statement = $connect->prepare($query);
      $statement->execute($data);

      while( $datos = $statement->fetch()){
      $nombreCliente = $datos[0];
      }
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
        <h1>Venta</h1>
      </div>

      <div class="" id="">
        <form id="regVenta" class="" action="" method="post">
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
          <div id="venta">
            <h3>ID Venta</h3>
            <input id="" class="inputShort" type="text" name="numero_Venta" placeholder="No. Venta" value="<?php if(isset($numeroVenta)){echo $numeroVenta;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />
            <button type="submit" class="boton" name="btn-searchVenta">Buscar Venta</button>
            <button type="submit" class="boton"name="btn-nuevo">Nuevo</button>
          </div>

          <div id="venta" class="">

          </div>

          <div id="venta">
            <h3 id="labelFecha">Fecha</h3> <input class="inputShort" id="" type="text" name="fecha_Venta" placeholder="Fecha" value="<?php if(isset($fechaVenta)){echo $fechaVenta;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> />
            <h3>Entregado</h3>
            <input class="inputShort"type="checkbox" name="check_Entregado" id="cboxEntregado" value="2"<?php if ($estadoRegistroV==2) {echo "checked";} ?>/>
          </div>
          <div id="venta">
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
              <h3>Nombre del Cliente</h3><input class="inputShort"type="text" name="nombre_Cliente" placeholder="N. Cliente" value="<?php if(isset($nombreCliente)){echo $nombreCliente;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> />
              <button type="submit" name="btn-searchCliente">Buscar Cliente</button>
          </div>
          <div id="venta">
            <select class="inputShort" name="select_product">
              <option value="<?php if(isset($id_p)){echo $id_p;}  ?>"><?php if(isset($pname)){echo $pname;}  ?></option>
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
            <h3>Nombre del Producto</h3><input class="inputShort" type="text" name="name_product" placeholder="Nombre del producto" value="<?php if(isset($pname)){echo $pname;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> /></td>
            <h3>Cantidad</h3><input class="inputShort"type="text" name="cantidad_Producto" placeholder=" Cantidad" value="<?php if(isset($cantidadP)){echo $cantidadP;} ?>"  <?php if(isset($code) && $code == 7){ echo "autofocus"; }  ?> /></td>
            <h3>Precio</h3><input class="inputShort" type="text" name="precio_Producto" placeholder="Precio" value="<?php if(isset($precioP)){echo $precioP;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
            <h3>Precio Total</h3><input class="inputShort" type="text" name="precio_Total" placeholder="Precio Total" value="<?php if(isset($precioTotal)){echo $precioTotal;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
              <button type="submit" name="btn-search">Buscar Producto</button>
              <button type="submit" name="btn-agregar" <?php if ($estadoRegistroV==2) {echo "disabled";} ?>>Agregar</button>
          </div>

          <p>
            <?php
            //Tabla Sin if para mostrar los ultimos movimientos de la venta

            $data = [
            'numero_Venta' => $numeroVenta
            ,];
                $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT idMovimiento,claveProducto, nombreProducto, cantidadProducto, precioProducto, precioTotalProducto FROM listadomovimientos WHERE idDocumentoVenta= :numero_Venta";
                $statement = $connect->prepare($query);
                $statement->execute($data);
                echo "<table>
                <tr>
                <td width='150'>Clave</td>
                <td width='150'>Nombre</td>
                <td width='150'>Cantidad</td>
                <td width='150'>Precio U</td>
                <td width='150'>Precio Total</td>
                <td width='300'></td>
                </tr>";
                while($registro = $statement->fetch())
            {
              echo"
              <tr>
              <td width='150'>".$registro['claveProducto']."</td>
              <td width='150'>".$registro['nombreProducto']."</td>
              <td width='150'>".$registro['cantidadProducto']."</td>
              <td width='150'>".$registro['precioProducto']."</td>
              <td width='150'>".$registro['precioTotalProducto']."</td>
              <td width='150'>
              <form class='tablaMov' method = 'POST' action=''>
              <input type='hidden' name='id_Movimiento' value='".$registro['idMovimiento']."'>
              <input class='boton' type='submit' name='botonBorrarMov' value='Borrar'>
              </form>
              </td>
              </tr>
              ";
            }
            echo "</table>";
             ?>
             <?php
             if(isset($_POST["btn-agregar"])){
                     // Inicio Tabla, se borra para dejar que al actualizar el index se muestre la tabla con el ultimo registro


                     $query = "SELECT SUM(precioTotalProducto) as subtotal FROM listadomovimientos WHERE idDocumentoVenta = :numero_Venta";
                     $statement = $connect->prepare($query);
                     $statement->execute($data);
                     while( $subtotal = $statement->fetch()){
                     $subtotalVenta = $subtotal[0];
                      }
                     $ivaVenta = $subtotalVenta * .16;
                     $totalVenta = $subtotalVenta + $ivaVenta;
             }
             ?>
          </p>
          <p>
            <h3>Subtotal</h3><input  class="inputShort" type="text" name="subtotal_Venta" placeholder="Subtotal" value="<?php if(isset($subtotalVenta)){echo $subtotalVenta;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> />
            <h3>IVA</h3><input  class="inputShort" type="text" name="iva_Venta" placeholder="IVA" value="<?php if(isset($ivaVenta)){echo $ivaVenta;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> />
            <h3>Total</h3><input  class="inputShort" type="text" name="total_Venta" placeholder="Total Venta" value="<?php if(isset($totalVenta)){echo $totalVenta;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> />


          </p>
          <div class="">
            <button class="boton" type="submit" name="btn-guardar" <?php if ($estadoRegistroV==2) {echo "disabled";} ?>>Guardar </button>
          </div>
        </form>


      </div>

    </div>
  </body>
</html>
