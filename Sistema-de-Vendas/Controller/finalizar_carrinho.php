<?php
session_start();

if (!isset($_SESSION['id_cliente'])) {
    header('Location: ../View/pagina_login.php');
    exit();
}

if (empty($_SESSION['carrinho'])) {
    header('Location: ../View/carrinho.php');
    exit();
}

$_SESSION['checkout_multi'] = $_SESSION['carrinho'];
header('Location: ../View/checkout_multi.php');
exit();
?>