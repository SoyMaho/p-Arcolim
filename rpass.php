<?php
ob_start();
session_start();
include("conexion.php");

try {

              $newPass =  trim($_POST['new_Pass']);
              $confirmPass = trim($_POST['confirmPass']);

              $token= $_GET['token'];
              $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
              $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $query = "SELECT email FROM pass_reset WHERE token = :token";
              $data=[
                'token'=>$token,
              ];
              $statement = $connect->prepare($query);
              $statement->execute($data);
              while( $datos = $statement->fetch()){
              $correo = $datos[0];
              }

                if(isset($_POST["button-Submit"])){
                  if(empty($newPass))
                  {
                       $message = '<label>Ingresa la contraseña</label>';
                  } else if (empty($confirmPass)) {
                       $message = '<label>Confirma la contraseña</label>';
                  }else if ($newPass !== $confirmPass ) {
                    $message = '<label>La contraseña y la confirmacion no coincide</label>';
                  }
                  else
                  {
                    $newPass =  trim($_POST['new_Pass']);
                    $confirmPass = trim($_POST['confirmPass']);
                    //Actualiza Password
                    $data=[
                      'correo'=>$correo,
                      'new_Pass'=>$newPass,
                    ];
                    $query = "UPDATE users SET password_Usuario = :new_Pass WHERE correo_Usuario = :correo";
                    $statement = $connect->prepare($query);
                    $statement->execute($data);



                    echo "<script>";
                    echo "alert('Contraseña Actualizada, será redirigido a la pagina principal');";
                    echo 'window.location.href = "index.php"';
                    echo "</script>";
             }

           }
} catch (PDOException $error) {
$message = $error->getMessage();

}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Olvide mi contraseña</title>
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <h1>Nueva contraseña</h1>
    <p>Ingresa y confirma tu nueva contraseña</p>
    <form class="" action="" method="post">
      <?php
      if(isset($message))
      {
           echo '<label class="text-danger">'.$message.'</label>';
      }
      ?>
      <input type="text" name="new_Pass" value="Nueva Contraseña">
      <input type="text" name="confirmPass" value="Confirmar Contraseña">
      <button type="submit" name="button-Submit">Enviar</button>
    </form>


  </body>
</html>
<?php
ob_end_flush();
?>
