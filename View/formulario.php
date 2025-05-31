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
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/contato.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/responsive.css">




    <style>
        .contact-container {
            max-width: 520px;
            margin: 40px auto 50px auto;
            background: #2e235c;
            border-radius: 18px;
            box-shadow: 0 6px 46px #0002;
            padding: 32px 24px 28px 24px;
            color: #fff;
        }

        .contact-form .form-group {
            margin-bottom: 18px;
        }

        .contact-form label {
            font-weight: bold;
            color: #f3eaff;
            margin-bottom: 4px;
            display: block;
        }

        .contact-form input,
        .contact-form select,
        .contact-form textarea {
            width: 100%;
            border-radius: 8px;
            border: none;
            padding: 10px 12px;
            font-size: 1em;
            background: #f2f0fa;
            color: #2e235c;
            margin-bottom: 5px;
        }

        .contact-form textarea {
            resize: vertical;
        }

        .submit-btn {
            background: #6c63ff;
            color: #fff;
            font-size: 1.1em;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s;
        }

        .submit-btn:hover {
            background: #5346d4;
        }

        .contact-info {
            background: #fff;
            color: #2e235c;
            border-radius: 12px;
            margin-top: 32px;
            padding: 18px 14px;
            box-shadow: 0 2px 12px #2e235c15;
        }

        .success-msg {
            color: #155724;
            background: #d4edda;
            padding: 10px 16px;
            border-radius: 7px;
            margin-bottom: 14px;
            text-align: center;
        }

        .error-msg {
            color: #721c24;
            background: #f8d7da;
            padding: 10px 16px;
            border-radius: 7px;
            margin-bottom: 14px;
            text-align: center;
        }

        @media (max-width: 650px) {
            .contact-container {
                max-width: 98vw;
                padding: 16px 2vw 16px 2vw;
            }
        }
    </style>
</head>

<body>
    <?php include 'headerPrivativo.php'; ?>
    <main class="contact-container">
        <h1>Fale Conosco</h1>
        <?= $msg ?>
        <?php if ($pessoa): ?>
            <form class="contact-form" method="POST">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" value="<?= htmlspecialchars($pessoa['nome'] ?? '') ?>" disabled>
                </div>
                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="email" value="<?= htmlspecialchars($pessoa['email'] ?? '') ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="subject">Assunto:</label>
                    <select id="subject" name="subject" required>
                        <option value="duvida">Dúvida</option>
                        <option value="reclamacao">Reclamação</option>
                        <option value="sugestao">Sugestão</option>
                        <option value="elogio">Elogio</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Mensagem:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Enviar Mensagem</button>
            </form>
        <?php else: ?>
            <div style="background:#fff; color:#a00; border-radius:12px; padding:20px; text-align:center; margin:30px 0;">
                Você precisa estar logado para enviar uma mensagem de contato.
            </div>
        <?php endif; ?>
        <div class="contact-info">
            <h2>Outras formas de contato</h2>
            <p><strong>E-mail:</strong> contato@eidstore.com.br</p>
            <p><strong>Telefone:</strong> (11) 4002-8922</p>
            <p><strong>Horário de atendimento:</strong> Segunda a sexta, das 9h às 18h</p>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>