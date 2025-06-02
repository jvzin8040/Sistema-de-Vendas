<?php
require_once(__DIR__ . '/../Model/produto.php');
$nome = $_GET['q'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$produtos = Produto::buscarPorNomeECategoria($nome, $categoria);
header('Content-Type: application/json');
echo json_encode($produtos);
exit;
?>