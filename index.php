<?php
ob_start();
session_start();
include("conexion.php");
include("sesion.php");
 try
 {



     if (isset($_SESSION['user'])){
     header('Location: home.php');
   } else {
     $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // $recaptcha=isset($_POST["g-recaptcha-response"]);


     if(isset($_POST["botonLogin"])){
       $recaptcha=$_POST["g-recaptcha-response"];
       $url='https://www.google.com/recaptcha/api/siteverify';
       $data=array('secret'=>'6LdUQyoaAAAAAEzN4a71t4q198h8R1ILQs4C8LEU','response'=>$recaptcha);
       $options=array('http'=>array('method'=>'POST','header'=>'Content-Type: application/x-www-form-urlencoded\r\n','content'=>http_build_query($data)));
       $context=stream_context_create($options);
       $verify=file_get_contents($url,false,$context);
       $captcha_success=json_decode($verify);
       if(isset($_POST["botonLogin"])&& $captcha_success->success)
       {
            if(empty($_POST["campoUsuario"]) || empty($_POST["campoContraseña"]))
            {
                 $message = '<label>Todos los campos son requeridos</label>';
            }
            else
            {
                 $query = "SELECT * FROM users WHERE nombre_Usuario = :n_Usuario AND password_Usuario = :upass";
                 $statement = $connect->prepare($query);
                 $statement->execute(
                      array(
                           'n_Usuario'     =>     $_POST["campoUsuario"],
                           'upass'     =>     $_POST["campoContraseña"]
                      )
                 );
                 $count = $statement->rowCount();
                 if($count > 0)
                 {

                      $message = "Exito";
                      $sesion = new sesion ();
                      $sesion -> setCurrentUser($_POST["campoUsuario"]);
                      //Se borra la linea por que era redundante.
                      //$_SESSION["user"] = $_POST["campoUsuario"];
                      header('Location: home.php');
                      die();
                 }
                 else
                 {
                      $message = '<label>Usuario y/o Contraseña incorrecta</label>';
                 }
            }
       }
     }


   }
 }
 catch(PDOException $error)
 {
      $message = $error->getMessage();
 }?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>SGCA</title>
     <link rel="stylesheet" href="css/main.css">
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
   </head>
   <body>



     <div class="contenedorP">

       <div class="login">


         <form method="post">
           <img id="logo_index" src="img/arcolim_Logo.jpg" alt="">
           <h1 id="titulo_P">Sistema web de venta</h1>
           <h1 id="inicio_S"> Inicio de Sesion</h1>
           <?php


           if(isset($message))
           {
                echo '<label class="text-danger">'.$message.'</label>';
           }
           ?>
           <input type="text" name="campoUsuario" placeholder="Usuario" value="">
           <input type="password" name="campoContraseña" placeholder="Contraseña" value="">
           <div class="g-recaptcha" data-sitekey="6LdUQyoaAAAAAChPziM_TlYTU4AddF41QzRWEzo7"></div>
           <button type="submit" name="botonLogin"> Ingresar </button>

         </form>
       </div>
     </div>



   </body>
 </html>

 <?php
 ob_end_flush();
 ?>
