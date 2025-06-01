<?php
session_start();
require_once('../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['checkout'])) {
    header("Location: pagina_login.php"); 
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$id_produto = $_SESSION['checkout']['id_produto'];
$quantidade = $_SESSION['checkout']['quantidade'];

$sql_prod = "SELECT nome, preco, imagem FROM Produto WHERE ID_produto = ?";
$stmt_prod = $conexao->prepare($sql_prod);
$stmt_prod->bind_param("i", $id_produto);
$stmt_prod->execute();
$stmt_prod->bind_result($produto_nome, $produto_preco, $produto_imagem);
$stmt_prod->fetch();
$stmt_prod->close();

if ($produto_imagem && trim($produto_imagem) !== '') {
    $img_src = '../public/uploads/' . htmlspecialchars($produto_imagem);
} else {
    $img_src = '../public/uploads/no-image.png';
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

$title = "EID Store";
$total = $produto_preco * $quantidade;