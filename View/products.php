<?php
require_once(__DIR__ . '/../Model/Produto.php');
$produtos = Produto::listarTodos();
define('BASE_URL', '/tcc/V9/Sistema-de-Vendas'); // alterar se necessário
?>

<!-- Produtos em destaque -->
<section class="products product-list">
    <?php if (empty($produtos)): ?>
        <p>Nenhum produto cadastrado.</p>
    <?php else: ?>
        <?php foreach ($produtos as $produto): ?>
            <a href="exibirProduto.php?id=<?php echo $produto['ID_produto']; ?>" class="product-link" style="text-decoration: none; color: inherit; display: block;">
                <div class="product-card">
                    <img
                        src="<?php
                                echo !empty($produto['imagem'])
                                    ? BASE_URL . '/public/uploads/' . htmlspecialchars($produto['imagem'])
                                    : BASE_URL . '/public/uploads/no-image.png';
                                ?>"
                        alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                        style="max-width: 100%; height: auto;">
                    <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
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
</section>