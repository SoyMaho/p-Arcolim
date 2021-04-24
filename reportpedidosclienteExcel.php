<?php
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=reportpedidoscliente.xls');


$connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT s.idVenta,c.nombre_Cliente,lm.claveProducto,lm.nombreProducto,lm.cantidadProducto,lm.precioProducto, lm.precioTotalProducto, s.fechaVenta FROM cat_clientes AS c INNER JOIN listado_venta AS s ON c.id_Cliente = s.id_ClienteVenta INNER JOIN listadomovimientos AS lm ON lm.idDocumentoVenta = s.idVenta WHERE s.estadoRegistroV!=3 ORDER BY s.id_ClienteVenta";

$statement = $connect->prepare($query);
$statement->execute($data);
echo "<table>
<tr>
<td width='150'>Folio</td>
<td width='150'>Cliente</td>
<td width='150'>Clave Producto</td>
<td width='150'>Nombre Producto</td>
<td width='150'>Cantidad Producto</td>
<td width='150'>Precio Producto</td>
<td width='150'>Precio Total Producto</td>
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
<td width='150'>".$registro['precioProducto']."</td>
<td width='150'>".$registro['fechaVenta']."</td>
</tr>
";
}

echo "</table>";

?>
