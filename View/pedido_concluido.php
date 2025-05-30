<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedido Concluído | EID Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS principal do sistema -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/histPedido.css">

    <!-- CSS do formulário desta página -->
    <link rel="stylesheet" href="css/form3.css">

    <!-- Flatpickr (exemplo de JS externo usado no seu sistema) -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
</head>
<body>
    <?php include 'headerPrivativo.php'; ?>
    <?php include '../Controller/verifica_login.php'; ?>
    <div class="main-content-pedido">
        <div class="form-container">
            <h2>Pedido Concluído!</h2>
            <p>
                Obrigado por sua compra.<br>
                Seus dados foram recebidos com sucesso e seu pedido já está sendo processado.
            </p>
            <a href="index.php">
                Voltar à loja
            </a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>