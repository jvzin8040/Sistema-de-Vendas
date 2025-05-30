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

<?php include 'headerAdministrativo.php'; ?>

<div style="background-color: #820AD1; padding: 100px 20px; min-height: 90vh;">
    <div style="background-color: white; max-width: 500px; margin: 0 auto; padding: 40px; border-radius: 10px;">
        <h2 style="text-align: center; margin-bottom: 30px;">Painel do Gestor</h2>

        <div class="container">
            <div class="actions">
                <form action="cadastrar_produto.php" method="get">
                    <button type="submit">Cadastrar novo produto</button>
                </form>
                <form action="editar_produto.php" method="get">
                    <button type="submit">Editar um produto</button>
                </form>
                <form action="editar_categoria.php" method="get">
                    <button type="submit">Editar as categorias</button>
                </form>
                <!-- Botão para editar status de pedidos -->
                <form action="editarStatusPedido.php" method="get">
                    <button type="submit">Editar status dos pedidos</button>
                </form>
                <form action="cadastrar_funcionario.php" method="get">
                    <button type="submit">Cadastrar Colaborador</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html> 