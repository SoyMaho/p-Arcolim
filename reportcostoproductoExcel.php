<?php
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=reportcostoproducto.xls');


$connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT id_Producto, nombre_Producto,costo_Producto FROM cat_producto WHERE pOculto =0 ORDER BY id_Producto";

$statement = $connect->prepare($query);
$statement->execute();
echo "<table>
<tr>
<td width='150'>ID Producto</td>
<td width='150'>Nombre</td>
<td width='150'>Costo</td>
<td width='300'></td>
</tr>";
while($registro = $statement->fetch())
{
echo"
<tr>
<td width='150'>".$registro['id_Producto']."</td>
<td width='150'>".$registro['nombre_Producto']."</td>
<td width='150'>$ ".$registro['costo_Producto']."</td>
</tr>
";
}

echo "</table>";

?>
