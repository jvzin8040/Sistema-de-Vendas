<?php
session_start();
require_once('../Model/Pessoa.php');
require_once('../Model/Contato.php');

$title = "Contato - EID Store";
$msg = "";

$id_pessoa = $_SESSION['id_pessoa'] ?? $_SESSION['id_cliente'] ?? null;
$pessoa = $id_pessoa ? Pessoa::buscarPessoaPorId($id_pessoa) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_pessoa) {
    $assunto = $_POST['subject'] ?? '';
    $mensagem = $_POST['message'] ?? '';
    if (Contato::salvar($id_pessoa, $assunto, $mensagem)) {
        $msg = "<div class='success-msg'>Mensagem enviada com sucesso!</div>";
    } else {
        $msg = "<div class='error-msg'>Erro ao enviar mensagem. Tente novamente.</div>";
    }
}