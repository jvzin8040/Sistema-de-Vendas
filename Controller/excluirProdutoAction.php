<?php
session_start();
require_once('../Model/Produto.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = isset($_POST['codigo']) ? intval($_POST['codigo']) : null;
    if (!$produto_id) {
        die('ID do produto não informado.');
    }

    $result = Produto::excluir($produto_id);

    if ($result['success']) {
        echo "<script>alert('{$result['message']}'); window.location.href='../view/cadastro.php';</script>";
    } else {
        echo "<script>alert('{$result['message']}'); window.history.back();</script>";
    }
} else {
    die("Método inválido.");
}
?>