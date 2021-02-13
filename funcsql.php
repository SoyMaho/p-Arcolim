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
          $numeroVenta=$id;

              $data = [
            'numero_Venta' => $numeroVenta
            ,];

            $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT $nombreColumnaIdAsignada FROM $tabla WHERE numeroVenta = :numero_Venta";
            $statement = $connect->prepare($query);
            $statement->execute($data);

            while( $datos = $statement->fetch()){
            $numeroVenta = $datos[0];
          }
          return $numeroVenta;
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
}
?>
