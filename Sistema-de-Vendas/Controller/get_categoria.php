<?php
require_once('../Model/Produto.php');
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $categoria = Produto::buscarCategoriaPorId($id);
    if ($categoria) {
        echo json_encode($categoria);
        exit;
    }
}

http_response_code(404);
echo json_encode(['erro' => 'Categoria não encontrada']);
exit;