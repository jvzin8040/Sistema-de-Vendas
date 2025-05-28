<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_cliente'])) {
    echo "<script>
        alert('Acesso Negado! \\nRealize o login primeiro.');
        window.location.href='../View/pagina_login.php';
    </script>";
    exit();
}
?>
