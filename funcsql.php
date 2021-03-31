<?php

class funcionSQL{

  public function eliminarMovimiento($idMovimiento){

    $data1 = [
    'id_Movimiento' => $idMovimiento
    ,];

    $data2 = [
    'id_Cliente' => $id_Cliente
    ,];

        $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE FROM listadomovimientos WHERE idMovimiento = :id_Movimiento";
        $statement = $connect->prepare($query);
        $statement->execute($data1);
      }

      //Funcion para obtener el ultimoID de una tabla
    public function ultimoId($nombreColumnaIdSQL, $tabla, $nombreColumnaIdAsignada){
          include("conexion.php");
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $query1 = "SELECT MAX($nombreColumnaIdSQL) AS id FROM $tabla";

          $statement = $connect->prepare($query1);
          $statement->execute();
          $count = $statement->rowCount();

          while( $datos = $statement->fetch()){
          $id = $datos[0];
          }

              $data = [
            'id' => $id
            ,];

            $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT $nombreColumnaIdAsignada FROM $tabla WHERE $nombreColumnaIdSQL = :id";
            $statement = $connect->prepare($query);
            $statement->execute($data);

            while( $datos = $statement->fetch()){
            $id = $datos[0];
          }
          return $id;
        }

        public function existenciaProducto($idProducto){
          include("conexion.php");
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $data=[
            'id_Producto'=>$idProducto,
          ];

          $query1 = "SELECT existencia_Producto FROM cat_producto WHERE id_Producto =:id_Producto";
          $statement = $connect->prepare($query1);
          $statement->execute($data);
          while( $datos = $statement->fetch()){
          $existenciaProducto = $datos[0];
        }
        return $existenciaProducto;
        }

        public function costoProducto($idProducto){
          include("conexion.php");
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $data=[
            'id_Producto'=>$idProducto,
          ];

          $query1 = "SELECT costo_Producto FROM cat_producto WHERE id_Producto =:id_Producto";
          $statement = $connect->prepare($query1);
          $statement->execute($data);
          while( $datos = $statement->fetch()){
          $costoProducto = $datos[0];
        }
        return $costoProducto;
        }

        public function nRegistroVenta(){
          include("conexion.php");
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

        public function costoPromedio($idProducto){
          include("conexion.php");
          $dataSuma = [
        'idProducto'=>$idProducto
        ,];

          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //Se valida la cantidad de entradas totales del producto
          $query="SELECT costoProducto FROM listado_entrada WHERE idProductoEntrada=:idProducto AND estadoRegistroE !=3";
          $statement = $connect->prepare($query);
          $statement->execute($dataSuma);
          $count=$statement->rowCount();

          //Se suman los costos de cada entrada para el producto
          $dataSuma = [
        'idProducto'=>$idProducto
        ,];
          $querySuma= "SELECT SUM(costoProducto) AS SUMA FROM listado_entrada WHERE idProductoEntrada = :idProducto AND estadoRegistroE !=3";
          $statement = $connect->prepare($querySuma);
          $statement->execute($dataSuma);

          //Se recorre la consulta y se asigna al string suma, el cual se divide en la cantidad de entradas que no sean eliminadas

          while($datos = $statement->fetch()){
          $Suma = $datos[0];
          }
          $div=($Suma/$count);
          settype($div,'string');
          return $div;
        }


}
?>
