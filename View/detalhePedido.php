<?php
session_start();
include(__DIR__ . '/../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente'])) {
    echo "Você precisa estar logado para ver os detalhes do pedido.";
    exit;
} 

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

if (!isset($_GET['id'])) {
    echo "Pedido não especificado.";
    exit;
}

$id_cliente = intval($_SESSION['id_cliente']);
$id_pedido = intval($_GET['id']);

// Buscar pedido no banco
$sql = "SELECT * FROM Pedido WHERE ID_pedido = $id_pedido AND ID_cliente = $id_cliente";
$result = $conexao->query($sql);

if ($result && $result->num_rows > 0) {
    $pedido = $result->fetch_assoc();
} else {
    echo "Pedido não encontrado.";
    exit;
}

// Método de pagamento bonito
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

// Conta quantos produtos há
$numProdutos = $resultItens ? $resultItens->num_rows : 0;

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
        .pedido-bg-container {
            background-color: #820AD1;
            padding: 15px 3vw 40px 3vw;
            min-height: 110vh;
        }
        .pedido-main-title {
            font-size: 28px;
            color: #fff;
            text-align: center;
            letter-spacing: 1px;
            margin-bottom: 25px;
            text-shadow: 0 1px 6px #7d40c7a0;
        }
        .pedido-resumo-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 1px 1px 20px rgba(0,0,0,0.10);
            max-width: 700px;
            margin: 0 auto 2.2em auto;
            padding: 30px 30px 28px 30px;
        }
        .pedido-resumo-box h2 {
            margin-top: 0;
            color: #630dbb;
            font-size: 1.25em;
            margin-bottom: 18px;
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
        .pedido-resumo-box dl {
            margin: 0 0 18px 0;
        }
        .pedido-resumo-box dt {
            font-weight: bold;
            margin-top: 12px;
        }
        .pedido-resumo-box dd {
            margin: 0 0 12px 0;
        }
        .produtos-lista {
            margin-top: 18px;
        }
        .produto-item {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            background: #f8f4ff;
            border-radius: 8px;
            padding: 11px 10px;
            box-shadow: 0 1px 7px #a17bf71c;
        }
        .produto-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            background: #ece6fa;
            margin-right: 18px;
            box-shadow: 0 1px 6px #a17bf722;
        }
        .produto-info {
            color: #3d2061;
            font-size: 1em;
            flex: 1;
            min-width: 0;
        }
        .produto-info strong {
            color: #630dbb;
            font-size: 1.08em;
        }
        .produto-info .preco {
            color: #3d2061;
            font-size: 0.99em;
        }
        .produto-info .quantidade,
        .produto-info .subtotal {
            color: #444;
            font-size: 0.97em;
        }
        .produto-info .subtotal b {
            color: #6C63FF;
            font-size: 1.05em;
        }
        .botoes-pedido {
            margin-top: 26px;
            text-align: center;
        }
        .pedido-voltar {
            display: inline-block;
            margin-left: 10px;
            margin-top: 15px;
            padding: 14px 36px;
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
            padding: 8px 9px;
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
        @media (max-width: 700px) {
            .pedido-resumo-box {
                padding: 15px 3vw 14px 3vw;
            }
            .produto-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                padding: 10px 4px;
            }
        }
    </style>
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
                <dd><?= intval($pedido['parcelas']) ?>x sem juros</dd>
            <?php endif; ?>
            <dt>Quantidade de Produtos:</dt>
            <dd><?= $pedido['qtdDeProduto'] ?? '' ?></dd>
            <?php if ($numProdutos === 1): // Só mostra preço unitário se for um produto ?>
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