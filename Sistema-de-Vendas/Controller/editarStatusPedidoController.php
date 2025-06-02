<?php
session_start();
include(__DIR__ . '/../Model/conexaoBD.php');

function esc($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

$mensagem = '';
$erro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['pedido_id'], $_POST['novo_status'])) {
    $pedido_id = intval($_POST['pedido_id']);
    $novo_status = $_POST['novo_status'];
    $statuses = ['Pendente', 'Concluído', 'Cancelado'];

    if (!in_array($novo_status, $statuses)) {
        $erro = "Status inválido!";
    } else {
        $stmt = $conexao->prepare("UPDATE Pedido SET status = ? WHERE ID_pedido = ?");
        $stmt->bind_param("si", $novo_status, $pedido_id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $mensagem = "Status do pedido atualizado com sucesso!";
            } else {
                $erro = "Nenhum pedido atualizado (ID pode não existir).";
            }
        } else {
            $erro = "Erro ao atualizar status: " . $stmt->error;
        }
        $stmt->close();
    }
}


$sql = "SELECT p.ID_pedido, p.data, p.status, p.precoTotal, p.qtdDeProduto, c.ID_cliente, pes.nome, pes.sobrenome
        FROM Pedido p
        JOIN Cliente c ON p.ID_cliente = c.ID_cliente
        JOIN Pessoa pes ON c.ID_cliente = pes.ID_pessoa
        ORDER BY p.ID_pedido DESC";
$result = $conexao->query($sql);

$pedidos = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $pedidos[] = $row;
    }
}
$statuses = ['Pendente', 'Concluído', 'Cancelado'];