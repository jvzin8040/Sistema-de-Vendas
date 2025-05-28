<?php
session_start();
require_once('../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../View/pagina_login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];

// Receba os dados do POST
$cpf         = $_POST['CPF'] ?? '';
$rg          = $_POST['RG'] ?? '';
$dataNasc    = $_POST['DataNascimento'] ?? '';
$logradouro  = $_POST['Logradouro'] ?? '';
$numero      = $_POST['Numero'] ?? '';
$bairro      = $_POST['Bairro'] ?? '';
$complemento = $_POST['Complemento'] ?? '';
$cep         = $_POST['CEP'] ?? '';
$cidade      = $_POST['Cidade'] ?? '';
$estado      = $_POST['Estado'] ?? '';

// Validação básica dos campos obrigatórios
$camposObrigatorios = [$cpf, $rg, $dataNasc, $logradouro, $numero, $bairro, $cidade, $estado, $cep];
$cadastroCompleto = true;
foreach ($camposObrigatorios as $campo) {
    if (empty($campo)) {
        $cadastroCompleto = false;
        break;
    }
}

if (!$cadastroCompleto) {
    // Se algum campo obrigatório estiver vazio, retorne para o formulário com mensagem de erro
    $_SESSION['erro_cadastro'] = "Preencha todos os campos obrigatórios!";
    header("Location: ../View/completar_cadastro.php");
    exit();
}

// Atualize os dados na tabela Pessoa
$sql = "UPDATE Pessoa SET 
    cpf = ?, rg = ?, dataNascimento = ?, logradouro = ?, numero = ?, bairro = ?, complemento = ?, cep = ?, cidade = ?, uf = ?
    WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param(
    "ssssisssssi",
    $cpf, $rg, $dataNasc, $logradouro, $numero, $bairro, $complemento, $cep, $cidade, $estado, $id_cliente
);

if ($stmt->execute()) {
    $stmt->close();

    // Após salvar o cadastro, redirecione conforme intenção de compra
    if (isset($_SESSION['compra_pendente'])) {
        $id_produto = (int)$_SESSION['compra_pendente']['id_produto'];
        $quantidade = (int)$_SESSION['compra_pendente']['quantidade'];
        unset($_SESSION['compra_pendente']);

        // Só redireciona se id_produto for válido
        if ($id_produto > 0 && $quantidade > 0) {
            header("Location: ../View/checkout.php?id_produto=$id_produto&quantidade=$quantidade");
            exit();
        }
    }
    header("Location: ../View/index.php");
    exit();
} else {
    // Em caso de erro no UPDATE
    $_SESSION['erro_cadastro'] = "Erro ao atualizar cadastro. Tente novamente.";
    header("Location: ../View/completar_cadastro.php");
    exit();
}
?>