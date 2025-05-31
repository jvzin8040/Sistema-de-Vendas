<?php
session_start();
require_once '../Model/Produto.php';
require_once '../Model/conexaoBD.php';

if (!isset($_SESSION['id_cliente']) || empty($_SESSION['checkout_multi'])) {
    header('Location: carrinho.php'); exit();
}

$id_cliente = $_SESSION['id_cliente'];
$ids = array_keys($_SESSION['checkout_multi']);
$produtos = [];
$total = 0;

// Buscar produtos do carrinho
foreach ($ids as $id) {
    $produto = Produto::buscarPorId2($id);
    if ($produto) {
        $produto['quantidade'] = $_SESSION['checkout_multi'][$id];
        $produto['subtotal'] = $produto['preco'] * $produto['quantidade'];
        $produtos[] = $produto;
        $total += $produto['subtotal'];
    }
}

// Buscar dados do cliente logado para preencher automático
$sql = "SELECT nome, sobrenome, cpf, cnpj, rg, dataNascimento, logradouro, numero, bairro, complemento, cidade, uf, cep
        FROM Pessoa WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($nome, $sobrenome, $cpf, $cnpj, $rg, $dataNascimento,
    $logradouro, $numero, $bairro, $complemento, $cidade, $uf, $cep);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Múltiplos Produtos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/checkout_multi.css">
</head>
<body>
<?php include 'headerPrivativo.php'; ?>

<div class="checkout-bg-container">
    <h1 class="checkout-main-title">Finalizar Compra</h1>

    <div class="container" style="margin-bottom:2em;">
        <h2 class="checkout-produto-titulo">Produtos Selecionados</h2>
        <div class="checkout-lista-produtos">
            <?php foreach ($produtos as $produto): ?>
                <div class="checkout-produto-resumo">
                    <img src="../public/uploads/<?= $produto['imagem'] ? htmlspecialchars($produto['imagem']) : 'no-image.png' ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <div class="checkout-produto-info">
                        <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
                        <span class="preco">Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span><br>
                        <span class="quantidade">Qtd: <?= $produto['quantidade'] ?></span><br>
                        <span class="subtotal">Subtotal: <b>R$ <?= number_format($produto['subtotal'],2,',','.') ?></b></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="checkout-total">Total: R$ <?= number_format($total,2,',','.') ?></div>
    </div>

    <div class="container">
        <form action="../Controller/checkout_multi_action.php" method="post">
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
                <div id="parcela-section" class="parcela-options">
                    <label for="parcelas">Parcelamento:</label>
                    <select name="parcelas" id="parcelas">
                        <option value="1">1x de R$ <?= number_format($total,2,',','.') ?> sem juros</option>
                        <option value="2">2x de R$ <?= number_format($total/2,2,',','.') ?> sem juros</option>
                        <option value="3">3x de R$ <?= number_format($total/3,2,',','.') ?> sem juros</option>
                        <option value="4">4x de R$ <?= number_format($total/4,2,',','.') ?> sem juros</option>
                        <option value="5">5x de R$ <?= number_format($total/5,2,',','.') ?> sem juros</option>
                        <option value="6">6x de R$ <?= number_format($total/6,2,',','.') ?> sem juros</option>
                    </select>
                </div>
            </div>
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
<script src="js/cep-sync.js"></script>
</body>
</html>