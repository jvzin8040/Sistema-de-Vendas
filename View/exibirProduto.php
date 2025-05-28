<?php
$title = "Produto - EID Store";
require_once(__DIR__ . '/../Model/Produto.php');

$idProduto = $_GET['id'] ?? null;
if (!$idProduto) {
  echo "<script>alert('Produto não encontrado!'); window.location.href='index.php';</script>";
  exit;
}

$produto = Produto::buscarPorId($idProduto);
if (!$produto) {
  echo "<script>alert('Produto inválido.'); window.location.href='index.php';</script>";
  exit;
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
  <link rel="stylesheet" href="css/produto.css">
</head>
<body>
  <?php include 'header.php'; ?>

  <main class="produto-container">
    <section class="produto-detalhe">
      <div class="galeria">
        <?php if ($produto['imagem']) echo "<img src='../public/uploads/{$produto['imagem']}' alt='Imagem 1'>"; ?>
        <?php if ($produto['imagem_2']) echo "<img src='../public/uploads/{$produto['imagem_2']}' alt='Imagem 2'>"; ?>
        <?php if ($produto['imagem_3']) echo "<img src='../public/uploads/{$produto['imagem_3']}' alt='Imagem 3'>"; ?>
      </div>

      <div class="imagem-principal">
        <?php
        $imgPrincipal = $produto['imagem'] ?: 'default.png';
        echo "<img src='../public/uploads/$imgPrincipal' alt='" . htmlspecialchars($produto['nome'], ENT_QUOTES) . "'>";
        ?>
      </div>

      <div class="info-produto">
        <h1 style="color: #6C63FF;"><?php echo htmlspecialchars($produto['nome']); ?></h1>
        <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
        <p>Categoria: <strong><?php echo htmlspecialchars($produto['categoria_nome']); ?></strong></p>
        <p><strong style="color: green;"><?php echo $produto['qtdEstoque'] > 0 ? 'Estoque disponível' : 'Esgotado'; ?></strong></p>
        <p>Quantidade: <strong><?php echo $produto['qtdEstoque']; ?> unidade(s)</strong></p>
        <p><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>

        <div class="botoes-compra">
          <!-- Campo de quantidade único para ambos os botões -->
          <label for="quantidadeUnica" style="margin-right: 8px;">Quantidade:</label>
          <input type="number" id="quantidadeUnica" value="1" min="1" max="<?php echo $produto['qtdEstoque']; ?>" style="width:60px; margin-bottom: 10px;">

          <!-- Formulário para Comprar Agora -->
          <form id="formComprar" method="POST" action="../Controller/comprarAgora.php" style="display:inline;">
            <input type="hidden" name="id_produto" value="<?php echo $produto['ID_produto']; ?>">
            <input type="hidden" name="quantidade" id="quantidadeComprar">
            <button type="submit" class="comprar" <?php if ($produto['qtdEstoque'] < 1) echo 'disabled'; ?>>Comprar agora</button>
          </form>

          <!-- Formulário para Adicionar ao Carrinho -->
          <form id="formCarrinho" method="POST" action="../Controller/adicionar_ao_carrinho.php" style="display:inline;">
            <input type="hidden" name="id_produto" value="<?php echo $produto['ID_produto']; ?>">
            <input type="hidden" name="quantidade" id="quantidadeCarrinho">
            <button type="submit" class="adicionar-carrinho" <?php if ($produto['qtdEstoque'] < 1) echo 'disabled'; ?>>Adicionar ao carrinho</button>
          </form>
        </div>
      </div>
    </section>

    <br>
    <?php include 'categoria.php'; ?>
  </main>

  <?php include 'footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Miniaturas da galeria
      const miniaturas = document.querySelectorAll('.galeria img');
      const imagemPrincipal = document.querySelector('.imagem-principal img');
      miniaturas.forEach(img => {
        img.addEventListener('click', () => {
          imagemPrincipal.src = img.src;
        });
      });

      // Sincroniza quantidade única nos dois formulários antes de enviar
      function syncQuantidadeAndSubmit(formId, inputId) {
        const qty = document.getElementById('quantidadeUnica').value;
        document.getElementById(inputId).value = qty;
        document.getElementById(formId).submit();
      }

      document.getElementById('formComprar').addEventListener('submit', function(e) {
        e.preventDefault();
        syncQuantidadeAndSubmit('formComprar', 'quantidadeComprar');
      });

      document.getElementById('formCarrinho').addEventListener('submit', function(e) {
        e.preventDefault();
        syncQuantidadeAndSubmit('formCarrinho', 'quantidadeCarrinho');
      });
    });
  </script>
</body>
</html>