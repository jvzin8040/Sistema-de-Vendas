<?php
require_once('../Model/Contato.php');
require_once('../Model/Pessoa.php');

$title = "Mensagens de Contato - EID Store";

function listarMensagensDeContato() {
    include(__DIR__ . '/../Model/conexaoBD.php');
    $sql = "SELECT c.ID_contato, c.assunto, c.mensagem, c.data_envio, p.nome, p.email
            FROM Contato c
            JOIN Pessoa p ON c.ID_pessoa = p.ID_pessoa
            ORDER BY c.data_envio DESC";
    $result = $conexao->query($sql);

    $mensagens = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mensagens[] = $row;
        }
    }
    $conexao->close();
    return $mensagens;
}

$mensagens = listarMensagensDeContato();