<?php
$title = "EID Store";
require_once('../Model/Produto.php');
$categorias = Produto::listarCategorias();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/footer.css">
</head>

<body>
   <?php include 'headerAdministrativo.php'; ?>
    <main style="background-color: #820AD1; padding: 50px 20px; min-height: 100vh;">
        <div style="background-color: white; max-width: 600px; margin: 0 auto; padding: 40px; border-radius: 10px;">
            <h2 style="text-align: center; margin-bottom: 30px;">Cadastrar novo produto</h2>
            <form action="../Controller/cadastrarProdutoAction.php" method="post" enctype="multipart/form-data">
                <label for="nome">Nome do produto</label>
                <input type="text" id="nome" name="nome" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

                <label for="descricao">Descrição do produto</label>
                <input type="text" id="descricao" name="descricao" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

                <label for="imagens">Imagens do produto</label>
                <input type="file" id="imagens" name="imagens[]" multiple accept="image/*" style="width: 100%; margin-bottom: 5px;" onchange="limitarImagens(this)">
                <small style="display:block; margin-bottom:10px; color:#666;">Máximo de 3 imagens por produto.</small>

                <label for="categoria">Categoria</label>
                <select id="categoria" name="categoria" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['nome']) ?>">
                            <?= htmlspecialchars($cat['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <p style="font-size: 0.97em; margin-bottom: 12px; color: #555;">
                    Caso deseje criar uma categoria, <a href="editar_categoria.php" style="color: #820AD1; text-decoration: underline;">clique aqui</a>.
                </p>

                <label for="preco">Preço (R$)</label>
                <input type="text" id="preco" name="preco" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

                <label for="quantidade">Quantidade disponível</label>
                <input type="number" id="quantidade" name="quantidade" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">

                <button type="submit" style="background-color: #820AD1; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; cursor:pointer;">Cadastrar produto</button>
            </form>
        </div>
    </main>
    <script src="js/cadastrar_produto.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>