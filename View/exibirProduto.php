<?php
session_start();
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

$msg = $_GET['msg'] ?? '';
if ($msg === 'adicionado') {
  echo "<script>alert('Produto adicionado ao carrinho!');</script>";
}
if ($msg === 'limiteEstoque') {
  echo "<script>alert('Você não pode adicionar mais do que o estoque disponível!');</script>";
}

// Prepara imagens
$galeria = [];
foreach (['imagem', 'imagem_2', 'imagem_3'] as $imgField) {
    if (!empty($produto[$imgField])) {
        $galeria[] = $produto[$imgField];
    }
}
if (empty($galeria)) {
    $galeria[] = 'no-image.png';
}
$imgPrincipal = $galeria[0];
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
     <style>
    body {
      background: #820ad1 !important;
    }
    .produto-main-box {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08);
      padding: 48px 28px 44px 28px; /* aumentou o padding */
      max-width: 1020px;
      margin: 20px auto 24px auto;
      /* Se quiser forçar altura mínima, descomente: */
      /* min-height: 560px; */
    }
    .produto-detalhe {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 40px;
      margin-bottom: 0;
      align-items: flex-start;
      width: 100%;
    }
    .media-produto {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 18px;
      min-width: 420px;
    }
    .galeria-vertical {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
    }
    .galeria-vertical img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border: 1.5px solid #ccc;
      border-radius: 3px;
      cursor: pointer;
      transition: border 0.2s;
      background: #fafafa;
    }
    .galeria-vertical img.selected {
      border: 2px solid #6C63FF;
    }
    .imagem-principal {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .imagem-principal img {
      max-width: 320px;
      max-height: 320px;
      border-radius: 7px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      background: #fafafa;
      transition: transform 0.3s cubic-bezier(.42,0,.58,1), box-shadow 0.3s;
    }
    .imagem-principal img.zoom {
      transform: scale(1.18);
      z-index: 2;
      box-shadow: 0 4px 25px rgba(0,0,0,0.25);
    }
    .botoes-compra form,
    .botoes-compra button {
      display: inline-block;
      margin-right: 28px;
    }
    .botoes-compra form:last-child,
    .botoes-compra button:last-child {
      margin-right: 0;
    }
    @media (max-width: 1100px) {
      .produto-main-box {max-width: 98vw;}
    }
    @media (max-width: 900px) {
      .produto-detalhe, .media-produto {
        flex-direction: column;
        align-items: center;
        min-width: 0;
      }
      .media-produto {
        gap: 8px;
      }
      .produto-main-box {padding: 28px 4vw;}
    }
  </style>
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
          <h1 style="color: #6C63FF;"><?php echo htmlspecialchars($produto['nome']); ?></h1>
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
          <p><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>

          <div class="botoes-compra">
            <?php if ($produto['qtdEstoque'] > 0): ?>
              <label for="quantidadeUnica" style="margin-right: 8px;">Quantidade:</label>
              <input type="number" id="quantidadeUnica" value="1" min="1" max="<?php echo $produto['qtdEstoque']; ?>" style="width:60px; margin-bottom: 10px;">
              <form id="formComprar" method="POST" action="../Controller/comprarAgora.php" style="display:inline;">
                <input type="hidden" name="id_produto" value="<?php echo $produto['ID_produto']; ?>">
                <input type="hidden" name="quantidade" id="quantidadeComprar">
                <button type="submit" class="comprar">Comprar agora</button>
              </form>
              <?php if (isset($_SESSION['id_cliente'])): ?>
                <form id="formCarrinho" method="POST" action="../Controller/adicionar_ao_carrinho.php" style="display:inline;">
                  <input type="hidden" name="id_produto" value="<?php echo $produto['ID_produto']; ?>">
                  <input type="hidden" name="quantidade" id="quantidadeCarrinho">
                  <button type="submit" class="adicionar-carrinho">Adicionar ao carrinho</button>
                </form>
              <?php else: ?>
                <button class="adicionar-carrinho" onclick="window.location.href='../View/pagina_login.php'" style="background:#888; cursor:pointer;">Faça login para adicionar ao carrinho</button>
              <?php endif; ?>
            <?php else: ?>
              <div style="margin:16px 0; color:#a00; font-weight:bold; font-size:1.1em;">
                Este produto está temporariamente indisponível para compra, pois não há unidades em estoque no momento.<br>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>
    </div>

    <?php include 'categoria.php'; ?>

  </main>

  <?php include 'footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Miniaturas
      const miniaturas = document.querySelectorAll('.galeria-vertical img');
      const imagemPrincipal = document.getElementById('imgPrincipal');
      miniaturas.forEach(img => {
        img.addEventListener('click', () => {
          imagemPrincipal.src = img.src;
          miniaturas.forEach(m => m.classList.remove('selected'));
          img.classList.add('selected');
        });
      });

      // Zoom ao passar o mouse sobre a imagem principal
      imagemPrincipal.addEventListener('mouseenter', function() {
        imagemPrincipal.classList.add('zoom');
      });
      imagemPrincipal.addEventListener('mouseleave', function() {
        imagemPrincipal.classList.remove('zoom');
      });

      // Sincroniza quantidade única nos dois formulários antes de enviar
      function syncQuantidadeAndSubmit(formId, inputId) {
        const qty = document.getElementById('quantidadeUnica') ? document.getElementById('quantidadeUnica').value : 1;
        document.getElementById(inputId).value = qty;
        document.getElementById(formId).submit();
      }
      const formComprar = document.getElementById('formComprar');
      const formCarrinho = document.getElementById('formCarrinho');
      if (formComprar) {
        formComprar.addEventListener('submit', function(e) {
          e.preventDefault();
          syncQuantidadeAndSubmit('formComprar', 'quantidadeComprar');
        });
      }
      if (formCarrinho) {
        formCarrinho.addEventListener('submit', function(e) {
          e.preventDefault();
          syncQuantidadeAndSubmit('formCarrinho', 'quantidadeCarrinho');
        });
      }
    });
  </script>
</body>
</html>