<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: pagina_login.php");
    exit();
}

if (!isset($_SESSION['compra_pendente'])) {
    header("Location: index.php");
    exit();
}

require_once('../Model/conexaoBD.php');
$id_cliente = $_SESSION['id_cliente'];

// Busca nome e sobrenome do usuário no banco
$sql = "SELECT nome, sobrenome, cnpj FROM Pessoa WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($nome, $sobrenome, $cnpj);
$stmt->fetch();
$stmt->close();

$id_produto = $_SESSION['compra_pendente']['id_produto'];
$quantidade = $_SESSION['compra_pendente']['quantidade'];
$title = "EID Store";

// Array de UFs
$ufs = [
    "AC","AL","AP","AM","BA","CE","DF","ES","GO","MA","MT","MS","MG",
    "PA","PB","PR","PE","PI","RJ","RN","RS","RO","RR","SC","SP","SE","TO"
];
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
                <input type="text" id="nome" name="Nome" value="<?php echo htmlspecialchars($nome ?? ''); ?>" readonly>

                <label for="sobrenome">Sobrenome</label>
                <input type="text" id="sobrenome" name="Sobrenome" value="<?php echo htmlspecialchars($sobrenome ?? ''); ?>" placeholder="Digite seu sobrenome" <?php if (empty($sobrenome)) echo "required"; ?>>

                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="CPF" placeholder="000.000.000-00" maxlength="14" autocomplete="off" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

                <label for="cnpj">CNPJ <span style="font-size:12px;color:#ddd;">(Opcional, se for empresa)</span></label>
                <input type="text" id="cnpj" name="CNPJ" value="<?php echo htmlspecialchars($cnpj ?? ''); ?>" placeholder="Digite seu CNPJ">

                <label for="rg">RG</label>
                <input type="text" id="rg" name="RG" placeholder="00.000.000-0" maxlength="12" autocomplete="off" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

                <label for="nascimento">Data de nascimento</label>
                <input type="date" id="nascimento" name="DataNascimento">

                <label for="logradouro">Logradouro</label>
                <input type="text" id="logradouro" name="Logradouro" placeholder="Rua, avenida...">

                <label for="numero">Número</label>
                <input type="text" id="numero" name="Numero">

                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="Bairro">

                <label for="complemento">Complemento</label>
                <input type="text" id="complemento" name="Complemento">

                <label for="cep">CEP</label>
                <input type="text" id="cep" name="CEP" maxlength="9" placeholder="00000-000" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="Cidade">

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
    <script>
    // Formatação e sincronização do campo CEP (com header)
    function formatarCep(valor) {
        valor = valor.replace(/\D/g, "").slice(0, 8);
        if (valor.length > 5) valor = valor.replace(/^(\d{5})(\d{0,3})/, "$1-$2");
        return valor;
    }

    // Formatação para CPF: 000.000.000-00
    function formatarCPF(valor) {
        valor = valor.replace(/\D/g, "").slice(0, 11);
        if (valor.length > 9) {
            valor = valor.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2})/, "$1.$2.$3-$4");
        } else if (valor.length > 6) {
            valor = valor.replace(/^(\d{3})(\d{3})(\d{0,3})/, "$1.$2.$3");
        } else if (valor.length > 3) {
            valor = valor.replace(/^(\d{3})(\d{0,3})/, "$1.$2");
        }
        return valor;
    }

    // Formatação para RG: 00.000.000-0
    function formatarRG(valor) {
        valor = valor.replace(/\D/g, "").slice(0, 9);
        if (valor.length > 7) {
            valor = valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,1})/, "$1.$2.$3-$4");
        } else if (valor.length > 4) {
            valor = valor.replace(/^(\d{2})(\d{3})(\d{0,3})/, "$1.$2.$3");
        } else if (valor.length > 2) {
            valor = valor.replace(/^(\d{2})(\d{0,3})/, "$1.$2");
        }
        return valor;
    }

    document.addEventListener("DOMContentLoaded", function() {
        var headerCep = document.getElementById("header-cep");
        var cadastroCep = document.getElementById("cep");
        var cpf = document.getElementById("cpf");
        var rg = document.getElementById("rg");

        // Preenche os dois com o que estiver no sessionStorage
        if (headerCep && sessionStorage.getItem("lastCep")) headerCep.value = sessionStorage.getItem("lastCep");
        if (cadastroCep && sessionStorage.getItem("lastCep")) cadastroCep.value = sessionStorage.getItem("lastCep");

        // CEP sync
        if (headerCep) {
            headerCep.addEventListener("input", function() {
                headerCep.value = formatarCep(headerCep.value);
                sessionStorage.setItem("lastCep", headerCep.value);
                if (cadastroCep) cadastroCep.value = headerCep.value;
            });
        }
        if (cadastroCep) {
            cadastroCep.addEventListener("input", function() {
                cadastroCep.value = formatarCep(cadastroCep.value);
                sessionStorage.setItem("lastCep", cadastroCep.value);
                if (headerCep) headerCep.value = cadastroCep.value;
            });
        }
        // CPF
        if (cpf) {
            cpf.addEventListener("input", function() {
                cpf.value = formatarCPF(cpf.value);
            });
        }
        // RG
        if (rg) {
            rg.addEventListener("input", function() {
                rg.value = formatarRG(rg.value);
            });
        }
    });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>