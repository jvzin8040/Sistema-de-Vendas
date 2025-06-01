<?php
require_once('../Controller/formularioController.php'); 
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
    <link rel="stylesheet" href="css/formulario.css" />
</head>
<body>
    <?php include 'headerPrivativo.php'; ?>
    <main class="contact-main">
        <div class="contact-card">
            <h2>Fale Conosco</h2>
            <?= $msg ?>
            <?php if ($pessoa): ?>
                <form class="contact-form" method="POST">
                    <label>Nome:</label>
                    <input type="text" value="<?= htmlspecialchars($pessoa['nome'] ?? '') ?>" disabled />

                    <label>E-mail:</label>
                    <input type="email" value="<?= htmlspecialchars($pessoa['email'] ?? '') ?>" disabled />

                    <label for="subject">Assunto:</label>
                    <select id="subject" name="subject" required>
                        <option value="">Selecione o assunto</option>
                        <option value="duvida">Dúvida</option>
                        <option value="reclamacao">Reclamação</option>
                        <option value="sugestao">Sugestão</option>
                        <option value="elogio">Elogio</option>
                    </select>

                    <label for="message">Mensagem:</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Digite sua mensagem"></textarea>

                    <button type="submit" class="submit-btn">Enviar Mensagem</button>
                </form>
            <?php else: ?>
                <div style="background:#fff; color:#a00; border-radius:8px; padding:22px; text-align:center; margin:18px 0;">
                    Você precisa estar logado para enviar uma mensagem de contato.
                </div>
            <?php endif; ?>
        </div>
        <div class="contact-info">
            <h3>Outras formas de contato</h3>
            <p><strong>E-mail:</strong> contato@eidstore.com.br</p>
            <p><strong>Telefone:</strong> (11) 4002-8922</p>
            <p><strong>Horário de atendimento:</strong> Segunda a sexta, das 9h às 18h</p>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>