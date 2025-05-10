<?php require_once('verificarAcesso.php'); ?>
    <?php
    unset($_SESSION['logado']);
    header("location:../View/pagina_login.php");
    ?>