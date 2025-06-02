<?php
require_once '../Model/Produto.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'ID não fornecido']);
    exit;
}

$id = intval($_GET['id']);
$produto = Produto::buscarPorId2($id);

if ($produto) {
    echo json_encode($produto);
} else {
    http_response_code(404);
    echo json_encode(['erro' => 'Produto não encontrado']);
}