
<?php 
$title = "EID Store"; 
include 'header.php';
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
<link rel="stylesheet" href="css/form2.css">
<div class="form-container">
    <h2>Finalizar Compra</h2>
    <form action="../Controller/processarCheckout.php" method="POST">
        <h3>Dados Pessoais</h3>
        <label for="nome">Nome Completo:</label>
        <input type="text" name="nome" required>
        <label for="rg">RG:</label>
        <input type="text" name="rg">
        <label for="cpf_cnpj">CPF/CNPJ:</label>
        <input type="text" name="cpf_cnpj" required>
        <h3>Endereço</h3>
        <label for="logradouro">Logradouro:</label>
        <input type="text" name="logradouro" required>
        <label for="numero">Número:</label>
        <input type="text" name="numero" required>
        <label for="bairro">Bairro:</label>
        <input type="text" name="bairro" required>
        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" required>
        <label for="cep">CEP:</label>
        <input type="text" name="cep" required>
        <label for="uf">UF:</label>
        <select name="uf" required>
            <option value="">Selecione</option>
            <option value="SP">SP</option>
            <option value="RJ">RJ</option>
            <option value="MG">MG</option>
        </select>
        <button type="submit">Finalizar Pedido</button>
    </form>
</div>
<?php include 'footer.php'; ?>
</body>