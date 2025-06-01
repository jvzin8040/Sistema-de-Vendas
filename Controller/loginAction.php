<?php
session_start();
require_once('../Model/Pessoa.php');

$email = $_POST['txtEmail'];
$senha = $_POST['txtSenha'];

$result = Pessoa::autenticar($email, $senha);

if ($result['success']) {
    $_SESSION['logado'] = true;
    $_SESSION['usuario_nome'] = $result['nome'];
    $_SESSION['usuario_email'] = $email;
    $_SESSION['id_cliente'] = $result['id'];

    if (isset($_SESSION['compra_pendente'])) {
        echo "<script>
            alert('{$result['nome']}, Seja Bem-Vindo(a)!');
            window.location.href='../View/comprarAgora.php';
        </script>";
        exit();
    }

    echo "<script>alert('{$result['nome']}, Seja Bem-Vindo(a)!'); window.location.href='../View/index.php';</script>";
} else {
    echo "<script>alert('Usuário ou senha inválidos!'); window.location.href='../View/pagina_login.php';</script>";
}
?>