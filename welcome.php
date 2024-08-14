<?php 
session_start();
if(isset($_POST['cerrarSesion'])){
    unset($_SESSION['usuario']);
    header('Location: index.php');
}
include 'templates/header2.php';
?>



<?php include 'templates/footer.php'; ?>