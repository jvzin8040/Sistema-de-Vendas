<?php
if (!isset($_SESSION)) {
    session_start();
}
if ((!isset($_SESSION['logado']) == true)) {
     echo "<script>alert('Acesso Negado! \n Realize o login primeiro.'); window.location.href='../View/pagina_login.php';</script>";
    die();
}
