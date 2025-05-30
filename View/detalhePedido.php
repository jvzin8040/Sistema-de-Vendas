<?php
session_start();
include(__DIR__ . '/../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente'])) {
    echo "Você precisa estar logado para ver os detalhes do pedido.";
    exit;
}

// Exibe mensagem de pedido cancelado, se houver
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

if (!isset($_GET['id'])) {
    echo "Pedido não especificado.";
    exit;
}

$id_cliente = intval($_SESSION['id_cliente']);
$id_pedido = intval($_GET['id']);

// Buscar pedido no banco, incluindo o método de pagamento e parcelas
$sql = "SELECT * FROM Pedido WHERE ID_pedido = $id_pedido AND ID_cliente = $id_cliente";
$result = $conexao->query($sql);

if ($result && $result->num_rows > 0) {
    $pedido = $result->fetch_assoc();
} else {
    echo "Pedido não encontrado.";
    exit;
}

// Função para exibir o método de pagamento bonito
function nomeMetodoPagamento($metodo) {
    switch (strtolower(trim($metodo ?? ''))) {
        case 'credito':
        case 'cartao_credito':
        case 'cartão de crédito':
        case 'cartao de credito':
        case 'cartao':
            return 'Cartão de Crédito';
        case 'debito':
        case 'cartao_debito':
        case 'cartão de débito':
        case 'cartao de debito':
            return 'Cartão de Débito';
        case 'pix':
            return 'Pix';
        case 'boleto':
            return 'Boleto Bancário';
        default:
            return 'Não informado';
    }
}

// Buscar os produtos do pedido
$sqlItens = "SELECT ip.quantidade, ip.preco_unitario, p.nome, p.imagem
             FROM item_pedido ip
             INNER JOIN Produto p ON ip.ID_produto = p.ID_produto
             WHERE ip.ID_pedido = $id_pedido";
$resultItens = $conexao->query($sqlItens);
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
    <style>
        body {
            background-color: #820AD1 !important;
            min-height: 100vh;
            margin: 0;
        }
        .pedido-resumo {
            max-width: 500px;
            margin: 40px auto;
            background: #faf7fd;
            border-radius: 12px;
            box-shadow: 0 2px 12px #a17bf73a;
            padding: 35px 30px;
        }
        .pedido-resumo h2 {
            margin-top: 0;
            color: #630dbb;
        }
        .mensagem-feedback-amarelo {
            margin-bottom: 16px;
            padding: 12px;
            border-radius: 6px;
            font-weight: bold;
            background: #fffbe5;
            color: #b37a00;
            border: 1px solid #ffe58f;
            text-align: center;
        }
        .pedido-resumo dl {
            margin: 0;
        }
        .pedido-resumo dt {
            font-weight: bold;
            margin-top: 12px;
        }
        .pedido-resumo dd {
            margin: 0 0 12px 0;
        }
        .botoes-pedido {
            margin-top: 20px;
            text-align: center;
        }
        .pedido-voltar {
            display: inline-block;
            margin-left: 10px;
            margin-top: 15px;
            padding: 14px 36px; /* MAIOR */
            background: #630dbb;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.15em;
            letter-spacing: 1px;
        }
        .pedido-voltar:hover {
            background: #4b098e;
        }
        .pedido-cancelar {
            display: inline-block;
            margin-right: 10px;
            margin-top: 15px;
            padding: 8px 9px; /* MENOR */
            background: #ff4444;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 1em;
            letter-spacing: 0.5px;
        }
        .pedido-cancelar:hover {
            background: #c11c1c;
        }
        .produtos-lista {
            margin-top: 30px;
        }
        .produto-item {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            background: #fff;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 1px 5px #a17bf71c;
        }
        .produto-item img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 16px;
            background: #f3e7ff;
        }
        .produto-info {
            color: #3d2061;
        }
        .produto-info span {
            display: inline-block;
            min-width: 120px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="pedido-resumo">
    <?php if (!empty($msg)): ?>
        <div class="mensagem-feedback-amarelo"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <h2>Resumo do Pedido #<?= $pedido['ID_pedido'] ?></h2>
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
            <dd><?= intval($pedido['parcelas']) ?>x sem juros</dd>
        <?php endif; ?>
        <dt>Quantidade de Produtos:</dt>
        <dd><?= $pedido['qtdDeProduto'] ?? '' ?></dd>
        <dt>Preço Unitário:</dt>
        <dd>R$ <?= isset($pedido['precoUnitario']) ? number_format($pedido['precoUnitario'], 2, ',', '.') : '' ?></dd>
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
                        <span>Qtd: <?= $item['quantidade'] ?? '' ?></span>
                        <span>Preço unitário: R$ <?= isset($item['preco_unitario']) ? number_format($item['preco_unitario'], 2, ',', '.') : '' ?></span>
                        <span>Subtotal: R$ <?= (isset($item['quantidade'], $item['preco_unitario'])) ? number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.') : '' ?></span>
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
<?php include 'footer.php'; ?>
</body>
</html>