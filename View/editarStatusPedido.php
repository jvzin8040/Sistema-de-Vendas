<?php
session_start();
include(__DIR__ . '/../Model/conexaoBD.php');

function esc($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

$mensagem = '';
$erro = '';

// Atualizar status do pedido (POST)
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

// Buscar todos os pedidos com nome do cliente
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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Status dos Pedidos - Admin</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/editarStatusPedido.css">
</head>
<body>
    <?php if (file_exists('headerAdministrativo.php')) include 'headerAdministrativo.php'; ?>
    <div class="admin-container margin-ajustada-admin">
        <h1>Editar Status dos Pedidos</h1>
        <?php if (!empty($mensagem)): ?>
            <div class="msg"><?= esc($mensagem) ?></div>
        <?php endif; ?>
        <?php if (!empty($erro)): ?>
            <div class="erro"><?= esc($erro) ?></div>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Status Atual</th>
                    <th>Novo Status</th>
                    <th>Qtd Produtos</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= esc($pedido['ID_pedido']) ?></td>
                        <td><?= esc(($pedido['nome'] ?? '') . ' ' . ($pedido['sobrenome'] ?? '')) ?></td>
                        <td><?= isset($pedido['data']) ? date('d/m/Y', strtotime($pedido['data'])) : '' ?></td>
                        <td><?= esc($pedido['status']) ?></td>
                        <td>
                            <form class="inline" method="post" action="">
                                <input type="hidden" name="pedido_id" value="<?= esc($pedido['ID_pedido']) ?>">
                                <select name="novo_status">
                                    <?php foreach ($statuses as $stat): ?>
                                        <option value="<?= esc($stat) ?>" <?= ($pedido['status'] === $stat) ? 'selected' : '' ?>><?= esc($stat) ?></option>
                                    <?php endforeach; ?>
                                </select>
                        </td>
                        <td><?= esc($pedido['qtdDeProduto']) ?></td>
                        <td>R$ <?= isset($pedido['precoTotal']) ? number_format($pedido['precoTotal'], 2, ',', '.') : '0,00' ?></td>
                        <td>
                                <button type="submit">Salvar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        
    </div>
    <?php if (file_exists('footer.php')) include 'footer.php'; ?>
</body>
</html>