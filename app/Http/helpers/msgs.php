<?php
namespace App\Http\helpers;

if(!isset($_SESSION)){
    session_start();
}
function flash($name = '', $message = '', $class = 'alert alert-danger '){
    if(!empty($name)){
        if(!empty($message) && empty($_SESSION[$name])){
            $_SESSION[$name] ="<strong >".$message."</strong>";
            $_SESSION[$name.'_class'] = $class;
        }else if(empty($message) && !empty($_SESSION[$name])){
            $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : $class;
            echo '<div class="'.$class.'" >'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
           
           
        }
    }
}
?>
<?php 

function redirect($location){
    header("location: ".$location);
    exit();
}
?>