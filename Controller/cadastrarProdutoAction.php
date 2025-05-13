<?php
session_start();
require_once('conexaoBD.php');

// Receber os dados do formulário
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$categoriaNome = $_POST['categoria'];
$preco = floatval($_POST['preco']);
$quantidade = intval($_POST['quantidade']);

// Verifica se a categoria já existe
$stmtCat = $conexao->prepare("SELECT ID_categoria FROM Categoria WHERE nome = ?");
$stmtCat->bind_param("s", $categoriaNome);
$stmtCat->execute();
$resultCat = $stmtCat->get_result();
$categoria = $resultCat->fetch_assoc();

if ($categoria) {
    $idCategoria = $categoria['ID_categoria'];
} else {
    // Cria nova categoria
    $descCatVazia = "";
    $stmtInsertCat = $conexao->prepare("INSERT INTO Categoria (nome, descricao) VALUES (?, ?)");
    $stmtInsertCat->bind_param("ss", $categoriaNome, $descCatVazia);
    $stmtInsertCat->execute();
    $idCategoria = $stmtInsertCat->insert_id;
    $stmtInsertCat->close();
}
$stmtCat->close();

// Manipular imagens (até 3)
$imagens = $_FILES['imagens'];
$caminhosImagens = ["", "", ""];

$diretorioDestino = "../public/uploads/";

for ($i = 0; $i < min(3, count($imagens['name'])); $i++) {
    if ($imagens['error'][$i] === UPLOAD_ERR_OK) {
        $nomeOriginal = $imagens['name'][$i];

        // Limpa o nome do arquivo
        $nomeSeguro = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $nomeOriginal);

        $extensao = pathinfo($nomeSeguro, PATHINFO_EXTENSION);
        $nomeFinal = uniqid("img_", true) . '.' . $extensao;
        $caminhoFinal = $diretorioDestino . $nomeFinal;

        if (move_uploaded_file($imagens['tmp_name'][$i], $caminhoFinal)) {
            $caminhosImagens[$i] = $nomeFinal; // Salva apenas o nome do arquivo, não o caminho completo
        }
    }
}

// Inserir o produto
$stmtProd = $conexao->prepare("INSERT INTO Produto (nome, preco, qtdEstoque, ID_categoria, descricao, imagem, imagem_2, imagem_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmtProd->bind_param("sdiissss", $nome, $preco, $quantidade, $idCategoria, $descricao, $caminhosImagens[0], $caminhosImagens[1], $caminhosImagens[2]);

if ($stmtProd->execute()) {
    echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href='../View/cadastro.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar produto.'); window.history.back();</script>";
}

$stmtProd->close();
$conexao->close();
?>
