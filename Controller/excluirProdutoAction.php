<?php
session_start();
require_once 'conexaoBD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar se o ID do produto foi enviado
    if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
        die('ID do produto não informado.');
    }

    $produto_id = intval($_POST['codigo']);

    // Primeiro, pegar os nomes das imagens do produto
    $sql_select = "SELECT imagem, imagem_2, imagem_3 FROM Produto WHERE ID_produto = ?";
    $stmt_select = $conexao->prepare($sql_select);
    $stmt_select->bind_param("i", $produto_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows === 0) {
        $stmt_select->close();
        die("Produto não encontrado para exclusão.");
    }

    $row = $result->fetch_assoc();
    $stmt_select->close();

    // Caminho da pasta de imagens - ajuste caso seja diferente
    $uploads_dir = '../public/uploads/';

    // Array com os nomes dos arquivos
    $imagens = [$row['imagem'], $row['imagem_2'], $row['imagem_3']];

    // Apagar arquivos se existirem
    foreach ($imagens as $img) {
        if (!empty($img)) {
            $filepath = $uploads_dir . $img;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        }
    }

    // Agora excluir o produto do banco
    $sql_delete = "DELETE FROM Produto WHERE ID_produto = ?";
    $stmt_delete = $conexao->prepare($sql_delete);
    if (!$stmt_delete) {
        die("Erro na preparação da query: " . $conexao->error);
    }
    $stmt_delete->bind_param("i", $produto_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Produto excluído com sucesso!'); window.location.href='../view/cadastro.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao excluir produto: " . addslashes($stmt_delete->error) . "'); window.history.back();</script>";
        exit;
    }
} else {
    die("Método inválido.");
}
?>
