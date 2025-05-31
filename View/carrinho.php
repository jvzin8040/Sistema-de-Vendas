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
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body.carrinho-bg {
            background: #820AD1;
            min-height: 100vh;
        }
        .pagina-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .cart-container {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
            min-height: 0;
            border-radius: 16px;
            box-shadow: 1px 1px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 900px;
            width: 100%;
            margin: 30px auto 20px auto;
            background-color: #ffffff;
        }
        footer {
            margin-top: auto;
        }
        /* Correção do layout do produto e botões */
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 12px;
            border-bottom: 1px solid #eee;
            background: #f7f3ff;
            border-radius: 10px;
            margin-bottom: 14px;
            box-shadow: 0 1px 5px #a17bf71c;
        }
        .cart-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            background: #ece6fa;
            margin-right: 16px;
            box-shadow: 0 1px 6px #a17bf722;
        }
        .item-details {
            flex: 2;
            min-width: 0;
            margin-right: 10px;
        }
        .item-details h3 {
            margin: 0 0 10px 0;
            font-size: 1.1em;
            color: #6C63FF;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .item-details div {
            font-size: 1em;
            color: #3d2061;
        }
        .item-quantity {
            flex: 0.7;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.98em;
            color: #444;
        }
        .item-quantity span:first-child {
            color: #999;
        }
        .item-subtotal {
            flex: 1;
            text-align: right;
            margin-right: 18px;
        }
        .item-subtotal strong {
            color: #6C63FF;
            font-size: 1.05em;
        }
        .cart-item form {
            margin: 0;
        }
        .remove-btn {
            background-color: #ff4444;
            color: white;
            border: none;
            padding: 7px 14px;
            border-radius: 5px;
            font-size: 0.98em;
            font-weight: bold;
            cursor: pointer;
            box-shadow: none;
            transition: background 0.17s;
        }
        .remove-btn:hover {
            background: #b30909;
        }
        @media (max-width: 700px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 14px 6px;
            }
            .cart-item img {
                margin: 0 0 10px 0;
            }
            .item-details, .item-quantity, .item-subtotal {
                margin: 0 0 7px 0;
                text-align: left;
            }
            .item-quantity {
                flex-direction: row;
                gap: 4px;
            }
        }
    </style>
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