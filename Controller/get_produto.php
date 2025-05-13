<?php
require_once '../controller/conexaoBD.php';

if (!isset($_GET['id'])) { // Corrigido para 'id'
    http_response_code(400);
    echo json_encode(['erro' => 'ID não fornecido']);
    exit;
}

$id = intval($_GET['id']); // Corrigido para 'id'
$sql = "SELECT ID_produto, nome, descricao, preco, qtdEstoque, ID_categoria FROM Produto WHERE ID_produto = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    http_response_code(404);
    echo json_encode(['erro' => 'Produto não encontrado']);
}

$stmt->close();
$conexao->close();
