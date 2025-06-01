<?php
session_start();
require_once('../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../View/pagina_login.php");
    exit();
}

$id_pessoa = $_SESSION['id_cliente'];

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
$id_produto  = $_POST['id_produto'] ?? '';
$quantidade  = $_POST['quantidade'] ?? '';
$metodo_pagamento = $_POST['metodo_pagamento'] ?? 'indefinido'; 
$parcelas = isset($_POST['parcelas']) ? (int)$_POST['parcelas'] : 1; 


$sql = "UPDATE Pessoa SET
    nome = ?, sobrenome = ?, rg = ?, cpf = ?, cnpj = ?, dataNascimento = ?, logradouro = ?, numero = ?, bairro = ?, complemento = ?, cidade = ?, uf = ?, cep = ?
    WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param(
    "sssssssssssssi",
    $nome, $sobrenome, $rg, $cpf, $cnpj, $dataNasc, $logradouro, $numero, $bairro, $complemento, $cidade, $uf, $cep, $id_pessoa
);
$stmt->execute();
$stmt->close();


$sql = "SELECT ID_cliente FROM Cliente WHERE ID_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_pessoa);
$stmt->execute();
$stmt->bind_result($id_cliente);
$stmt->fetch();
$stmt->close();

if (!$id_cliente) {
   
    $sql = "INSERT INTO Cliente (ID_cliente) VALUES (?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_pessoa);
    $stmt->execute();
    $stmt->close();
    $id_cliente = $id_pessoa;
}


$sql_prod = "SELECT preco, qtdEstoque FROM Produto WHERE ID_produto = ?";
$stmt_prod = $conexao->prepare($sql_prod);
$stmt_prod->bind_param("i", $id_produto);
$stmt_prod->execute();
$stmt_prod->bind_result($preco_unit, $estoque_atual);
$stmt_prod->fetch();
$stmt_prod->close();

$preco_total = $preco_unit * $quantidade;


if ($quantidade > $estoque_atual) {
    die("Quantidade solicitada maior que o estoque disponível!");
}


$sql_pedido = "INSERT INTO Pedido (data, status, metodoPagamento, parcelas, qtdDeProduto, precoUnitario, precoTotal, ID_cliente)
               VALUES (NOW(), 'Pendente', ?, ?, ?, ?, ?, ?)";
$stmt_pedido = $conexao->prepare($sql_pedido);

$stmt_pedido->bind_param("siiddi", $metodo_pagamento, $parcelas, $quantidade, $preco_unit, $preco_total, $id_cliente);
$stmt_pedido->execute();


$id_pedido = $conexao->insert_id;

$sql_item = "INSERT INTO item_pedido (ID_pedido, ID_produto, quantidade, preco_unitario)
             VALUES (?, ?, ?, ?)";
$stmt_item = $conexao->prepare($sql_item);
$stmt_item->bind_param("iiid", $id_pedido, $id_produto, $quantidade, $preco_unit);
$stmt_item->execute();
$stmt_item->close();

$sql_estoque = "UPDATE Produto SET qtdEstoque = qtdEstoque - ? WHERE ID_produto = ?";
$stmt_estoque = $conexao->prepare($sql_estoque);
$stmt_estoque->bind_param("ii", $quantidade, $id_produto);
$stmt_estoque->execute();
$stmt_estoque->close();

$stmt_pedido->close();

header("Location: ../View/pedido_concluido.php");
exit();
?>