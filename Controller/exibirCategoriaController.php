<?php
require_once('../Model/Produto.php');

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
if (!$categoria) {
    header("Location: index.php");
    exit();
}
$produtos = Produto::listarPorCategoria($categoria);

$title = "<br>Produtos da categoria: " . htmlspecialchars($categoria);