<?php
require_once('../Model/Produto.php');

// Recebe o nome da categoria via GET
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

if (!$categoria) {
    header("Location: index.php");
    exit();
}

// Busca produtos da categoria
$produtos = Produto::listarPorCategoria($categoria);

$title = "Produtos da categoria: " . htmlspecialchars($categoria);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
   <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2 style="margin: 30px 0;"><?= $title ?></h2>
    <div class="products-row">
        <?php if ($produtos && count($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="product-card">
                    <img src="../public/uploads/<?= htmlspecialchars($produto['imagem'] ?? 'no-image.png') ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                    <p><?= htmlspecialchars($produto['descricao']) ?></p>
                    <span class="price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                    <a href="exibirProduto.php?id=<?= $produto['ID_produto'] ?>" class="button">Ver Produto</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum produto encontrado nesta categoria.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>