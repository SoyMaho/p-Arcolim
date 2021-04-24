<?php
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=reportventasproduct.xls');


$connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT s.idVenta, c.nombre_Cliente,lm.claveProducto,lm.nombreProducto,lm.cantidadProducto,lm.precioProducto, lm.precioTotalProducto, s.fechaVenta FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta INNER JOIN listadomovimientos AS lm ON lm.idDocumentoVenta = s.idVenta WHERE s.estadoRegistroV!=3 ORDER BY lm.nombreProducto";

$statement = $connect->prepare($query);
$statement->execute();
echo "<table class='report'>
<tr>
<td width='150'>Folio</td>
<td width='150'>Cliente</td>
<td width='150'>Clave del producto</td>
<td width='150'>Nombre del producto</td>
<td width='150'>Cantidad</td>
<td width='150'>Precio</td>
<td width='150'>Precio Total</td>
<td width='150'>Fecha Venta</td>
<td width='300'></td>
</tr>";
while($registro = $statement->fetch())
{
echo"
<tr>
<td width='150'>".$registro['idVenta']."</td>
<td width='150'>".$registro['nombre_Cliente']."</td>
<td width='150'>".$registro['claveProducto']."</td>
<td width='150'>".$registro['nombreProducto']."</td>
<td width='150'>".$registro['cantidadProducto']."</td>
<td width='150'>".$registro['precioProducto']."</td>
<td width='150'>".$registro['precioTotalProducto']."</td>
<td width='150'>".$registro['fechaVenta']."</td>
</tr>
";
}

echo "</table>";

?>
