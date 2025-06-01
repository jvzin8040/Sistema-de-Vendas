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
<style>
.header {
    background-color: #1C1D22;
    color: white;
    padding: 10px 20px;
    max-width: 100%;
    overflow-x: hidden;
    box-sizing: border-box;
}
.top-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
    white-space: nowrap;
}
.header-actions a {
    color: white;
    text-decoration: none;
    font-size: 14px;
    display: inline-block;
}
.login-button {
    color: white;
    background: #8000ff;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
/* Borda e fundo SEMPRE visíveis na logo */
.logo-img {
    width: 80px;
    height: auto;
    cursor: pointer;
    transition: transform 0.2s ease;
    border-radius: 7px;
    background: #ece6fa;
    box-shadow: 0 1px 6px #a17bf722;
    max-width: 60px;
    max-height: 60px;
}
/* Só efeito de zoom no hover */
.logo-img:hover {
    transform: scale(1.05);
}
</style>
<script>
function confirmLogout(userName) {
    if (confirm(`Olá, ${userName}! Tem certeza que deseja sair?`)) {
        window.location.href = '../Controller/logout.php';
    }
}
</script>