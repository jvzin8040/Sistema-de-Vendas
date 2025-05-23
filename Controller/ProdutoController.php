<?php
require_once(__DIR__ . '/../Model/Produto.php');

class ProdutoController {
    public function exibir($idProduto) {
        if (!$idProduto) {
            echo "<script>alert('Produto não encontrado!'); window.location.href='index.php';</script>";
            exit;
        }
        $produto = Produto::buscarPorId($idProduto);
        if (!$produto) {
            echo "<script>alert('Produto inválido.'); window.location.href='index.php';</script>";
            exit;
        }
        // Passa os dados para a View
        include(__DIR__ . '/../View/exibirProduto.php');
    }
}