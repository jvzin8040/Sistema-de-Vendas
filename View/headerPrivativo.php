<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<header class="header">
    <div class="top-header">
        <a href="../View/index.php">
            <img src="../View/images/eid_store_logo.png" alt="EID Store Logo" class="logo-img">
        </a>
        <div class="header-actions">
            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                <a href="minhaConta.php">Minha Conta</a>
                <a href="historicoPedido.php">Histórico de Pedidos</a>
                <a href="#" class="login-button" onclick="confirmLogout('<?php echo addslashes($_SESSION['usuario_nome'] ?? 'usuario'); ?>')">Sair</a>
            <?php else: ?>
                <a href="criar_conta.php">Crie sua conta</a>
                <button class="login-button" onclick="window.location.href='pagina_login.php'">Entre</button>
            <?php endif; ?>
        </div>
    </div>
</header>
<link rel="stylesheet" href="css/headerPrivativo.css">
<script src="js/headerPrivativo.js"></script>