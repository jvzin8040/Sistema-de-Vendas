<?php 
// Define o título da página
$title = "EID Store"; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

    <!-- CSS Geral -->
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

<header>
    <div class="top-header">
        <img src="images/eid_store_logo.png" alt="Logo EID Store" class="logo-img">
        <div class="header-actions">
            <a href="#">Login</a>
            <a href="#">Minha Conta</a>
            <a href="#" aria-label="Carrinho de compras"> <!-- Ícone do carrinho -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                        <path d="M7 18c-1.104 0-2 .897-2 2s.896 2 2 2c1.103 0 2-.897 2-2s-.897-2-2-2zm10 0c-1.103 0-2 .897-2 2s.897 2 2 2c1.104 0 2-.897 2-2s-.896-2-2-2zm1.293-11.707l-1.086 5.434c-.098.489-.53.857-1.029.857h-8.535l-.389-2h7.863c.553 0 1-.447 1-1s-.447-1-1-1h-8.893l-.37-1.882c-.095-.484-.528-.828-1.025-.828h-1.807c-.553 0-1 .447-1 1s.447 1 1 1h.878l1.74 8.707c.096.485.528.829 1.025.829h9.645c.466 0 .868-.316.974-.769l1.374-6.869c.113-.564-.259-1.109-.823-1.223-.564-.113-1.109.259-1.223.823z"/>
                    </svg>
            </a>
        </div>
    </div>
</header>

<div style="background-color: #820AD1; padding: 50px 20px; min-height: 100vh;">
    <div style="background-color: white; max-width: 500px; margin: 0 auto; padding: 40px; border-radius: 10px;">
        <h2 style="text-align: center; margin-bottom: 30px;">Cadastro</h2>

        <div class="container">
            <div class="actions">
                <form action="cadastrar_produto.php" method="get">
                    <button type="submit">Cadastrar novo produto</button>
                </form>
                    <form action="editar_produto.php" method="get">
                    <button type="submit">Editar produto</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html> 