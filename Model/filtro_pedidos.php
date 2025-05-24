<?php

include(__DIR__ . '/../Controller/conexaoBD.php');

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

$dateRange = $_POST['dateRange'] ?? '';
$status = $_POST['status'] ?? 'todos';

$where = [];

if (!empty($dateRange)) {
    $datas = explode(" a ", $dateRange);
    if (count($datas) === 2) {
        $inicio = DateTime::createFromFormat("d/m/Y", trim($datas[0]))->format("Y-m-d");
        $fim = DateTime::createFromFormat("d/m/Y", trim($datas[1]))->format("Y-m-d");
        $where[] = "data_pedido BETWEEN '$inicio' AND '$fim'";
    }
}

if ($status !== 'todos') {
    $where[] = "status = '$status'";
}

$sql = "SELECT * FROM pedidos";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY data_pedido DESC";

$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    while ($pedido = $result->fetch_assoc()) {
        echo "<li class='order-item status-{$pedido['status']}'>Pedido #{$pedido['id']} - " . ucfirst($pedido['status']) . " - " . date("d/m/Y", strtotime($pedido['data_pedido'])) . "</li>";
    }
} else {
    echo "<li class='order-item'>Nenhum pedido encontrado.</li>";
}

$mysqli->close();
?>