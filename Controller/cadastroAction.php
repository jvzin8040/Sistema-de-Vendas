<?php
session_start();
require_once('conexaoBD.php');

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

// Verifica se as senhas coincidem
if ($senha !== $confirmar_senha) {
    echo "<script>alert('As senhas não coincidem!'); window.location.href='../View/criar_conta.php';</script>";
    exit;
}

// Verifica se o e-mail já existe
$stmt = $conexao->prepare("SELECT ID_pessoa FROM pessoa WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('E-mail existente já cadastrado no sistema!'); window.location.href='../View/criar_conta.php';</script>";
    $stmt->close();
    exit;
}
$stmt->close();

// Hash da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserção no banco
$stmt = $conexao->prepare("INSERT INTO pessoa (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nome, $email, $telefone, $senha_hash);

if ($stmt->execute()) {
    echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='../View/pagina_login.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar!'); window.location.href='../View/criar_conta.php';</script>";
}

$stmt->close();
$conexao->close();
?>
