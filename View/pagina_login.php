<?php 
session_start(); // Sempre inicie a sessão no topo

$title = "EID Store"; 

// Salva intenção de compra (caso venha de um botão "comprar agora")
if (isset($_GET['comprar_agora']) && isset($_GET['id'])) {
    $_SESSION['compra_pendente'] = [
        'id_produto' => $_GET['id'],
        'quantidade' => $_GET['quantidade'] ?? 1
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>

<?php include 'headerPrivativo.php'; ?>

<div style="background-color: #820AD1; padding: 100px 20px; min-height: 90vh;">
    <div style="background-color: white; max-width: 500px; margin: 0 auto; padding: 40px; border-radius: 10px;">
        <h2 style="text-align: center; margin-bottom: 30px;">Página de Login</h2>

        <form method="post" action="../Controller/loginAction.php">
            <label for="registro">E-mail</label>
            <input type="text" name="txtEmail"  placeholder="Digite o seu E-mail" required>

            <label for="senha">Senha</label>
            <input type="password" name="txtSenha"  placeholder="Digite a sua Senha" required>

            <button type="submit">Continuar</button>
        </form>

        <!-- Botão para área restrita (login admin/funcionário) -->
        <div style="text-align:center; margin-top: 20px;">
            <a href="area_restrita.php">
                <button type="button" style="background:#6C63FF;color:#fff;padding:10px 25px;border:none;border-radius:5px;cursor:pointer;">
                    Acessar Área Administrativa
                </button>
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>