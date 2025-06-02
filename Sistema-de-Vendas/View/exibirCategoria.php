<?php
require_once('../Controller/exibirCategoriaController.php'); 
include 'header.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/exibirCategoria.css">
</head>

<body>
    <div class="container">
        <h2 class="title-categoria"><?= $title ?></h2>
        <div class="produtos-matriz-row">
            <?php if ($produtos && count($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                    <a href="exibirProduto.php?id=<?= $produto['ID_produto'] ?>" class="produto-link">
                        <div class="produto-card">
                            <img src="<?= !empty($produto['imagem'])
                                            ? '../public/uploads/' . htmlspecialchars($produto['imagem'])
                                            : '../public/uploads/no-image.png'; ?>"
                                alt="<?= htmlspecialchars($produto['nome']) ?>">
                            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                            <span class="price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                            <span class="estoque">Estoque: <?= (int)($produto['qtdEstoque'] ?? 0) ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="margin: 40px auto; text-align: center; color: #888;">Nenhum produto encontrado nesta categoria.</p>
            <?php endif; ?>
        </div>
        <br><br>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>