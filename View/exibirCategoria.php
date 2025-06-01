<?php
require_once('../Model/Produto.php');

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
if (!$categoria) {
    header("Location: index.php");
    exit();
}
$produtos = Produto::listarPorCategoria($categoria);

$title = "<br>Produtos da categoria: " . htmlspecialchars($categoria);

include 'header.php'; // Inclua o header.php aqui, ANTES de qualquer HTML!
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/responsive.css">

    <style>
        .container {
            max-width: 1260px;
            margin: 0 auto 54px auto;
            padding: 0 20px 0 20px;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 2px 18px #b8a7ff24;
            min-height: 75vh;
        }
        .title-categoria {
            margin: 38px 0 26px 0;
            text-align: center;
            font-size: 1.7em;
            color: #630dbb;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .produtos-matriz-row {
            display: flex;
            flex-wrap: wrap;
            gap: 28px 24px;
            justify-content: center; /* <--- CENTRALIZA OS PRODUTOS */
        }
        .produto-link {
            text-decoration: none;
            color: inherit;
            display: block;
            width: 220px;
            margin-bottom: 0;
            flex: 0 1 220px;
        }
        /* NOVA BORDA IGUAL CATEGORIA */
        .produto-card {
            background: #f8f4ff;
            border-radius: 12px;
            box-shadow: 0 2px 10px #b8a7ff30;
            border: 0.8px solid #d2c5ee;
            padding: 18px 14px 14px 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow 0.2s, transform 0.19s, border-color 0.2s;
            height: 100%;
            cursor: pointer;
        }
        .produto-card:hover {
            box-shadow: 0 6px 28px #a17bf74c;
            border-color: #a17bf7;
            transform: translateY(-3px) scale(1.02);
            background: #ece6fa;
        }
        .produto-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 9px;
            background: #ece6fa;
            margin-bottom: 10px;
        }
        .produto-card h3 {
            color: #630dbb;
            font-size: 1.1em;
            margin: 0 0 6px 0;
            text-align: center;
        }
        .produto-card .price {
            color: #6C63FF;
            font-weight: bold;
            font-size: 1em;
            margin-bottom: 6px;
            display: block;
        }
        .produto-card .estoque {
            font-size: 0.93em;
            color: #8271b0;
            margin-bottom: 6px;
            display: block;
        }
        @media (max-width: 900px) {
            .container {
                max-width: 98vw;
                padding: 0 2vw;
            }
            .produtos-matriz-row {
                gap: 18px 3vw;
                justify-content: center;
            }
            .produto-link {
                width: 44vw;
                min-width: 145px;
                max-width: 260px;
            }
        }
        @media (max-width: 650px) {
            .container {
                border-radius: 10px;
                min-height: 60vh;
                margin-bottom: 38px;
            }
            .produtos-matriz-row {
                gap: 13px 0;
            }
            .produto-link {
                width: 95vw;
                min-width: 0;
                max-width: 99vw;
            }
            .title-categoria {
                font-size: 1.3em;
                margin: 20px 0 12px 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="title-categoria"><?= $title ?></h2>
        <div class="produtos-matriz-row">
            <?php if ($produtos && count($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                    <a href="exibirProduto.php?id=<?= $produto['ID_produto'] ?>" class="produto-link">
                        <div class="produto-card">
                            <img src="<?= !empty($produto['imagem'])
                                            ? '../public/uploads/' . htmlspecialchars($produto['imagem'])
                                            : '../public/uploads/no-image.png'; ?>"
                                alt="<?= htmlspecialchars($produto['nome']) ?>">
                            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                            <span class="price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                            <span class="estoque">Estoque: <?= (int)($produto['qtdEstoque'] ?? 0) ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="margin: 40px auto; text-align: center; color: #888;">Nenhum produto encontrado nesta categoria.</p>
            <?php endif; ?>
        </div>
        <br><br>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>