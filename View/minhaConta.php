<?php
session_start();
require_once(__DIR__ . '/../Model/Pessoa.php');

if (!isset($_SESSION['id_cliente'])) {
    header("Location: pagina_login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$mensagem = $_SESSION['mensagem'] ?? "";
unset($_SESSION['mensagem']);

// Sempre busca os dados atualizados para preencher o formulário
$pessoa = Pessoa::buscarPessoaPorIdDados($id_cliente);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Minha Conta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/search.css">
  <link rel="stylesheet" href="css/cep-nav.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="css/minhaConta.css">
</head>
<body>
  <?php include 'header.php'; ?>
  <div class="minha-conta-bg-container">
    <div class="minha-conta-container card">
      <h1 class="minha-conta-main-title">Minha Conta</h1>
      <h2 class="minha-conta-titulo">Dados Pessoais</h2>
      <?php if (!empty($mensagem)): ?>
        <div style="color:green; margin-bottom:10px; text-align:center;"><?= htmlspecialchars($mensagem) ?></div>
      <?php endif; ?>
      <form id="contaForm" action="../Controller/minhaContaController.php" method="POST" autocomplete="off">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" maxlength="50" value="<?= htmlspecialchars($pessoa['nome'] ?? '') ?>" required>

        <label for="sobrenome">Sobrenome</label>
        <input type="text" name="sobrenome" id="sobrenome" maxlength="50" value="<?= htmlspecialchars($pessoa['sobrenome'] ?? '') ?>" required>

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" maxlength="80" value="<?= htmlspecialchars($pessoa['email'] ?? '') ?>" required>

        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" id="telefone" maxlength="15" value="<?= htmlspecialchars($pessoa['telefone'] ?? '') ?>">

        <label for="rg">RG</label>
        <input type="text" name="rg" id="rg" maxlength="12" value="<?= htmlspecialchars($pessoa['rg'] ?? '') ?>">

        <label for="cpf">CPF</label>
        <input type="text" name="cpf" id="cpf" maxlength="14" value="<?= htmlspecialchars($pessoa['cpf'] ?? '') ?>" required>

        <label for="cnpj">CNPJ <span class="label-opcional">(Opcional)</span></label>
        <input type="text" name="cnpj" id="cnpj" maxlength="18" value="<?= htmlspecialchars($pessoa['cnpj'] ?? '') ?>">

        <label for="dataNascimento">Data de Nascimento</label>
        <input type="date" name="dataNascimento" id="dataNascimento" value="<?= htmlspecialchars($pessoa['dataNascimento'] ?? '') ?>">

        <div class="form-section-title">Endereço</div>
        <label for="logradouro">Logradouro</label>
        <input type="text" name="logradouro" id="logradouro" maxlength="80" value="<?= htmlspecialchars($pessoa['logradouro'] ?? '') ?>" required>

        <label for="numero">Número</label>
        <input type="text" name="numero" id="numero" maxlength="10" value="<?= htmlspecialchars($pessoa['numero'] ?? '') ?>" required>

        <label for="bairro">Bairro</label>
        <input type="text" name="bairro" id="bairro" maxlength="40" value="<?= htmlspecialchars($pessoa['bairro'] ?? '') ?>" required>

        <label for="complemento">Complemento</label>
        <input type="text" name="complemento" id="complemento" maxlength="40" value="<?= htmlspecialchars($pessoa['complemento'] ?? '') ?>">

        <label for="cidade">Cidade</label>
        <input type="text" name="cidade" id="cidade" maxlength="40" value="<?= htmlspecialchars($pessoa['cidade'] ?? '') ?>" required>

        <label for="cep">CEP</label>
        <input type="text" name="cep" id="cep" maxlength="9" value="<?= htmlspecialchars($pessoa['cep'] ?? '') ?>" required>

        <label for="uf">UF</label>
        <select name="uf" id="uf" required>
          <option value="">Selecione</option>
          <?php
          $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
          foreach ($ufs as $uf) {
            $selected = ($pessoa['uf'] ?? '') === $uf ? 'selected' : '';
            echo "<option value=\"$uf\" $selected>$uf</option>";
          }
          ?>
        </select>

        <div class="buttons">
          <button class="btn btn-save" type="submit" id="saveBtn">Salvar</button>
        </div>
      </form>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script>
    // Máscara CPF
    document.getElementById('cpf').addEventListener('input', function(e){
      let v = e.target.value.replace(/\D/g, "").slice(0,11);
      v = v.replace(/(\d{3})(\d)/, "$1.$2");
      v = v.replace(/(\d{3})(\d)/, "$1.$2");
      v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      e.target.value = v;
    });
    // Máscara RG
    document.getElementById('rg').addEventListener('input', function(e){
      let v = e.target.value.replace(/\D/g, "").slice(0,9);
      v = v.replace(/(\d{2})(\d)/, "$1.$2");
      v = v.replace(/(\d{3})(\d)/, "$1.$2");
      v = v.replace(/(\d{3})(\d{1})$/, "$1-$2");
      e.target.value = v;
    });
    // Máscara Telefone
    document.getElementById('telefone').addEventListener('input', function(e){
      let v = e.target.value.replace(/\D/g, "").slice(0,11);
      if(v.length <= 10){
        v = v.replace(/(\d{2})(\d)/, "($1) $2");
        v = v.replace(/(\d{4})(\d)/, "$1-$2");
      }else{
        v = v.replace(/(\d{2})(\d)/, "($1) $2");
        v = v.replace(/(\d{5})(\d)/, "$1-$2");
      }
      e.target.value = v;
    });
    // Máscara CNPJ
    document.getElementById('cnpj').addEventListener('input', function(e){
      let v = e.target.value.replace(/\D/g, "").slice(0,14);
      v = v.replace(/^(\d{2})(\d)/, "$1.$2");
      v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
      v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");
      v = v.replace(/(\d{4})(\d)/, "$1-$2");
      e.target.value = v;
    });
    // Máscara CEP
    document.getElementById('cep').addEventListener('input', function(e){
      let v = e.target.value.replace(/\D/g, "").slice(0,8);
      v = v.replace(/(\d{5})(\d)/, "$1-$2");
      e.target.value = v;
    });
  </script>
</body>
</html>