<?php
require_once('../Model/Produto.php');
$categorias = Produto::listarCategorias();

$msg = '';
if (isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EID Store - Gerenciar Categorias</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/form.css" />
    <link rel="stylesheet" href="css/footer.css" />
</head>
<body>
    <?php include 'headerAdministrativo.php'; ?>
    <main style="background-color: #820AD1; padding: 50px 20px; min-height: 100vh;">
        <div style="background-color: white; max-width: 600px; margin: 0 auto; padding: 40px; border-radius: 10px;">
            <h2 style="text-align: center; margin-bottom: 30px;">Gerenciar Categorias</h2>

            <?php if ($msg): ?>
                <div style="background:#e7ffe7; color:#144d1a; border-radius:7px; padding:12px 18px; margin-bottom: 18px; border:1px solid #b8dfc6; text-align:center;">
                    <?= $msg ?>
                </div>
            <?php endif; ?>

            <form action="../Controller/criarCategoriaAction.php" method="post" enctype="multipart/form-data" style="margin-bottom:24px;">
                <label for="nova_categoria">Nova Categoria</label>
                <input type="text" id="nova_categoria" name="nome" required placeholder="Nome da nova categoria" />

                <label for="imagem_nova_categoria">Imagem da Categoria</label>
                <input type="file" id="imagem_nova_categoria" name="imagem" accept="image/*" required />

                <button type="submit" style="background-color: #18ad52; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; margin-top: 12px; cursor:pointer;">
                    Criar categoria
                </button>
            </form>

            <label for="categoria_id">Escolha a categoria</label>
            <select id="categoria_id" name="categoria_id" onchange="carregarCategoriaPorId()" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="">Selecione uma categoria</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['ID_categoria']) ?>">
                        <?= htmlspecialchars($cat['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <form action="../Controller/editarCategoriaAction.php" method="post" enctype="multipart/form-data">
                <label for="nome_categoria">Alterar nome da categoria</label>
                <input type="text" id="nome_categoria" name="nome" required />

                <label for="imagem_categoria">Imagem da Categoria</label>
                <input type="file" id="imagem_categoria" name="imagem" accept="image/*" required />

                <input type="hidden" name="id_categoria" id="categoria_id_hidden" />

                <button type="submit" style="background-color: #820AD1; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; margin-top: 20px; cursor:pointer;">
                    Editar categoria
                </button>
            </form>

            <form action="../Controller/excluirCategoriaAction.php" method="post" onsubmit="return verificarCategoriaSelecionada();" style="margin-top:15px;">
                <input type="hidden" name="id_categoria" id="categoria_id_hidden_excluir" />
                <button type="submit" class="delete-button" style="background-color: #d11a2a; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; cursor:pointer;">
                    Excluir categoria
                </button>
            </form>
        </div>
    </main>

    <script src="js/editar_categoria.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>