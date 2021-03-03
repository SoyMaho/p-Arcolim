<?php
ob_start();
session_start();
include("conexion.php");

//Importar PhpMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Cargar el Autoload de Composer

// require 'vendor/autoload.php';
// Para localhost require 'C:/Users/Mahonry Santiago/vendor/autoload.php';
require 'vendor/autoload.php';
//Instancias
$mail = new PHPMailer(true);
try {

  if(isset($_POST["button-Submit"])){
    $recaptcha=$_POST["g-recaptcha-response"];
    $url='https://www.google.com/recaptcha/api/siteverify';
    $data=array('secret'=>'6LdUQyoaAAAAAEzN4a71t4q198h8R1ILQs4C8LEU','response'=>$recaptcha);
    $options=array('http'=>array('method'=>'POST','header'=>'Content-Type: application/x-www-form-urlencoded\r\n','content'=>http_build_query($data)));
    $context=stream_context_create($options);
    $verify=file_get_contents($url,false,$context);
    $captcha_success=json_decode($verify);

    if(isset($_POST["button-Submit"])&& $captcha_success->success)
    {
         if(empty($_POST["correo"]))
         {
              $message = '<label>Ingresa un correo electronico</label>';
         }
         else
         {
              $correo= trim($_POST['correo']);
              $data1=[
                'correo'=>$correo,
              ];
              $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
              $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $query = "SELECT correo_Usuario FROM users WHERE correo_Usuario = :correo";
              $statement = $connect->prepare($query);
              $statement->execute($data1);

              while( $datos = $statement->fetch()){
              $correo = $datos[0];
              }
              $count = $statement->rowCount();
              if($count > 0)
              {

                   $message = "Correo registrado, se enviara un mensaje a la cuenta registrada";
                   $token = bin2hex(random_bytes(50));
                   //Configuraciones del Server
                   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Habilitar debug
                   $mail->isSMTP();                                            //Usar SMTP
                   $mail->Host       = 'email-smtp.us-west-2.amazonaws.com';                     //Asignar el servidor SMTP
                   $mail->SMTPAuth   = true;                                   //Habilitar Autenticacion SMTP
                   $mail->Username   = 'AKIAUO3SNH5U2JVJPPY5';                     //SMTP username
                   $mail->Password   = 'BJVINKRJJDY8gZH4TCbZDbirca15Zb4xGDiKY6v/KMYG';                               //SMTP password
                   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Habilitar Encriptacion TLS ;
                   $mail->Port       = 587;                                    //Puerto TCP para conectar, usar 465 para `PHPMailer::ENCRYPTION_SMTPS`

                   //Recipients
                   $mail->setFrom('mahonry.cordova@gmail.com', 'Mailer');
                      //Agrega un recipiente
                   $mail->addAddress($correo);               //Nombre es opcional
                   $mail->addReplyTo('info@example.com', 'Information');


                   //Attachments
                   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Ejemplo de adjunto
                   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Nombre opcional

                   //Content
                   $mail->isHTML(true);                                  //Formato Html para el Mail
                   $mail->Subject = 'Recuperacion de contraseña Arcolim App';
                   $mail->Body    = 'Hola, da clic en el siguiente <a href=\'http://arcoapp-env.eba-a4mzfnxd.us-west-2.elasticbeanstalk.com/rpass.php?token=' . $token . '\'>link</a> para cambiar tu contraseña';
                   $mail->AltBody = 'This is the body in plain text for non-HTML mail client';

                   $mail->send();

                   //Ingreso del token a la tabla de pass_Reset
                   $data1=[
                     'correo'=>$correo,
                     'token'=>$token,
                   ];
                   $query = "INSERT INTO pass_reset (email, token) VALUES (:correo, :token)";
                   $statement = $connect->prepare($query);
                   $statement->execute($data1);
                   echo 'Correo Enviado';

              }
              else
              {
                   $message = '<label>Correo no registrado</label>';
              }
         }
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <h1>Recuperar Contraseña</h1>
    <p>Por favor escribe tu correo elecronico</p>
    <p>Si tu correo coincide con uno registrado en nuestra base de datos</p>
    <p>Te enviaremos un mensaje para recuperar tu contraseña</p>
    <form class="" action="" method="post">
      <?php
      if(isset($message))
      {
           echo '<label class="text-danger">'.$message.'</label>';
      }
      ?>
      <input type="text" name="correo" placeholder="Correo Electronico" value="">
      <div class="g-recaptcha" data-sitekey="6LdUQyoaAAAAAChPziM_TlYTU4AddF41QzRWEzo7"></div>
      <button type="submit" name="button-Submit">Enviar</button>
    </form>


  </body>
</html>
<?php
ob_end_flush();
?>
