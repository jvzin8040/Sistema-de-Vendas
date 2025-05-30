<?php
session_start();
require_once('../Model/conexaoBD.php');

if (!isset($_SESSION['id_cliente']) || !isset($_SESSION['checkout'])) {
    header("Location: pagina_login.php"); 
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$id_produto = $_SESSION['checkout']['id_produto'];
$quantidade = $_SESSION['checkout']['quantidade'];

// Busca dados do produto
$sql_prod = "SELECT nome, preco, imagem FROM Produto WHERE ID_produto = ?";
$stmt_prod = $conexao->prepare($sql_prod);
$stmt_prod->bind_param("i", $id_produto);
$stmt_prod->execute();
$stmt_prod->bind_result($produto_nome, $produto_preco, $produto_imagem);
$stmt_prod->fetch();
$stmt_prod->close();

// Caminho correto da imagem - igual ao exibirProduto
if ($produto_imagem && trim($produto_imagem) !== '') {
    $img_src = '../public/uploads/' . htmlspecialchars($produto_imagem);
} else {
    $img_src = '../public/uploads/no-image.png';
}

// Busca dados do cliente
$sql = "SELECT nome, sobrenome, cpf, cnpj, rg, dataNascimento, logradouro, numero, bairro, complemento, cidade, uf, cep
        FROM Pessoa WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($nome, $sobrenome, $cpf, $cnpj, $rg, $dataNascimento,
    $logradouro, $numero, $bairro, $complemento, $cidade, $uf, $cep);
$stmt->fetch();
$stmt->close();

$title = "EID Store";
$total = $produto_preco * $quantidade;
?>
<!DOCTYPE html>
<html lang="pt-BR">
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
    <style>
        .form-section-title {
            text-align: center;
            margin: 30px 0 10px 0;
            color: #630dbb;
            font-size: 1.4em;
            font-weight: bold;
        }
        .pagamento-container {
            margin-top: 32px;
            padding: 22px 16px 18px 16px;
            border-radius: 10px;
            background: #faf7fd;
            max-width: 420px;
            margin-left: auto;
            margin-right: auto;
        }
        .pagamento-container h3 {
            text-align: center;
            color: #630dbb;
            margin-bottom: 16px;
            font-size: 1.3em;
            font-weight: 600;
        }
        .pagamento-metodo-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 16px;
        }
        .pagamento-metodo-table td {
            vertical-align: middle;
            padding: 0 10px;
            font-size: 1.08em;
        }
        .pagamento-metodo-table label {
            font-weight: bold;
            color: #3d2061;
            cursor: pointer;
        }
        .parcela-options {
            margin-top: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .parcela-options label {
            margin-bottom: 6px;
            font-weight: 500;
            color: #6900bf;
        }
        #parcelas {
            min-width: 220px;
            padding: 6px 12px;
            border-radius: 5px;
            border: 1px solid #a17bf7;
            font-size: 1.05em;
            background: #fff;
            color: #3b2061;
            text-align: center;
        }
        /* Produto info (retorno ao padrão escuro) */
        .checkout-produto-info {
            color: #222;
        }
        .checkout-produto-info strong {
            color: #630dbb;
        }
        /* Corrige cor do h2 "Produto Selecionado" para o padrão escuro */
        .checkout-produto-titulo {
            color: #222 !important;
            letter-spacing: 1px;
        }
    </style>
</head>
<body style="background-color: #820AD1;">

<?php include 'headerPrivativo.php'; ?>

<div style="background-color: #820AD1; padding: 15px 40px; min-height: 145vh;">
    <h1 style="font-size: 28px; color: #fff; text-align: center; letter-spacing: 1px; margin-bottom: 25px; text-shadow: 0 1px 6px #7d40c7a0;">Finalizar Compra</h1>

    <!-- Exibe resumo do produto -->
    <div class="container" style="margin-bottom:2em;">
        <h2 class="checkout-produto-titulo">Produto Selecionado</h2>
        <div style="display:flex;align-items:center;gap:20px;">
            <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($produto_nome); ?>" style="max-width:120px;max-height:120px;">
            <div class="checkout-produto-info">
                <strong><?php echo htmlspecialchars($produto_nome); ?></strong><br>
                Preço: R$ <?php echo number_format($produto_preco, 2, ',', '.'); ?><br>
                Quantidade: <?php echo htmlspecialchars($quantidade); ?><br>
                Total: <b>R$ <?php echo number_format($total, 2, ',', '.'); ?></b>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="../Controller/checkoutAction.php" method="POST">
            <div class="form-section-title">Dados Pessoais</div>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($nome ?? ''); ?>" required>
            <label for="sobrenome">Sobrenome</label>
            <input type="text" name="sobrenome" id="sobrenome" value="<?php echo htmlspecialchars($sobrenome ?? ''); ?>" required>
            <label for="rg">RG</label>
            <input type="text" name="rg" id="rg" value="<?php echo htmlspecialchars($rg ?? ''); ?>">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" value="<?php echo htmlspecialchars($cpf ?? ''); ?>" required>
             <label for="cnpj">CNPJ <span style="font-size:12px;color:#b649ff;font-weight:500;">(Opcional)</span> </label>
            <input type="text" name="cnpj" id="cnpj" value="<?php echo htmlspecialchars($cnpj ?? ''); ?>">
            <label for="dataNascimento">Data de Nascimento</label>
            <input type="date" name="dataNascimento" id="dataNascimento" value="<?php echo htmlspecialchars($dataNascimento ?? ''); ?>">

            <div class="form-section-title">Endereço</div>
            <label for="logradouro">Logradouro</label>
            <input type="text" name="logradouro" id="logradouro" value="<?php echo htmlspecialchars($logradouro ?? ''); ?>" required>
            <label for="numero">Número</label>
            <input type="text" name="numero" id="numero" value="<?php echo htmlspecialchars($numero ?? ''); ?>" required>
            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" value="<?php echo htmlspecialchars($bairro ?? ''); ?>" required>
            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" id="complemento" value="<?php echo htmlspecialchars($complemento ?? ''); ?>">
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" value="<?php echo htmlspecialchars($cidade ?? ''); ?>" required>
            <label for="cep">CEP</label>
            <input type="text" name="cep" id="cep" value="<?php echo htmlspecialchars($cep ?? ''); ?>" required>
            <label for="uf">UF</label>
            <input type="text" name="uf" id="uf" value="<?php echo htmlspecialchars($uf ?? ''); ?>" required>

            <!-- Pagamento -->
            <div class="pagamento-container">
                <h3>Método de Pagamento</h3>
                <table class="pagamento-metodo-table">
                    <tr>
                        <td style="width:30px;text-align:right;">
                            <input type="radio" name="metodo_pagamento" id="cartao" value="cartao" checked>
                        </td>
                        <td><label for="cartao">Cartão de Crédito</label></td>
                    </tr>
                    <tr>
                        <td style="width:30px;text-align:right;">
                            <input type="radio" name="metodo_pagamento" id="pix" value="pix">
                        </td>
                        <td><label for="pix">Pix</label></td>
                    </tr>
                    <tr>
                        <td style="width:30px;text-align:right;">
                            <input type="radio" name="metodo_pagamento" id="boleto" value="boleto">
                        </td>
                        <td><label for="boleto">Boleto Bancário</label></td>
                    </tr>
                </table>
                <!-- Parcelamento: só mostra se cartão -->
                <div id="parcela-section" class="parcela-options">
                    <label for="parcelas">Parcelamento:</label>
                    <select name="parcelas" id="parcelas">
                        <option value="1">1x de R$ <?php echo number_format($total,2,',','.'); ?> sem juros</option>
                        <option value="2">2x de R$ <?php echo number_format($total/2,2,',','.'); ?> sem juros</option>
                        <option value="3">3x de R$ <?php echo number_format($total/3,2,',','.'); ?> sem juros</option>
                        <option value="4">4x de R$ <?php echo number_format($total/4,2,',','.'); ?> sem juros</option>
                        <option value="5">5x de R$ <?php echo number_format($total/5,2,',','.'); ?> sem juros</option>
                        <option value="6">6x de R$ <?php echo number_format($total/6,2,',','.'); ?> sem juros</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="id_produto" value="<?php echo htmlspecialchars($id_produto); ?>">
            <input type="hidden" name="quantidade" value="<?php echo htmlspecialchars($quantidade); ?>">
            <button type="submit">Finalizar Pedido</button>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
    // Esconde o campo de parcelamento se não for cartão
    document.addEventListener("DOMContentLoaded", function(){
        function toggleParcelamento() {
            var metodo = document.querySelector('input[name="metodo_pagamento"]:checked').value;
            var parcelaSection = document.getElementById('parcela-section');
            if(metodo === 'cartao'){
                parcelaSection.style.display = 'flex';
            } else {
                parcelaSection.style.display = 'none';
            }
        }
        document.querySelectorAll('input[name="metodo_pagamento"]').forEach(function(elem){
            elem.addEventListener('change', toggleParcelamento);
        });
        toggleParcelamento();
    });
</script>
</body>
</html>