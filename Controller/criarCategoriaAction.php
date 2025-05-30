<?php
require_once('../Model/Produto.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nome = trim($_POST['nome']);
    if ($nome !== '') {
        Produto::criarCategoria($nome);
        header('Location: ../View/editar_categoria.php?msg=Categoria criada com sucesso');
        exit;
    }
}

header('Location: ../View/editar_categoria.php?msg=Erro ao criar categoria');
exit;