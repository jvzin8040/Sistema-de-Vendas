<?php
require_once('../Model/Produto.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_categoria'])) {
    $id = intval($_POST['id_categoria']);
    if ($id > 0) {
        Produto::excluirCategoria($id);
        header('Location: ../View/editar_categoria.php?msg=Categoria excluída com sucesso');
        exit;
    }
}

header('Location: ../View/editar_categoria.php?msg=Erro ao excluir categoria');
exit;