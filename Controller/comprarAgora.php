<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DEBUG temporário (remova em produção)
file_put_contents('debug_comprarAgora.txt', print_r([
    'id_cliente' => $_SESSION['id_cliente'] ?? null,
    '_POST' => $_POST,
    'session' => $_SESSION
], true), FILE_APPEND);

require_once('../Model/conexaoBD.php');

// Verifica se está logado
if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../View/pagina_login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$id_produto = isset($_POST['id_produto']) ? (int)$_POST['id_produto'] : 0;
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

// Validação básica dos dados recebidos
if ($id_produto <= 0 || $quantidade <= 0) {
    // Dados inválidos, não processa compra
    unset($_SESSION['compra_pendente']);
    header("Location: ../View/index.php");
    exit();
}

// Buscar dados do cliente
$sql = "SELECT p.cpf, p.rg, p.dataNascimento, p.logradouro, p.numero, p.bairro, p.complemento, p.cidade, p.uf, p.cep
        FROM Pessoa p
        JOIN Cliente c ON p.ID_pessoa = c.ID_cliente
        WHERE c.ID_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($cpf, $rg, $dataNascimento, $logradouro, $numero, $bairro, $complemento, $cidade, $uf, $cep);
$stmt->fetch();
$stmt->close();

// Verifica se dados obrigatórios estão preenchidos
$camposObrigatorios = [$cpf, $rg, $dataNascimento, $logradouro, $numero, $bairro, $cidade, $uf, $cep];
$cadastroCompleto = true;
foreach ($camposObrigatorios as $campo) {
    if (empty($campo)) {
        $cadastroCompleto = false;
        break;
    }
}

if (!$cadastroCompleto) {
    // Sempre sobrescreve o valor anterior antes de salvar nova compra pendente
    unset($_SESSION['compra_pendente']);
    $_SESSION['compra_pendente'] = [
        'id_produto' => $id_produto,
        'quantidade' => $quantidade
    ];
    header("Location: ../View/completar_cadastro.php");
    exit();
} else {
    // Compra válida, continua para checkout
    $_SESSION['checkout'] = [
        'id_produto' => $id_produto,
        'quantidade' => $quantidade
    ];
    header("Location: ../View/checkout.php");
    exit();
}
?>