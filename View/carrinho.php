<?php
session_start();
require_once '../Model/Produto.php';

$carrinho = $_SESSION['carrinho'] ?? [];
$produtos = [];
$total = 0.0;

if ($carrinho) {
    foreach ($carrinho as $id => $qtd) {
        $produto = Produto::buscarPorId2($id);
        if ($produto) {
            $produto['quantidade'] = $qtd;
            $produto['subtotal'] = $produto['preco'] * $qtd;
            $produto['imagem'] = isset($produto['imagem']) && $produto['imagem'] ? $produto['imagem'] : 'no-image.png';
            $produtos[] = $produto;
            $total += $produto['subtotal'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/carrinho.css">
</head>
<body class="carrinho-bg">
<div class="pagina-wrapper">
    <?php include 'header.php'; ?>
    <div class="cart-container">
        <h1>Carrinho de Compras</h1>
        <?php if (empty($produtos)): ?>
            <p style="text-align:center; color:#a17bf7; font-weight:500;">Seu carrinho está vazio.</p>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($produtos as $produto): ?>
                    <div class="cart-item">
                        <img src="../public/uploads/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                        <div class="item-details">
                            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                            <div>Preço unitário: <strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong></div>
                        </div>
                        <div class="item-quantity">
                            <span>Qtd:</span>
                            <span><?= $produto['quantidade'] ?></span>
                        </div>
                        <div class="item-subtotal">
                            <div>Subtotal:</div>
                            <strong>R$ <?= number_format($produto['subtotal'], 2, ',', '.') ?></strong>
                        </div>
                        <form action="../Controller/remover_do_carrinho.php" method="post">
                            <input type="hidden" name="id_produto" value="<?= $produto['ID_produto'] ?>">
                            <button type="submit" class="remove-btn" title="Remover do carrinho">Remover</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cart-summary summary-details">
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                </div>
                <form action="../Controller/finalizar_carrinho.php" method="post">
                    <button type="submit" class="checkout-btn">Finalizar Compra</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="espaco-flex"></div>
    </div>
    <?php include 'footer.php'; ?>
</div>
</body>
</html>