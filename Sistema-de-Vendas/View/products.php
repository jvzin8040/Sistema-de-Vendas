<?php
require_once(__DIR__ . '/../Controller/productsController.php'); 
?>

<link rel="stylesheet" href="css/products-carousel.css">

<section class="products-carousel-container" id="produtos">
    <h2 class="products-title">Produtos</h2>
    <button class="carousel-btn prev-btn" aria-label="Anterior" style="display:none;">&#10094;</button>
    <div class="products-carousel">
        <?php if (empty($produtos)): ?>
            <p class="no-products-msg">Nenhum produto cadastrado.</p>
        <?php else: ?>
            <?php foreach ($produtos as $produto): ?>
                <a href="exibirProduto.php?id=<?php echo $produto['ID_produto']; ?>" class="product-link">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img
                                src="<?php
                                    echo !empty($produto['imagem'])
                                        ? '../public/uploads/' . htmlspecialchars($produto['imagem'])
                                        : '../public/uploads/no-image.png';
                                    ?>"
                                alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                            >
                        </div>
                        <h3 class="product-name-title"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        <p>
                            R$
                            <?php
                            echo isset($produto['preco']) && $produto['preco'] !== null
                                ? number_format((float)$produto['preco'], 2, ',', '.')
                                : "0,00";
                            ?>
                        </p>
                        <small>
                            Estoque:
                            <?php
                            echo isset($produto['qtdEstoque']) && $produto['qtdEstoque'] !== null
                                ? (int)$produto['qtdEstoque']
                                : "0";
                            ?>
                        </small>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <button class="carousel-btn next-btn" aria-label="Próximo" style="display:none;">&#10095;</button>
</section>

<script src="js/products-carousel.js"></script>