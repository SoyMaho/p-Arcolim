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

      public function buscarUltimaVenta(){
        $id_Cliente=0 ;
        $subtotalVenta =0 ;
        $ivaVenta =0;
        $totalVenta =0;
        $numeroVenta =0;

        include("conexion.php");
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
          $query = "SELECT id_ClienteVenta, subtotalVenta, ivaVenta, totalVenta, numeroVenta FROM listado_venta WHERE numeroVenta = :numero";
          $statement = $connect->prepare($query);
          $statement->execute($data);

          while( $datos = $statement->fetch()){
          $id_Cliente = $datos[0];
          $subtotalVenta = $datos[1];
          $ivaVenta = $datos[2];
          $totalVenta = $datos[3];
          $numeroVenta = $datos[4];
        }
        return $numeroVenta;
        }
}
?>
