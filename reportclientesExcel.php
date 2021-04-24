<?php
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=reporteclientes.xls');


$connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT c.id_Cliente,c.nombre_Cliente, c.pApellido_Cliente, c.razonSocial_Cliente, c.rfc_Cliente, c.correo_Cliente, c.tel_Cliente, d.calle_Cliente, d.numeroEx_Cliente, d.numeroInt_Cliente, d.colonia_Cliente, d.ciudad_Cliente, e.nombre_Estado FROM cat_clientes AS c INNER JOIN cat_direccionclientes AS d ON c.direccion_Cliente = d.id_Direccion INNER JOIN cat_estado AS e ON d.estado_Cliente = e.id_Estado WHERE c.tipo_Entidad=1 ORDER BY c.id_Cliente";

$statement = $connect->prepare($query);
$statement->execute();
echo "<table>
<tr>
<td width='150'>Id</td>
<td width='150'>Nombre</td>
<td width='150'>Apellido</td>
<td width='150'>Razon Social</td>
<td width='150'>RFC</td>
<td width='150'>Correo</td>
<td width='150'>Telefono</td>
<td width='150'>Calle</td>
<td width='150'>Numero Ext</td>
<td width='150'>Numero Int</td>
<td width='150'>Colonia</td>
<td width='150'>Ciudad</td>
<td width='150'>Estado</td>
<td width='300'></td>
</tr>";
while($registro = $statement->fetch())
{
echo"
<tr>
<td width='150'>".$registro['id_Cliente']."</td>
<td width='150'>".$registro['nombre_Cliente']."</td>
<td width='150'>".$registro['pApellido_Cliente']."</td>
<td width='150'>".$registro['razonSocial_Cliente']."</td>
<td width='150'>".$registro['rfc_Cliente']."</td>
<td width='150'>".$registro['correo_Cliente']."</td>
<td width='150'>".$registro['tel_Cliente']."</td>
<td width='150'>".$registro['calle_Cliente']."</td>
<td width='150'>".$registro['numeroEx_Cliente']."</td>
<td width='150'>".$registro['numeroInt_Cliente']."</td>
<td width='150'>".$registro['colonia_Cliente']."</td>
<td width='150'>".$registro['ciudad_Cliente']."</td>
<td width='150'>".$registro['nombre_Estado']."</td>
</tr>
";
}

echo "</table>";

?>
