<?php
   session_start();


if(isset($_SESSION['tipo'])) {
    header("Location: areadm.php");
   
}else if(isset ($_SESSION['email'])){
    header("Location: aluno.php");

}else {
    header("Location: index.php");
    

}
?>