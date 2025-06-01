<?php
require_once('../Controller/editarStatusPedidoController.php'); 
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