<?php
session_start();
include(__DIR__ . '/conexaoBD.php');

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

if (!isset($_SESSION['id_cliente'])) {
    echo "<li class='order-item'>Você precisa estar logado para ver seus pedidos.</li>";
    exit;
}

$id_cliente = intval($_SESSION['id_cliente']);

$dateRange = $_POST['dateRange'] ?? '';
$status = $_POST['status'] ?? 'todos';

$where = ["ID_cliente = $id_cliente"];

// TRATAMENTO DO FILTRO DE DATA
if (!empty($dateRange)) {
    // Normaliza separadores comuns para flatpickr
    $dateRange = str_replace(
        [" até ", " a ", " to ", " - ", "–", "—"], // inclui traços unicode também
        "|",
        $dateRange
    );
    $datas = explode("|", $dateRange);

    if (count($datas) === 2) {
        $inicio = DateTime::createFromFormat("d/m/Y", trim($datas[0]));
        $fim = DateTime::createFromFormat("d/m/Y", trim($datas[1]));
        if ($inicio && $fim) {
            $inicio_sql = $inicio->format("Y-m-d");
            $fim_sql = $fim->format("Y-m-d");
            // Garante que o início é menor ou igual ao fim
            if ($inicio_sql > $fim_sql) {
                [$inicio_sql, $fim_sql] = [$fim_sql, $inicio_sql];
            }
            $where[] = "(data >= '$inicio_sql' AND data <= '$fim_sql')";
        } else {
            // Se alguma data estiver inválida, força a query a não retornar nada
            $where[] = "1=0";
        }
    } elseif (count($datas) === 1 && trim($datas[0]) != "") {
        $unica = DateTime::createFromFormat("d/m/Y", trim($datas[0]));
        if ($unica) {
            $data_sql = $unica->format("Y-m-d");
            $where[] = "data = '$data_sql'";
        } else {
            $where[] = "1=0";
        }
    }
}

if ($status !== 'todos') {
    $status = ucfirst(mb_strtolower($status, 'UTF-8'));
    $where[] = "status = '$status'";
}

$sql = "SELECT * FROM Pedido";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY data DESC";

$result = $conexao->query($sql);

if ($result && $result->num_rows > 0) {
    while ($pedido = $result->fetch_assoc()) {
        $statusClass = strtolower(str_replace("í", "i", $pedido['status']));
        echo "<li class='order-item status-{$statusClass}'>
                <a href='detalhePedido.php?id={$pedido['ID_pedido']}' class='order-link'>
                    Pedido #{$pedido['ID_pedido']} - " . ucfirst($pedido['status']) . " - " . date('d/m/Y', strtotime($pedido['data'])) . "
                </a>
              </li>";
    }
} else {
    echo "<li class='order-item'>Nenhum pedido encontrado.</li>";
}
$conexao->close();
?>