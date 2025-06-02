<?php
session_start();
require_once '../Model/Produto.php';

$id_produto = isset($_POST['id_produto']) ? (int)$_POST['id_produto'] : 0;
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

if ($id_produto <= 0 || $quantidade <= 0) {
    header('Location: ../View/exibirProduto.php?id=' . $id_produto . '&erro=1');
    exit();
}

$produto = Produto::buscarPorId2($id_produto);
$estoque = $produto ? (int)($produto['qtdEstoque'] ?? 0) : 0;


$carrinho = $_SESSION['carrinho'] ?? [];
$no_carrinho = isset($carrinho[$id_produto]) ? (int)$carrinho[$id_produto] : 0;
$total_solicitado = $no_carrinho + $quantidade;

if ($total_solicitado > $estoque) {
    
    header('Location: ../View/exibirProduto.php?id=' . $id_produto . '&msg=limiteEstoque');
    exit();
}


if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}
$_SESSION['carrinho'][$id_produto] = $total_solicitado;

header('Location: ../View/exibirProduto.php?id=' . $id_produto . '&msg=adicionado');
exit();