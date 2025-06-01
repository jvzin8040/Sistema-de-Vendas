<?php
session_start();
$title = "Produto - EID Store";
require_once(__DIR__ . '/../Model/Produto.php');

$idProduto = $_GET['id'] ?? null;
if (!$idProduto) {
  echo "<script>alert('Produto não encontrado!'); window.location.href='index.php';</script>";
  exit;
}

$produto = Produto::buscarPorId($idProduto);
if (!$produto) {
  echo "<script>alert('Produto inválido.'); window.location.href='index.php';</script>";
  exit;
}

$msg = $_GET['msg'] ?? '';
if ($msg === 'adicionado') {
  echo "<script>alert('Produto adicionado ao carrinho!');</script>";
}
if ($msg === 'limiteEstoque') {
  echo "<script>alert('Você não pode adicionar mais do que o estoque disponível!');</script>";
}


$galeria = [];
foreach (['imagem', 'imagem_2', 'imagem_3'] as $imgField) {
    if (!empty($produto[$imgField])) {
        $galeria[] = $produto[$imgField];
    }
}
if (empty($galeria)) {
    $galeria[] = 'no-image.png';
}
$imgPrincipal = $galeria[0];