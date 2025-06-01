<?php
require_once(__DIR__ . '/../Model/Produto.php');
$categorias = Produto::listarCategorias();
?>

<link rel="stylesheet" href="css/categories.css"> <!-- Reaproveita o CSS dos produtos -->

<section class="categories-container" id="categorias">
    <h2 style="color:#630dbb;text-align:center;margin-bottom:24px;">Categorias</h2>
    <div class="categories-row">
        <?php if ($categorias && count($categorias)): ?>
            <?php foreach ($categorias as $cat): ?>
                <a href="exibirCategoria.php?categoria=<?= urlencode($cat['nome']) ?>" class="product-link" style="text-decoration:none; color:inherit;">
                    <div class="product-card category-card">
                        <img src="../public/uploads/<?= $cat['imagem'] ? htmlspecialchars($cat['imagem']) : 'no-image.png' ?>"
                             alt="<?= htmlspecialchars($cat['nome']) ?>"
                             onerror="this.onerror=null;this.src='/Sistema-de-Vendas/public/uploads/no-image.png';"
                             style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
                        <h3><?= htmlspecialchars($cat['nome']) ?></h3>
                        <p style="color:#666; font-size:0.92em; margin:6px 0 0 0;">Confira produtos da categoria!</p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="margin:40px auto;text-align:center;color:#888;">Nenhuma categoria encontrada.</p>
        <?php endif; ?>
    </div>
</section>