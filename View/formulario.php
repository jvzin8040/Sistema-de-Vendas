<?php
session_start();
require_once('../Model/Pessoa.php');
require_once('../Model/Contato.php');

$title = "Contato - EID Store";
$msg = "";

// Suporte tanto para id_pessoa quanto id_cliente
$id_pessoa = $_SESSION['id_pessoa'] ?? $_SESSION['id_cliente'] ?? null;
$pessoa = $id_pessoa ? Pessoa::buscarPessoaPorId($id_pessoa) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_pessoa) {
    $assunto = $_POST['subject'] ?? '';
    $mensagem = $_POST['message'] ?? '';
    if (Contato::salvar($id_pessoa, $assunto, $mensagem)) {
        $msg = "<div class='success-msg'>Mensagem enviada com sucesso!</div>";
    } else {
        $msg = "<div class='error-msg'>Erro ao enviar mensagem. Tente novamente.</div>";
    }
}
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
    <style>
        body {
            background-color: #820AD1;
            margin: 0;
            padding: 0;
        }
        .contact-main {
            min-height: 100vh;
            padding: 50px 20px;
        }
        .contact-card {
            background-color: #fff;
            max-width: 500px;
            margin: 0 auto 35px auto;
            padding: 38px 32px 28px 32px;
            border-radius: 10px;
            box-shadow: 0 6px 46px #0002;
        }
        .contact-card h2 {
            text-align: center;
            color: #820AD1;
            margin-bottom: 28px;
            font-size: 2em;
            font-weight: 700;
        }
        .contact-form label {
            font-weight: 500;
            color: #820AD1;
            margin-bottom: 6px;
            display: block;
            font-size: 1em;
        }
        .contact-form input,
        .contact-form select,
        .contact-form textarea {
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px 12px;
            font-size: 1em;
            background: #f7f4fd;
            color: #2e235c;
            margin-bottom: 15px;
        }
        .contact-form textarea {
            resize: vertical;
        }
        .submit-btn {
            background: #820AD1;
            color: #fff;
            font-size: 1.1em;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            padding: 12px 0;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .submit-btn:hover {
            background: #5e047f;
        }
        .success-msg {
            color: #155724;
            background: #d4edda;
            padding: 10px 16px;
            border-radius: 7px;
            margin-bottom: 16px;
            text-align: center;
            border: 1px solid #b8dfc6;
        }
        .error-msg {
            color: #721c24;
            background: #f8d7da;
            padding: 10px 16px;
            border-radius: 7px;
            margin-bottom: 16px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }
        .contact-info {
            background: #fff;
            color: #2e235c;
            border-radius: 10px;
            margin: 0 auto 0 auto;
            max-width: 500px;
            padding: 24px 20px;
            box-shadow: 0 2px 12px #2e235c15;
        }
        .contact-info h3 {
            color: #820AD1;
            margin-bottom: 8px;
            font-size: 1.2em;
            font-weight: 600;
        }
        .contact-info p {
            margin: 0 0 6px 0;
            font-size: 1em;
        }
        @media (max-width: 650px) {
            .contact-main {
                padding: 16px 2vw;
            }
            .contact-card, .contact-info {
                max-width: 98vw;
                padding: 16px 2vw;
            }
        }
    </style>
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