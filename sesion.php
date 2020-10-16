<?php


/**
 *
 */
class sesion
{


  public function setCurrentUser($user){
          $_SESSION['user'] = $user;
      }

      public function getCurrentUser(){
          return $_SESSION['user'];
      }

      public function closeSession(){
        // Se elimina la funcion session_unset , debido a que ya no esta soportada.
        // Se limpian las variables de sesion.
            $_SESSION = array();
        // Se destruye la sesion
             session_destroy();
         }



}



?>
