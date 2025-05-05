<?php 
$title = "Produto - EID Store"; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
    <!-- CSS Geral -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/search.css">
    <link rel="stylesheet" href="../css/cep-nav.css">
    <link rel="stylesheet" href="../css/banner.css">
    <link rel="stylesheet" href="../css/products.css">
    <link rel="stylesheet" href="../css/categories.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/produto.css"> <!-- Novo CSS exclusivo -->
</head>
<body>

<?php include 'header.php'; ?>

<main class="produto-container">
  <section class="produto-detalhe">
    <div class="galeria">
      <img src="../images/miniatura1.png" alt="Miniatura 1">
      <img src="../images/miniatura2.png" alt="Miniatura 2">
      <img src="../images/miniatura3.png" alt="Miniatura 3">
    </div>

    <div class="imagem-principal">
      <img src="../images/smartphone.png" alt="Smartphone Motorola G75">
    </div>

    <div class="info-produto">
      <h1>Smartphone Motorola Moto G75 5G 256GB 16GB Ram Boost 50MP</h1>
      <p class="preco">R$ 1.976 <span>em 12x R$189,93</span></p>
      <p>Chegará terça-feira</p>
      <p>Cor: <strong>Cinza</strong></p>
      <p><strong style="color: green;">Estoque disponível</strong></p>
      <p>Quantidade: <strong>1 unidade</strong></p>

      <div class="botoes-compra">
        <button class="comprar">Comprar agora</button>
        <button class="adicionar-carrinho">Adicionar ao carrinho</button>
      </div>
    </div>
  </section>

  <?php include 'categories.php'; ?>
</main>



<?php include 'footer.php'; ?>

</body>
</html>