<?php
require_once('../Model/Produto.php');
$produtos = Produto::listarTodos();
$categorias = Produto::listarCategorias();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EID Store - Editar Produto</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/form.css" />
    <link rel="stylesheet" href="css/footer.css" />
</head>
<body>
    <?php include 'headerAdministrativo.php'; ?>
    <main style="background-color: #820AD1; padding: 50px 20px; min-height: 100vh;">
        <div style="background-color: white; max-width: 600px; margin: 0 auto; padding: 40px; border-radius: 10px;">
            <h2 style="text-align: center; margin-bottom: 30px;">Editar produto</h2>

            <label for="produto_id">Escolha o produto</label>
            <select id="produto_id" name="produto_id" onchange="carregarProdutoPorId()" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="">Selecione um produto</option>
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?= htmlspecialchars($produto['ID_produto']) ?>">
                        <?= htmlspecialchars($produto['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <form action="../Controller/editarProdutoAction.php" method="post" enctype="multipart/form-data">
                <label for="nome">Alterar nome do produto</label>
                <input type="text" id="nome" name="nome" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;" />

                <label for="descricao">Alterar descrição do produto</label>
                <input type="text" id="descricao" name="descricao" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;" />

                <label for="imagens">Imagens do produto</label>
                <input type="file" id="imagens" name="imagens[]" multiple accept="image/*" style="width: 100%; margin-bottom: 5px;" onchange="limitarImagens(this)">
                <small style="display:block; margin-bottom:10px; color:#666;">Máximo de 3 imagens por produto.</small>

                <label for="categoria">Alterar categoria do produto</label>
                <select id="categoria" name="categoria" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['ID_categoria']) ?>">
                            <?= htmlspecialchars($cat['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p style="font-size: 0.97em; margin-bottom: 12px; color: #555;">
                    Caso deseje criar uma categoria, <a href="editar_categoria.php" style="color: #820AD1; text-decoration: underline;">clique aqui</a>.
                </p>

                <label for="preco">Alterar preço (R$) do produto</label>
                <input type="number" step="0.01" id="preco" name="preco" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;" />

                <label for="quantidade">Alterar quantidade disponível</label>
                <input type="number" id="quantidade" name="quantidade" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;" />

                <input type="hidden" name="produto_id" id="produto_id_hidden" />

                <button type="submit" style="background-color: #820AD1; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; margin-top: 20px; cursor:pointer;">Editar produto</button>
            </form>

            <form action="../Controller/excluirProdutoAction.php" method="post" onsubmit="return verificarProdutoSelecionado();" style="margin-top:15px;">
                <input type="hidden" name="codigo" id="produto_id_hidden_excluir" />
                <button type="submit" class="delete-button" style="background-color: #d11a2a; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; cursor:pointer;">Excluir produto</button>
            </form>
        </div>
    </main>

    <script src="js/editar_produto.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>