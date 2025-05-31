<?php
session_start();
$id_produto = $_POST['id_produto'] ?? 0;
if (isset($_SESSION['carrinho'][$id_produto])) {
    unset($_SESSION['carrinho'][$id_produto]);
}
header('Location: ../View/carrinho.php');
exit();
?>