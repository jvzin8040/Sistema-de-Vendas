<?php
session_start();
require_once '../Model/Produto.php';

$carrinho = $_SESSION['carrinho'] ?? [];
$produtos = [];
$total = 0.0;

if ($carrinho) {
    foreach ($carrinho as $id => $qtd) {
        $produto = Produto::buscarPorId2($id);
        if ($produto) {
            $produto['quantidade'] = $qtd;
            $produto['subtotal'] = $produto['preco'] * $qtd;
            $produto['imagem'] = isset($produto['imagem']) && $produto['imagem'] ? $produto['imagem'] : 'no-image.png';
            $produtos[] = $produto;
            $total += $produto['subtotal'];
        }
    }
}
