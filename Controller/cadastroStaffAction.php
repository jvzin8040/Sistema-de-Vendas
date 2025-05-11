<?php
session_start();
require_once('conexaoBD.php');

// Receber os dados do formulário
$nome = $_POST['nome'];
$registro = $_POST['registro'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

// Validação de senha
if ($senha !== $confirmar_senha) {
    echo "<script>alert('As senhas não coincidem.'); window.history.back();</script>";
    exit();
}

// Verificar se registro já existe
$stmtVerifica = $conexao->prepare("SELECT registro FROM Funcionario WHERE registro = ?");
$stmtVerifica->bind_param("s", $registro);
$stmtVerifica->execute();
$resultadoVerifica = $stmtVerifica->get_result();

if ($resultadoVerifica->num_rows > 0) {
    echo "<script>alert('Erro: Registro já existente no sistema.'); window.history.back();</script>";
    $stmtVerifica->close();
    $conexao->close();
    exit();
}
$stmtVerifica->close();

// Criptografar senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir na tabela Pessoa (sem senha)
$stmtPessoa = $conexao->prepare("INSERT INTO Pessoa (nome, telefone) VALUES (?, ?)");
$stmtPessoa->bind_param("ss", $nome, $telefone);

if ($stmtPessoa->execute()) {
    $idPessoa = $stmtPessoa->insert_id;

    // Inserir na tabela Funcionario
    $cargo = "Funcionário"; // Valor padrão
    $salario = 0.0;
    $dataAdmissao = date('Y-m-d');

    $stmtFuncionario = $conexao->prepare("INSERT INTO Funcionario (ID_funcionario, cargo, salario, dataAdmissao, registro, senha) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtFuncionario->bind_param("isdsss", $idPessoa, $cargo, $salario, $dataAdmissao, $registro, $senha_hash);

    if ($stmtFuncionario->execute()) {
        echo "<script>alert('Funcionário cadastrado com sucesso!'); window.location.href='../View/area_restrita.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar funcionário.'); window.history.back();</script>";
    }

    $stmtFuncionario->close();
} else {
    echo "<script>alert('Erro ao cadastrar pessoa.'); window.history.back();</script>";
}

$stmtPessoa->close();
$conexao->close();
?>
