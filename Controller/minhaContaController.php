<?php
session_start();
require_once(__DIR__ . '/../Model/Pessoa.php');

// Verifica se está logado
if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../View/pagina_login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome'           => trim($_POST['nome'] ?? ''),
        'sobrenome'      => trim($_POST['sobrenome'] ?? ''),
        'email'          => trim($_POST['email'] ?? ''),
        'telefone'       => trim($_POST['telefone'] ?? ''),
        'rg'             => trim($_POST['rg'] ?? ''),
        'cpf'            => trim($_POST['cpf'] ?? ''),
        'cnpj'           => trim($_POST['cnpj'] ?? ''),
        'dataNascimento' => trim($_POST['dataNascimento'] ?? ''),
        'logradouro'     => trim($_POST['logradouro'] ?? ''),
        'numero'         => trim($_POST['numero'] ?? ''),
        'bairro'         => trim($_POST['bairro'] ?? ''),
        'complemento'    => trim($_POST['complemento'] ?? ''),
        'cidade'         => trim($_POST['cidade'] ?? ''),
        'cep'            => trim($_POST['cep'] ?? ''),
        'uf'             => trim($_POST['uf'] ?? ''),
    ];

    $ok = Pessoa::atualizarDados($id_cliente, $dados);

    if ($ok) {
        $_SESSION['mensagem'] = "Dados atualizados com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar dados!";
    }
}

// Redireciona sempre para a view após processar o POST
header("Location: ../View/minhaConta.php");
exit();