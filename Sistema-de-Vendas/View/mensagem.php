<?php
require_once('../Controller/mensagemController.php'); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/form.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/mensagem.css" />
</head>
<body>
    <?php include 'headerAdministrativo.php'; ?>
    <main class="contact-main">
        <div class="mensagens-card">
            <h2>Mensagens Recebidas dos Usuários</h2>
            <?php if (empty($mensagens)): ?>
                <div style="color:#a00; text-align:center; padding:30px;">Nenhuma mensagem de contato encontrada.</div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                <table class="mensagens-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Assunto</th>
                            <th>Mensagem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mensagens as $msg): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($msg['data_envio'])) ?></td>
                            <td><?= htmlspecialchars($msg['nome']) ?></td>
                            <td><?= htmlspecialchars($msg['email']) ?></td>
                            <td><span class="assunto-tag"><?= ucfirst($msg['assunto']) ?></span></td>
                            <td><div class="mensagem-box"><?= nl2br(htmlspecialchars($msg['mensagem'])) ?></div></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>