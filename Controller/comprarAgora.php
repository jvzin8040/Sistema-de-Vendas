<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

file_put_contents('debug_comprarAgora.txt', print_r([
    'id_cliente' => $_SESSION['id_cliente'] ?? null,
    '_POST' => $_POST,
    'session' => $_SESSION
], true), FILE_APPEND);

require_once('../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../View/pagina_login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$id_produto = isset($_POST['id_produto']) ? (int)$_POST['id_produto'] : 0;
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

if ($id_produto <= 0 || $quantidade <= 0) {
    unset($_SESSION['compra_pendente']);
    header("Location: ../View/index.php");
    exit();
}

// Agora busca também o sobrenome!
$sql = "SELECT sobrenome, cpf, rg, dataNascimento, logradouro, numero, bairro, complemento, cidade, uf, cep
        FROM Pessoa
        WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($sobrenome, $cpf, $rg, $dataNascimento, $logradouro, $numero, $bairro, $complemento, $cidade, $uf, $cep);
$stmt->fetch();
$stmt->close();

// Para depuração opcional:
file_put_contents('debug_camposObrigatorios.txt', print_r([
    'sobrenome' => $sobrenome,
    'cpf' => $cpf,
    'rg' => $rg,
    'dataNascimento' => $dataNascimento,
    'logradouro' => $logradouro,
    'numero' => $numero,
    'bairro' => $bairro,
    'cidade' => $cidade,
    'uf' => $uf,
    'cep' => $cep
], true), FILE_APPEND);

$camposObrigatorios = [$sobrenome, $cpf, $rg, $dataNascimento, $logradouro, $numero, $bairro, $cidade, $uf, $cep];
$cadastroCompleto = true;
foreach ($camposObrigatorios as $campo) {
    if (empty($campo)) {
        $cadastroCompleto = false;
        break;
    }
}

if (!$cadastroCompleto) {
    unset($_SESSION['compra_pendente']);
    $_SESSION['compra_pendente'] = [
        'id_produto' => $id_produto,
        'quantidade' => $quantidade
    ];
    header("Location: ../View/completar_cadastro.php");
    exit();
} else {
    $_SESSION['checkout'] = [
        'id_produto' => $id_produto,
        'quantidade' => $quantidade
    ];
    header("Location: ../View/checkout.php");
    exit();
}
?>