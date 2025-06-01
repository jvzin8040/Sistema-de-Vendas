<?php
session_start();
require_once('../Model/Produto.php');

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$categoriaNome = $_POST['categoria'];
$preco = floatval($_POST['preco']);
$quantidade = intval($_POST['quantidade']);
$imagens = $_FILES['imagens'];

$ok = Produto::cadastrar($nome, $descricao, $categoriaNome, $preco, $quantidade, $imagens);

if ($ok) {
    echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href='../View/cadastrar_produto.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar produto.'); window.history.back();</script>";
}
?>