<?php
require_once 'conexaoBD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar se o ID do produto foi enviado
    if (!isset($_POST['produto_id']) || empty($_POST['produto_id'])) {
        die('ID do produto não informado.');
    }

    $produto_id = intval($_POST['produto_id']);
    $nome = isset($_POST['nome']) ? $conexao->real_escape_string($_POST['nome']) : '';
    $descricao = isset($_POST['descricao']) ? $conexao->real_escape_string($_POST['descricao']) : '';
    $categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : null;
    $preco = isset($_POST['preco']) ? floatval($_POST['preco']) : 0;
    $quantidade = isset($_POST['quantidade']) ? intval($_POST['quantidade']) : 0;

    // Verificar dados obrigatórios mínimos
    if (empty($nome) || empty($descricao) || $categoria === null) {
        die('Por favor, preencha todos os campos obrigatórios.');
    }

    // Inicializa variáveis para colunas de imagens
    $caminhosImagens = ["", "", ""];

    // Processa arquivos enviados (imagens)
    if (isset($_FILES['imagens']) && count($_FILES['imagens']['name']) > 0) {
        $uploads_dir = '../public/uploads/';
        // Criar pasta se não existir
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        $imagens = $_FILES['imagens'];

        // Limitar a até 3 imagens para os campos imagem, imagem_2, imagem_3
        for ($i = 0; $i < min(3, count($imagens['name'])); $i++) {
            if ($imagens['error'][$i] === UPLOAD_ERR_OK) {
                $nomeOriginal = $imagens['name'][$i];

                // Limpa o nome do arquivo
                $nomeSeguro = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $nomeOriginal);

                $extensao = pathinfo($nomeSeguro, PATHINFO_EXTENSION);
                $nomeFinal = uniqid("img_", true) . '.' . $extensao;
                $caminhoFinal = $uploads_dir . $nomeFinal;

                if (move_uploaded_file($imagens['tmp_name'][$i], $caminhoFinal)) {
                    $caminhosImagens[$i] = $nomeFinal; // Salva apenas o nome do arquivo, não o caminho completo
                }
            }
        }
    }

    // Montar SQL de atualização
    $sql = "UPDATE Produto SET nome = ?, descricao = ?, ID_categoria = ?, preco = ?, qtdEstoque = ?";

    // Adicionar imagens ao SQL se foram enviadas
    if ($caminhosImagens[0] !== "") {
        $sql .= ", imagem = ?";
    }
    if ($caminhosImagens[1] !== "") {
        $sql .= ", imagem_2 = ?";
    }
    if ($caminhosImagens[2] !== "") {
        $sql .= ", imagem_3 = ?";
    }

    $sql .= " WHERE ID_produto = ?";

    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . $conexao->error);
    }

    // Montar parâmetros dinamicamente
    $types = "sssdi";
    $params = [$nome, $descricao, $categoria, $preco, $quantidade];

    if ($caminhosImagens[0] !== "") {
        $types .= "s";
        $params[] = $caminhosImagens[0];
    }
    if ($caminhosImagens[1] !== "") {
        $types .= "s";
        $params[] = $caminhosImagens[1];
    }
    if ($caminhosImagens[2] !== "") {
        $types .= "s";
        $params[] = $caminhosImagens[2];
    }

    $types .= "i";
    $params[] = $produto_id;

    // Vincular parâmetros


    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        // Exibir mensagem de sucesso
        echo "<script>alert('Produto editado com sucesso!'); window.location.href='../view/cadastro.php';</script>";
        exit;
    } else {
        // Exibir mensagem de erro
        echo "<script>alert('Erro ao atualizar produto: " . addslashes($stmt->error) . "'); window.history.back();</script>";
        exit;
    }
}
