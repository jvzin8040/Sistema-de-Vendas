<?php
require_once('../Model/Produto.php');

function salvarImagemCategoria($file)
{
    if ($file['error'] !== UPLOAD_ERR_OK) return null;

    $nomeOriginal = $file['name'];
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
    $nomeFinal = uniqid("cat_", true) . '.' . $extensao;
    $diretorioDestino = "../public/uploads/";

    if (!is_dir($diretorioDestino)) {
        mkdir($diretorioDestino, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $diretorioDestino . $nomeFinal)) {
        return $nomeFinal;
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_categoria'], $_POST['nome'])) {
    $id = intval($_POST['id_categoria']);
    $nome = trim($_POST['nome']);

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem = salvarImagemCategoria($_FILES['imagem']);
        if ($id > 0 && $nome !== '' && $imagem !== null) {
            Produto::editarCategoria($id, $nome, $imagem);
            header('Location: ../View/editar_categoria.php?msg=Categoria editada com sucesso!');
            exit;
        }
        header('Location: ../View/editar_categoria.php?msg=Erro: Imagem obrigatória para editar categoria.');
        exit;
    } else {
        header('Location: ../View/editar_categoria.php?msg=Erro: Imagem obrigatória para editar categoria.');
        exit;
    }
}

header('Location: ../View/editar_categoria.php?msg=Erro ao editar categoria');
exit;