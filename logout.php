<?php

session_start();

include_once 'sesion.php';

   $userSession = new sesion();
   $userSession->closeSession();
   header("location: index.php")
 ?>
