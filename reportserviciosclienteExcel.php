<?php
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=reportpedidoscliente.xls');


$connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT c.nombre_Cliente, s.id_Servicio, s.nombre_Servicio, s.tipo_Servicio, s.precio_Servicio, s.fecha_Realizacion FROM listado_servicio AS s INNER JOIN cat_clientes AS c ON c.id_Cliente = s.cliente_Servicio WHERE s.estado_Servicio!=3
ORDER BY cliente_Servicio";

$statement = $connect->prepare($query);
$statement->execute($data);
echo "<table>
<tr>
<td width='150'>Cliente</td>
<td width='150'>Folio</td>
<td width='150'>Nombre del servicio</td>
<td width='150'>Tipo</td>
<td width='150'>Precio</td>
<td width='150'>Fecha Realizacion</td>
<td width='300'></td>
</tr>";
while($registro = $statement->fetch())
{
echo"
<tr>
<td width='150'>".$registro['nombre_Cliente']."</td>
<td width='150'>".$registro['id_Servicio']."</td>
<td width='150'>".$registro['nombre_Servicio']."</td>
<td width='150'>".$registro['tipo_Servicio']."</td>
<td width='150'>".$registro['precio_Servicio']."</td>
<td width='150'>".$registro['fecha_Realizacion']."</td>
</tr>
";
}

echo "</table>";

?>
