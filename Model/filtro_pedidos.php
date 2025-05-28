<?php
session_start();
include(__DIR__ . '/../Model/conexaoBD.php');

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

if (!isset($_SESSION['id_cliente'])) {
    echo "<li class='order-item'>Você precisa estar logado para ver seus pedidos.</li>";
    exit;
}

$id_cliente = $_SESSION['id_cliente'];

$dateRange = $_POST['dateRange'] ?? '';
$status = $_POST['status'] ?? 'todos';

$where = ["ID_cliente = $id_cliente"]; // <-- só pega os pedidos do cliente logado

if (!empty($dateRange)) {
    $datas = explode(" a ", $dateRange);
    if (count($datas) === 2) {
        $inicio = DateTime::createFromFormat("d/m/Y", trim($datas[0]))->format("Y-m-d");
        $fim = DateTime::createFromFormat("d/m/Y", trim($datas[1]))->format("Y-m-d");
        $where[] = "data BETWEEN '$inicio' AND '$fim'";
    }
}

if ($status !== 'todos') {
    $where[] = "status = '$status'";
}

$sql = "SELECT * FROM Pedido";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY data DESC";

$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    while ($pedido = $result->fetch_assoc()) {
        echo "<li class='order-item status-{$pedido['status']}'>Pedido #{$pedido['ID_pedido']} - " . ucfirst($pedido['status']) . " - " . date("d/m/Y", strtotime($pedido['data'])) . "</li>";
    }
} else {
    echo "<li class='order-item'>Nenhum pedido encontrado.</li>";
}

$mysqli->close();
?>