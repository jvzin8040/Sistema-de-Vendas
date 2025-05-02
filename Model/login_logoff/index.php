<?php require_once ('cabecalho.php'); ?>
<div class="w3-container w3-round-xxlarge w3-display-middle w3-card-4 w3-third ">
    <div class="w3-center">
        <br>
        <img src="img/gabi.jpg" alt="Gabi" style="width:40%" class="w3-circle w3-margin-top">
    </div>
    <form class="w3-container " action="loginAction.php" method="post">
        <div class="w3-section">
            <label style="font-weight: bold;">E-mail</label>
            <input class="w3-input w3-border w3-marginbottom" type="text" placeholder="Digite o nome" name="txtEmail" required>
            <label style="font-weight: bold;">Senha</label>
            <input class="w3-input w3-border" type="password" placeholder="Digite a Senha" name="txtSenha" required>
            <button class="w3-button w3-block w3-teal w3-section w3-padding" type="submit">Entrar</button>
        </div>
    </form>
    <br>
</div>
<?php require_once ('rodape.php'); ?>
