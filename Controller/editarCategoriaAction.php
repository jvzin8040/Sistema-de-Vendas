<?php
require_once('../Model/Produto.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_categoria'], $_POST['nome'])) {
    $id = intval($_POST['id_categoria']);
    $nome = trim($_POST['nome']);
    if ($id > 0 && $nome !== '') {
        Produto::editarCategoria($id, $nome);
        header('Location: ../View/editar_categoria.php?msg=Categoria editada com sucesso');
        exit;
    }
}

header('Location: ../View/editar_categoria.php?msg=Erro ao editar categoria');
exit;