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

// Guarda os produtos selecionados para o checkout
$_SESSION['checkout_multi'] = $_SESSION['carrinho'];
header('Location: ../View/checkout_multi.php');
exit();
?>