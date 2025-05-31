<?php
require_once('../Model/Contato.php');
require_once('../Model/Pessoa.php');

$title = "Mensagens de Contato - EID Store";

// Busca todas as mensagens de contato
function listarMensagensDeContato() {
    include(__DIR__ . '/../Model/conexaoBD.php');
    $sql = "SELECT c.ID_contato, c.assunto, c.mensagem, c.data_envio, p.nome, p.email
            FROM Contato c
            JOIN Pessoa p ON c.ID_pessoa = p.ID_pessoa
            ORDER BY c.data_envio DESC";
    $result = $conexao->query($sql);

    $mensagens = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mensagens[] = $row;
        }
    }
    $conexao->close();
    return $mensagens;
}

$mensagens = listarMensagensDeContato();
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
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .contact-main {
            min-height: 100vh;
            padding: 50px 20px;
            background-color: #fff;
        }
        .mensagens-card {
            background-color: #fff;
            max-width: 900px;
            margin: 0 auto 35px auto;
            padding: 40px 32px 30px 32px;
            border-radius: 10px;
            box-shadow: 0 6px 46px #0002;
            border: 1px solid #fff;
        }
        .mensagens-card h2 {
            text-align: center;
            color: #820AD1;
            margin-bottom: 28px;
            font-size: 2em;
            font-weight: 700;
        }
        .mensagens-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }
        .mensagens-table th, .mensagens-table td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .mensagens-table th {
            background-color: #f7f4fd;
            color: #820AD1;
            font-weight: 600;
            font-size: 1em;
        }
        .mensagens-table td {
            color: #2e235c;
            font-size: 1em;
        }
        .assunto-tag {
            background: #ece0fd;
            color: #820AD1;
            padding: 2px 10px;
            border-radius: 7px;
            font-size: 0.99em;
            display: inline-block;
            margin-right: 5px;
        }
        .mensagem-box {
            background: #f7f4fd;
            border-radius: 6px;
            padding: 10px;
            color: #2e235c;
            margin-bottom: 0;
            word-break: break-word;
        }
        @media (max-width: 900px) {
            .mensagens-card {
                max-width: 98vw;
                padding: 16px 2vw;
            }
            .mensagens-table, .mensagens-table th, .mensagens-table td {
                font-size: 0.98em;
            }
        }
        @media (max-width: 600px) {
            .mensagens-table th, .mensagens-table td {
                padding: 8px 4px;
            }
        }
    </style>
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