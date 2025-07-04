<?php
class Produto
{
    public static function listarTodos()
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $sql = "SELECT ID_produto, nome, preco, qtdEstoque, imagem FROM Produto ORDER BY nome ASC";
        $result = $conexao->query($sql);
        $produtos = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $produtos[] = $row;
            }
        }
        return $produtos;
    }

    public static function listarCategorias()
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $sql = "SELECT ID_categoria, nome, imagem FROM Categoria";
        $result = $conexao->query($sql);
        $categorias = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row;
            }
        }
        return $categorias;
    }

    public static function buscarPorId($id)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $stmt = $conexao->prepare("SELECT p.*, c.nome AS categoria_nome FROM Produto p JOIN Categoria c ON p.ID_categoria = c.ID_categoria WHERE ID_produto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public static function cadastrar($nome, $descricao, $categoriaNome, $preco, $quantidade, $imagens)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');

        $stmtCat = $conexao->prepare("SELECT ID_categoria FROM Categoria WHERE nome = ?");
        $stmtCat->bind_param("s", $categoriaNome);
        $stmtCat->execute();
        $resultCat = $stmtCat->get_result();
        $categoria = $resultCat->fetch_assoc();
        if ($categoria) {
            $idCategoria = $categoria['ID_categoria'];
        } else {
            $descCatVazia = "";
            $stmtInsertCat = $conexao->prepare("INSERT INTO Categoria (nome, descricao) VALUES (?, ?)");
            $stmtInsertCat->bind_param("ss", $categoriaNome, $descCatVazia);
            $stmtInsertCat->execute();
            $idCategoria = $stmtInsertCat->insert_id;
            $stmtInsertCat->close();
        }
        $stmtCat->close();

        $caminhosImagens = ["", "", ""];
        $diretorioDestino = "../public/uploads/";
        for ($i = 0; $i < min(3, count($imagens['name'])); $i++) {
            if ($imagens['error'][$i] === UPLOAD_ERR_OK) {
                $nomeOriginal = $imagens['name'][$i];
                $nomeSeguro = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $nomeOriginal);
                $extensao = pathinfo($nomeSeguro, PATHINFO_EXTENSION);
                $nomeFinal = uniqid("img_", true) . '.' . $extensao;
                $caminhoFinal = $diretorioDestino . $nomeFinal;
                if (move_uploaded_file($imagens['tmp_name'][$i], $caminhoFinal)) {
                    $caminhosImagens[$i] = $nomeFinal;
                }
            }
        }

        $stmtProd = $conexao->prepare("INSERT INTO Produto (nome, preco, qtdEstoque, ID_categoria, descricao, imagem, imagem_2, imagem_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtProd->bind_param("sdiissss", $nome, $preco, $quantidade, $idCategoria, $descricao, $caminhosImagens[0], $caminhosImagens[1], $caminhosImagens[2]);
        $ok = $stmtProd->execute();
        $stmtProd->close();
        $conexao->close();
        return $ok;
    }

    public static function editar($produto_id, $nome, $descricao, $categoria, $preco, $quantidade, $imagens = null)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');

        if (empty($nome) || empty($descricao) || $categoria === null) {
            return ['success' => false, 'message' => 'Por favor, preencha todos os campos obrigatórios.'];
        }

        $caminhosImagens = ["", "", ""];
        if ($imagens && count($imagens['name']) > 0) {
            $uploads_dir = '../public/uploads/';
            if (!is_dir($uploads_dir)) {
                mkdir($uploads_dir, 0777, true);
            }
            for ($i = 0; $i < min(3, count($imagens['name'])); $i++) {
                if ($imagens['error'][$i] === UPLOAD_ERR_OK) {
                    $nomeOriginal = $imagens['name'][$i];
                    $nomeSeguro = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $nomeOriginal);
                    $extensao = pathinfo($nomeSeguro, PATHINFO_EXTENSION);
                    $nomeFinal = uniqid("img_", true) . '.' . $extensao;
                    $caminhoFinal = $uploads_dir . $nomeFinal;
                    if (move_uploaded_file($imagens['tmp_name'][$i], $caminhoFinal)) {
                        $caminhosImagens[$i] = $nomeFinal;
                    }
                }
            }
        }

        $sql = "UPDATE Produto SET nome = ?, descricao = ?, ID_categoria = ?, preco = ?, qtdEstoque = ?";
        if ($caminhosImagens[0] !== "") $sql .= ", imagem = ?";
        if ($caminhosImagens[1] !== "") $sql .= ", imagem_2 = ?";
        if ($caminhosImagens[2] !== "") $sql .= ", imagem_3 = ?";
        $sql .= " WHERE ID_produto = ?";

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

        $stmt = $conexao->prepare($sql);
        if (!$stmt) {
            return ['success' => false, 'message' => "Erro na preparação da query: " . $conexao->error];
        }
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $stmt->close();
            $conexao->close();
            return ['success' => true, 'message' => 'Produto editado com sucesso!'];
        } else {
            $msg = $stmt->error;
            $stmt->close();
            $conexao->close();
            return ['success' => false, 'message' => "Erro ao atualizar produto: " . addslashes($msg)];
        }
    }

    public static function excluir($produto_id)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');

        $sql_select = "SELECT imagem, imagem_2, imagem_3 FROM Produto WHERE ID_produto = ?";
        $stmt_select = $conexao->prepare($sql_select);
        $stmt_select->bind_param("i", $produto_id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        if ($result->num_rows === 0) {
            $stmt_select->close();
            $conexao->close();
            return ['success' => false, 'message' => 'Produto não encontrado para exclusão.'];
        }

        $row = $result->fetch_assoc();
        $stmt_select->close();

        $uploads_dir = '../public/uploads/';
        $imagens = [$row['imagem'], $row['imagem_2'], $row['imagem_3']];
        foreach ($imagens as $img) {
            if (!empty($img)) {
                $filepath = $uploads_dir . $img;
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
        }

        $sql_delete = "DELETE FROM Produto WHERE ID_produto = ?";
        $stmt_delete = $conexao->prepare($sql_delete);
        if (!$stmt_delete) {
            $conexao->close();
            return ['success' => false, 'message' => "Erro na preparação da query: " . $conexao->error];
        }
        $stmt_delete->bind_param("i", $produto_id);

        if ($stmt_delete->execute()) {
            $stmt_delete->close();
            $conexao->close();
            return ['success' => true, 'message' => 'Produto excluído com sucesso!'];
        } else {
            $msg = $stmt_delete->error;
            $stmt_delete->close();
            $conexao->close();
            return ['success' => false, 'message' => "Erro ao excluir produto: " . addslashes($msg)];
        }
    }

    public static function buscarPorId2($id)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $sql = "SELECT ID_produto, nome, descricao, preco, qtdEstoque, ID_categoria, imagem FROM Produto WHERE ID_produto = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produto = $result->fetch_assoc();
        $stmt->close();
        $conexao->close();
        return $produto;
    }

    public static function buscarPorNome($nome)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $sql = "SELECT ID_produto, nome, preco, qtdEstoque, imagem FROM Produto WHERE nome LIKE ?";
        $stmt = $conexao->prepare($sql);
        $like = "%$nome%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $produtos = [];
        while ($row = $result->fetch_assoc()) {
            $produtos[] = $row;
        }
        $stmt->close();
        $conexao->close();
        return $produtos;
    }

    public static function buscarPorNomeECategoria($nome, $categoria)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $sql = "SELECT p.ID_produto, p.nome, p.preco, p.qtdEstoque, p.imagem
                FROM Produto p
                JOIN Categoria c ON p.ID_categoria = c.ID_categoria
                WHERE p.nome LIKE ?";
        $params = ["%$nome%"];
        $types = "s";
        if (!empty($categoria)) {
            $sql .= " AND c.nome = ?";
            $params[] = $categoria;
            $types .= "s";
        }
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $produtos = [];
        while ($row = $result->fetch_assoc()) {
            $produtos[] = $row;
        }
        $stmt->close();
        $conexao->close();
        return $produtos;
    }

    public static function criarCategoria($nome, $imagem = null)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        if ($imagem) {
            $stmt = $conexao->prepare("INSERT INTO Categoria (nome, imagem) VALUES (?, ?)");
            $stmt->bind_param("ss", $nome, $imagem);
        } else {
            $stmt = $conexao->prepare("INSERT INTO Categoria (nome) VALUES (?)");
            $stmt->bind_param("s", $nome);
        }
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }

    public static function editarCategoria($id, $nome, $imagem = null)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        if ($imagem) {
            $stmt = $conexao->prepare("UPDATE Categoria SET nome=?, imagem=? WHERE ID_categoria=?");
            $stmt->bind_param("ssi", $nome, $imagem, $id);
        } else {
            $stmt = $conexao->prepare("UPDATE Categoria SET nome=? WHERE ID_categoria=?");
            $stmt->bind_param("si", $nome, $id);
        }
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }

    public static function excluirCategoria($id)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $stmtBusca = $conexao->prepare("SELECT imagem FROM Categoria WHERE ID_categoria=?");
        $stmtBusca->bind_param("i", $id);
        $stmtBusca->execute();
        $result = $stmtBusca->get_result();
        if ($row = $result->fetch_assoc()) {
            if (!empty($row['imagem'])) {
                $filepath = "../public/uploads/" . $row['imagem'];
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
        }
        $stmtBusca->close();

        $stmt = $conexao->prepare("DELETE FROM Categoria WHERE ID_categoria=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }

    public static function buscarCategoriaPorId($id)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $stmt = $conexao->prepare("SELECT * FROM Categoria WHERE ID_categoria=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $categoria = $result->fetch_assoc();
        $stmt->close();
        $conexao->close();
        return $categoria;
    }

    public static function listarPorCategoria($categoriaNome)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $con = $conexao;
        $sql = "SELECT p.* FROM Produto p
            JOIN Categoria c ON p.ID_categoria = c.ID_categoria
            WHERE c.nome = ? ORDER BY nome ASC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $categoriaNome);
        $stmt->execute();
        $result = $stmt->get_result();
        $produtos = [];
        while ($row = $result->fetch_assoc()) {
            $produtos[] = $row;
        }
        $stmt->close();
        $con->close();
        return $produtos;
    }
}