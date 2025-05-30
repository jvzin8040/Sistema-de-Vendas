<?php 
$title = "EID Store"; 
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
 
<div style="background-color: #820AD1; padding: 50px 20px; min-height: 100vh;">
    <div style="background-color: white; max-width: 500px; margin: 0 auto; padding: 40px; border-radius: 10px;">
        <h2 style="text-align: center; margin-bottom: 30px;">Criar Conta</h2>

        <form action="../Controller/cadastroAction.php" method="post" style="display: flex; flex-direction: column; gap: 15px;">
            <label for="nome">Seu nome</label>
            <input type="text" name="nome" id="nome" required>

            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" required>

            <label for="telefone">Telefone</label>
            <input type="tel" name="telefone" id="telefone" required>

            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required>

            <label for="confirmar_senha">Confirmar senha</label>
            <input type="password" name="confirmar_senha" id="confirmar_senha" required>

            <button type="submit" style="background-color: #8000ff; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer;">
                Continuar
            </button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>