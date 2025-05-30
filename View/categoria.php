<?php
require_once(__DIR__ . '/../Model/Produto.php');
$categorias = Produto::listarCategorias();
?>

<!-- Categorias -->
<section class="categories" id="categorias">
    <h2>Categorias</h2>
    <div class="linha">
        <?php if ($categorias && count($categorias)): ?>
            <?php foreach ($categorias as $cat): ?>
                <div class="category">
                    <a href="exibirCategoria.php?categoria=<?= urlencode($cat['nome']) ?>" style="text-decoration:none; color:inherit;">
                        <img src="images/<?= strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $cat['nome'])) ?>.png" alt="<?= htmlspecialchars($cat['nome']) ?>" onerror="this.onerror=null;this.src='images/no-image.png';">
                        <h3><?= htmlspecialchars($cat['nome']) ?></h3>
                        <p>Confira produtos da categoria <?= htmlspecialchars($cat['nome']) ?>!</p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma categoria encontrada.</p>
        <?php endif; ?>
    </div>
</section>