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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nome = trim($_POST['nome']);

    // Agora a imagem é obrigatória
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem = salvarImagemCategoria($_FILES['imagem']);
        if ($nome !== '' && $imagem !== null) {
            Produto::criarCategoria($nome, $imagem);
            header('Location: ../View/editar_categoria.php?msg=Categoria criada com sucesso!');
            exit;
        }
    }
    header('Location: ../View/editar_categoria.php?msg=Erro: Imagem obrigatória para criar categoria.');
    exit;
}

header('Location: ../View/editar_categoria.php?msg=Erro ao criar categoria');
exit;