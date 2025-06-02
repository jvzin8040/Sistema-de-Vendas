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
            <a href="../Controller/logout.php">Sair</a>
            <button class="login-button" onclick="window.location.href='painelGestor.php'">Painel do Gestor</button>
        </div>
    </div>
</header>
<link rel="stylesheet" href="css/headerAdministrativo.css">