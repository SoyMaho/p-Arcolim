<?php
ob_start();
session_start();
include("conexion.php");
include("sesion.php");
 try
 {
      $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(isset($_POST["botonLogin"]))
      {
           if(empty($_POST["campoUsuario"]) || empty($_POST["campoContraseña"]))
           {
                $message = '<label>Todos los campos son requeridos</label>';
           }
           else
           {
                $query = "SELECT * FROM users WHERE id_user = :id_u AND password_Usuario = :upass";
                $statement = $connect->prepare($query);
                $statement->execute(
                     array(
                          'id_u'     =>     $_POST["campoUsuario"],
                          'upass'     =>     $_POST["campoContraseña"]
                     )
                );
                $count = $statement->rowCount();
                if($count > 0)
                {
                     $_SESSION["user"] = $_POST["campoUsuario"];
                     $message = "Exito";
                     $sesion = new sesion ();
                     $sesion -> setCurrentUser($_POST["campoUsuario"]);
                     header('Location: home.php');
                }
                else
                {
                     $message = '<label>Usuario y/o Contraseña incorrecta</label>';
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
           <button type="submit" name="botonLogin"> Ingresar </button>
         </form>
       </div>
     </div>



   </body>
 </html>

 <?php
 ob_end_flush();
 ?>
