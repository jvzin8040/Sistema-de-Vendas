<?php 
session_start(); 

$title = "EID Store"; 

if (isset($_GET['comprar_agora']) && isset($_GET['id'])) {
    $_SESSION['compra_pendente'] = [
        'id_produto' => $_GET['id'],
        'quantidade' => $_GET['quantidade'] ?? 1
    ];
}