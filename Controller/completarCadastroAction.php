<?php
session_start();
require_once('../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../View/pagina_login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];


$sql_busca = "SELECT nome, sobrenome FROM Pessoa WHERE ID_pessoa = ?";
$stmt_busca = $conexao->prepare($sql_busca);
$stmt_busca->bind_param("i", $id_cliente);
$stmt_busca->execute();
$stmt_busca->bind_result($nome_atual, $sobrenome_atual);
$stmt_busca->fetch();
$stmt_busca->close();


$nome        = $nome_atual; 
$sobrenome   = $_POST['Sobrenome'] ?? '';
$cpf         = $_POST['CPF'] ?? '';
$cnpj        = $_POST['CNPJ'] ?? '';
$rg          = $_POST['RG'] ?? '';
$dataNasc    = $_POST['DataNascimento'] ?? '';
$logradouro  = $_POST['Logradouro'] ?? '';
$numero      = $_POST['Numero'] ?? '';
$bairro      = $_POST['Bairro'] ?? '';
$complemento = $_POST['Complemento'] ?? '';
$cep         = $_POST['CEP'] ?? '';
$cidade      = $_POST['Cidade'] ?? '';
$estado      = $_POST['Estado'] ?? '';


$camposObrigatorios = [$sobrenome, $cpf, $rg, $dataNasc, $logradouro, $numero, $bairro, $cidade, $estado, $cep];
$cadastroCompleto = true;
foreach ($camposObrigatorios as $campo) {
    if (empty($campo)) {
        $cadastroCompleto = false;
        break;
    }
}

if (!$cadastroCompleto) {
    $_SESSION['erro_cadastro'] = "Preencha todos os campos obrigatórios!";
    header("Location: ../View/completar_cadastro.php");
    exit();
}


$sql = "UPDATE Pessoa SET 
    sobrenome = ?, cpf = ?, cnpj = ?, rg = ?, dataNascimento = ?, logradouro = ?, numero = ?, bairro = ?, complemento = ?, cep = ?, cidade = ?, uf = ?
    WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param(
    "ssssssisssssi",
    $sobrenome, $cpf, $cnpj, $rg, $dataNasc, $logradouro, $numero, $bairro, $complemento, $cep, $cidade, $estado, $id_cliente
);

if ($stmt->execute()) {
    $stmt->close();

    if (isset($_SESSION['compra_pendente'])) {
        $_SESSION['checkout'] = $_SESSION['compra_pendente'];
        unset($_SESSION['compra_pendente']);

        header("Location: ../View/checkout.php");
        exit();
    }
    header("Location: ../View/index.php");
    exit();
} else {
    $_SESSION['erro_cadastro'] = "Erro ao atualizar cadastro. Tente novamente.";
    header("Location: ../View/completar_cadastro.php");
    exit();
}
?>