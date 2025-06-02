<?php
require_once('../Model/Produto.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = intval($_POST['produto_id']);
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = intval($_POST['categoria']);
    $preco = floatval($_POST['preco']);
    $quantidade = intval($_POST['quantidade']);
    $imagens = isset($_FILES['imagens']) ? $_FILES['imagens'] : null;

    $result = Produto::editar($produto_id, $nome, $descricao, $categoria, $preco, $quantidade, $imagens);

    if ($result['success']) {
        echo "<script>alert('{$result['message']}'); window.location.href='../view/painelGestor.php';</script>";
    } else {
        echo "<script>alert('{$result['message']}'); window.history.back();</script>";
    }
}
?>