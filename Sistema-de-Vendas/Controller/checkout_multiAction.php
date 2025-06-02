<?php
session_start();
require_once('../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente']) || empty($_SESSION['checkout_multi'])) {
    header('Location: ../View/pagina_login.php');
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$carrinho = $_SESSION['checkout_multi'];

$nome        = $_POST['nome'] ?? '';
$sobrenome   = $_POST['sobrenome'] ?? '';
$rg          = $_POST['rg'] ?? '';
$cpf         = $_POST['cpf'] ?? '';
$cnpj        = $_POST['cnpj'] ?? '';
$dataNasc    = $_POST['dataNascimento'] ?? '';
$logradouro  = $_POST['logradouro'] ?? '';
$numero      = $_POST['numero'] ?? '';
$bairro      = $_POST['bairro'] ?? '';
$complemento = $_POST['complemento'] ?? '';
$cidade      = $_POST['cidade'] ?? '';
$cep         = $_POST['cep'] ?? '';
$uf          = $_POST['uf'] ?? '';
$metodo_pagamento = $_POST['metodo_pagamento'] ?? 'indefinido';
$parcelas = isset($_POST['parcelas']) ? (int)$_POST['parcelas'] : 1;

$sql = "UPDATE Pessoa SET
    nome = ?, sobrenome = ?, rg = ?, cpf = ?, cnpj = ?, dataNascimento = ?, logradouro = ?, numero = ?, bairro = ?, complemento = ?, cidade = ?, uf = ?, cep = ?
    WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param(
    "sssssssssssssi",
    $nome, $sobrenome, $rg, $cpf, $cnpj, $dataNasc, $logradouro, $numero, $bairro, $complemento, $cidade, $uf, $cep, $id_cliente
);
$stmt->execute();
$stmt->close();

$sql = "SELECT ID_cliente FROM Cliente WHERE ID_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($id_cliente_row);
$stmt->fetch();
$stmt->close();

if (!$id_cliente_row) {
    $sql = "INSERT INTO Cliente (ID_cliente) VALUES (?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $stmt->close();
}

$total = 0;
$itens = [];
foreach ($carrinho as $id_produto => $quantidade) {
    $sql_prod = "SELECT preco, qtdEstoque FROM Produto WHERE ID_produto = ?";
    $stmt_prod = $conexao->prepare($sql_prod);
    $stmt_prod->bind_param("i", $id_produto);
    $stmt_prod->execute();
    $stmt_prod->bind_result($preco_unit, $estoque_atual);
    $stmt_prod->fetch();
    $stmt_prod->close();

    if ($quantidade > $estoque_atual) {
        die("Estoque insuficiente para o produto ID $id_produto");
    }
    $total += $preco_unit * $quantidade;
    $itens[] = ['id_produto' => $id_produto, 'quantidade' => $quantidade, 'preco_unit' => $preco_unit];
}

$sql_pedido = "INSERT INTO Pedido (data, status, metodoPagamento, parcelas, qtdDeProduto, precoUnitario, precoTotal, ID_cliente)
               VALUES (NOW(), 'Pendente', ?, ?, ?, ?, ?, ?)";
$qtd_total = array_sum(array_column($itens, 'quantidade'));
$preco_unitario = count($itens) == 1 ? $itens[0]['preco_unit'] : 0; 
$stmt_pedido = $conexao->prepare($sql_pedido);
$stmt_pedido->bind_param("siiddi", $metodo_pagamento, $parcelas, $qtd_total, $preco_unitario, $total, $id_cliente);
$stmt_pedido->execute();
$id_pedido = $conexao->insert_id;

foreach ($itens as $item) {
    $sql_item = "INSERT INTO item_pedido (ID_pedido, ID_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)";
    $stmt_item = $conexao->prepare($sql_item);
    $stmt_item->bind_param("iiid", $id_pedido, $item['id_produto'], $item['quantidade'], $item['preco_unit']);
    $stmt_item->execute();
    $stmt_item->close();

    $sql_estoque = "UPDATE Produto SET qtdEstoque = qtdEstoque - ? WHERE ID_produto = ?";
    $stmt_estoque = $conexao->prepare($sql_estoque);
    $stmt_estoque->bind_param("ii", $item['quantidade'], $item['id_produto']);
    $stmt_estoque->execute();
    $stmt_estoque->close();
}

$stmt_pedido->close();

unset($_SESSION['carrinho'], $_SESSION['checkout_multi']);

header("Location: ../View/pedido_concluido.php");
exit();
?>