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


$sql = "SELECT * FROM Pedido WHERE ID_pedido = $id_pedido AND ID_cliente = $id_cliente";
$result = $conexao->query($sql);

if ($result && $result->num_rows > 0) {
    $pedido = $result->fetch_assoc();
} else {
    echo "Pedido não encontrado.";
    exit;
}

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

$sqlItens = "SELECT ip.quantidade, ip.preco_unitario, p.nome, p.imagem
             FROM item_pedido ip
             INNER JOIN Produto p ON ip.ID_produto = p.ID_produto
             WHERE ip.ID_pedido = $id_pedido";
$resultItens = $conexao->query($sqlItens);

$numProdutos = $resultItens ? $resultItens->num_rows : 0;

$parcelas = isset($pedido['parcelas']) ? intval($pedido['parcelas']) : 1;
$precoTotal = isset($pedido['precoTotal']) ? floatval($pedido['precoTotal']) : 0.0;
$valorParcela = ($parcelas > 1 && $precoTotal > 0) ? $precoTotal / $parcelas : 0;