<?php
require_once('../Controller/completarCadastroController.php'); 
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
</head>
<body style="background-color: #820AD1;">
    <?php include 'headerPrivativo.php'; ?>
    <div style="background-color: #820AD1; padding: 15px 40px; min-height: 145vh;">
        <h1 style="font-size: 28px;">Quase lá!<br>Por favor, finalize seu cadastro para prosseguir.</h1>
        <div class="container">
            <form action="../Controller/completarCadastroAction.php" method="POST">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="Nome" value="<?php echo htmlspecialchars($nome ?? ''); ?>" readonly required>

                <label for="sobrenome">Sobrenome</label>
                <input type="text" id="sobrenome" name="Sobrenome" value="<?php echo htmlspecialchars($sobrenome ?? ''); ?>" placeholder="Digite seu sobrenome" required>

                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="CPF" placeholder="000.000.000-00" maxlength="14" autocomplete="off" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;" required>

                <label for="cnpj">CNPJ <span style="font-size:12px;color:#ddd;">(Opcional, se for empresa)</span></label>
                <input type="text" id="cnpj" name="CNPJ" value="<?php echo htmlspecialchars($cnpj ?? ''); ?>" placeholder="00.000.000/0000-00" maxlength="18" autocomplete="off" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

                <label for="rg">RG</label>
                <input type="text" id="rg" name="RG" placeholder="00.000.000-0" maxlength="12" autocomplete="off" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;" required>

                <label for="nascimento">Data de nascimento</label>
                <input type="date" id="nascimento" name="DataNascimento" required>

                <label for="logradouro">Logradouro</label>
                <input type="text" id="logradouro" name="Logradouro" placeholder="Rua, avenida..." required>

                <label for="numero">Número</label>
                <input type="text" id="numero" name="Numero" required>

                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="Bairro" required>

                <label for="complemento">Complemento</label>
                <input type="text" id="complemento" name="Complemento">

                <label for="cep">CEP</label>
                <input type="text" id="cep" name="CEP" maxlength="9" placeholder="00000-000" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;" required>

                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="Cidade" required>

                <label for="estado">Estado (UF)</label>
                <select id="estado" name="Estado" required style="width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="">Selecione o UF</option>
                    <?php foreach ($ufs as $uf): ?>
                        <option value="<?php echo $uf; ?>"><?php echo $uf; ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Concluir cadastro</button>
            </form>
        </div>
    </div>
    <script src="js/completar_cadastro.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>