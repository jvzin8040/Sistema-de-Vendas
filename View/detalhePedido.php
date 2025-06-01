<?php
require_once('../Controller/detalhePedidoController.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resumo do Pedido #<?= $pedido['ID_pedido'] ?></title>
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
    <link rel="stylesheet" href="css/histPedido.css">
    <link rel="stylesheet" href="css/detalhePedido.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="pedido-bg-container">
    <h1 class="pedido-main-title">Resumo do Pedido #<?= $pedido['ID_pedido'] ?></h1>
    <div class="pedido-resumo-box">
        <?php if (!empty($msg)): ?>
            <div class="mensagem-feedback-amarelo"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <dl>
            <dt>Status:</dt>
            <dd><?= ucfirst($pedido['status'] ?? '') ?></dd>
            <dt>Data:</dt>
            <dd><?= !empty($pedido['data']) ? date("d/m/Y", strtotime($pedido['data'])) : '' ?></dd>
            <dt>Método de Pagamento:</dt>
            <dd><?= nomeMetodoPagamento($pedido['metodoPagamento'] ?? '') ?></dd>
            <?php if (
                isset($pedido['metodoPagamento'], $pedido['parcelas']) &&
                (
                    strtolower($pedido['metodoPagamento']) === 'cartao' ||
                    strtolower($pedido['metodoPagamento']) === 'cartao_credito' ||
                    strtolower($pedido['metodoPagamento']) === 'credito' ||
                    strtolower($pedido['metodoPagamento']) === 'cartão de crédito'
                ) &&
                intval($pedido['parcelas']) > 1
            ): ?>
                <dt>Parcelamento:</dt>
                <dd>
                    <?= intval($pedido['parcelas']) ?>x sem juros 
                    de R$ <?= number_format($valorParcela, 2, ',', '.') ?>
                </dd>
            <?php endif; ?>
            <dt>Quantidade de Produtos:</dt>
            <dd><?= $pedido['qtdDeProduto'] ?? '' ?></dd>
            <?php if ($numProdutos === 1): ?>
                <dt>Preço Unitário:</dt>
                <dd>R$ <?= isset($pedido['precoUnitario']) ? number_format($pedido['precoUnitario'], 2, ',', '.') : '' ?></dd>
            <?php endif; ?>
            <dt>Preço Total:</dt>
            <dd>R$ <?= isset($pedido['precoTotal']) ? number_format($pedido['precoTotal'], 2, ',', '.') : '' ?></dd>
        </dl>
        <div class="produtos-lista">
            <h3 style="color:#630dbb; margin-bottom:12px;">Produtos deste pedido:</h3>
            <?php if ($resultItens && $resultItens->num_rows > 0): ?>
                <?php while ($item = $resultItens->fetch_assoc()): ?>
                    <div class="produto-item">
                        <?php
                            $img = (!empty($item['imagem'])) ? $item['imagem'] : 'no-image.png';
                        ?>
                        <img src="../public/uploads/<?= htmlspecialchars($img ?? '') ?>" alt="<?= htmlspecialchars($item['nome'] ?? '') ?>">
                        <div class="produto-info">
                            <strong><?= htmlspecialchars($item['nome'] ?? '') ?></strong><br>
                            <span class="quantidade">Qtd: <?= $item['quantidade'] ?? '' ?></span><br>
                            <span class="preco">Preço unitário: R$ <?= isset($item['preco_unitario']) ? number_format($item['preco_unitario'], 2, ',', '.') : '' ?></span><br>
                            <span class="subtotal">Subtotal: <b>R$ <?= (isset($item['quantidade'], $item['preco_unitario'])) ? number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.') : '' ?></b></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color:#a00;">Nenhum produto encontrado para este pedido.</p>
            <?php endif; ?>
        </div>
        <div class="botoes-pedido">
            <?php if (strtolower($pedido['status']) === 'pendente'): ?>
                <form action="../Controller/cancelarPedido.php" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja cancelar este pedido?');">
                    <input type="hidden" name="id_pedido" value="<?= $pedido['ID_pedido'] ?>">
                    <button type="submit" class="pedido-cancelar">Cancelar Pedido</button>
                </form>
            <?php endif; ?>
            <a class="pedido-voltar" href="historicoPedido.php">Voltar ao histórico</a>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>