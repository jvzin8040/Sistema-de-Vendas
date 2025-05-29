<?php
session_start();
require_once('../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../View/pagina_login.php");
    exit();
}

if (!isset($_POST['id_pedido'])) {
    echo "Pedido não especificado!";
    exit();
}

$id_pedido = intval($_POST['id_pedido']);
$id_cliente = intval($_SESSION['id_cliente']);

// Atualiza o status apenas se o pedido pertence ao cliente e está pendente
$sql = "UPDATE Pedido SET status = 'Cancelado' WHERE ID_pedido = ? AND ID_cliente = ? AND status = 'Pendente'";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $id_pedido, $id_cliente);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $msg = "Pedido cancelado com sucesso!";
} else {
    $msg = "Não foi possível cancelar este pedido!";
}
$stmt->close();

// Redireciona para a tela de detalhes do pedido na View!
header("Location: ../View/detalhePedido.php?id=$id_pedido&msg=" . urlencode($msg));
exit();
?>