<?php
require_once('../Controller/exibirProdutoController.php'); 
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
  <link rel="stylesheet" href="css/exibirProduto.css">
</head>

<body>
  <?php include 'header.php'; ?>

  <main class="produto-container" style="background:transparent;">
    <div class="produto-main-box">

      <section class="produto-detalhe">
        <div class="media-produto">
          <div class="galeria-vertical">
            <?php foreach ($galeria as $idx => $img): ?>
              <img src="../public/uploads/<?php echo htmlspecialchars($img); ?>"
                  alt="Miniatura <?php echo $idx+1; ?>"
                  class="<?php echo $idx === 0 ? 'selected' : ''; ?>"
                  data-idx="<?php echo $idx; ?>">
            <?php endforeach; ?>
          </div>
          <div class="imagem-principal">
            <img id="imgPrincipal" src="../public/uploads/<?php echo htmlspecialchars($imgPrincipal); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
          </div>
        </div>
        <div class="info-produto">
          <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
          <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
          <p>Categoria: <strong><?php echo htmlspecialchars($produto['categoria_nome']); ?></strong></p>
          <p>
            <?php if ($produto['qtdEstoque'] > 0): ?>
              <strong style="color: green;">Estoque disponível</strong>
            <?php else: ?>
              <strong style="color: red;">Esgotado</strong>
            <?php endif; ?>
          </p>
          <p>Quantidade: <strong><?php echo $produto['qtdEstoque']; ?> unidade(s)</strong></p>

          <div class="botoes-compra">
            <?php if ($produto['qtdEstoque'] > 0): ?>
              <div class="compra-row">
                <div class="compra-item" style="flex: 0 0 auto;">
                  <label for="quantidadeUnica">Quantidade:</label>
                </div>
                <div class="compra-item" style="flex: 0 0 70px;">
                  <input type="number" id="quantidadeUnica" value="1" min="1" max="<?php echo $produto['qtdEstoque']; ?>" style="width:60px;">
                </div>
                <div class="compra-item" style="flex:1;">
                  <?php if (isset($_SESSION['id_cliente'])): ?>
                    <form id="formCarrinho" method="POST" action="../Controller/adicionar_ao_carrinho.php">
                      <input type="hidden" name="id_produto" value="<?php echo $produto['ID_produto']; ?>">
                      <input type="hidden" name="quantidade" id="quantidadeCarrinho">
                      <button type="submit" class="adicionar-carrinho" style="width:100%;">Adicionar ao carrinho</button>
                    </form>
                  <?php else: ?>
                    <button class="adicionar-carrinho" onclick="window.location.href='../View/pagina_login.php'" style="background:#888; cursor:pointer;width:100%;">Faça login para adicionar ao carrinho</button>
                  <?php endif; ?>
                </div>
              </div>
              <div class="compra-comprar">
                <form id="formComprar" method="POST" action="../Controller/comprarAgora.php">
                  <input type="hidden" name="id_produto" value="<?php echo $produto['ID_produto']; ?>">
                  <input type="hidden" name="quantidade" id="quantidadeComprar">
                  <button type="submit" class="comprar" style="width:100%;">Comprar agora</button>
                </form>
              </div>
            <?php else: ?>
              <div style="margin:16px 0; color:#a00; font-weight:bold; font-size:1.1em;">
                Este produto está temporariamente indisponível para compra, pois não há unidades em estoque no momento.<br>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>
      
      
      <div class="descricao-block-externa">
        <h2>Descrição</h2>
        <p><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
      </div>
    </div>

    <?php include 'categoria.php'; ?>

  </main>

  <?php include 'footer.php'; ?>

  <script src="js/exibirProduto.js"></script>
</body>
</html>