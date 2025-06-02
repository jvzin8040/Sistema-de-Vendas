<?php
session_start();
require_once '../Model/Produto.php';
require_once '../Model/conexaoBD.php';

if (!isset($_SESSION['id_cliente']) || empty($_SESSION['checkout_multi'])) {
    header('Location: carrinho.php'); exit();
}

$id_cliente = $_SESSION['id_cliente'];
$ids = array_keys($_SESSION['checkout_multi']);
$produtos = [];
$total = 0;

foreach ($ids as $id) {
    $produto = Produto::buscarPorId2($id);
    if ($produto) {
        $produto['quantidade'] = $_SESSION['checkout_multi'][$id];
        $produto['subtotal'] = $produto['preco'] * $produto['quantidade'];
        $produto['imagem'] = isset($produto['imagem']) && $produto['imagem'] ? $produto['imagem'] : 'no-image.png';
        $produtos[] = $produto;
        $total += $produto['subtotal'];
    }
}

$sql = "SELECT nome, sobrenome, cpf, cnpj, rg, dataNascimento, logradouro, numero, bairro, complemento, cidade, uf, cep
        FROM Pessoa WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($nome, $sobrenome, $cpf, $cnpj, $rg, $dataNascimento,
    $logradouro, $numero, $bairro, $complemento, $cidade, $uf, $cep);
$stmt->fetch();
$stmt->close();