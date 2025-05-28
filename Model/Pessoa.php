<?php 
class Pessoa
{
    public static function cadastrar($nome, $email, $telefone, $senha, $confirmar_senha)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');

        if ($senha !== $confirmar_senha) {
            return ['success' => false, 'message' => 'As senhas não coincidem!'];
        }

        $stmt = $conexao->prepare("SELECT ID_pessoa FROM pessoa WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            $conexao->close();
            return ['success' => false, 'message' => 'E-mail já cadastrado no sistema!'];
        }
        $stmt->close();

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conexao->prepare("INSERT INTO pessoa (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $telefone, $senha_hash);

        $resultado = $stmt->execute();

        $stmt->close();
        $conexao->close();

        if ($resultado) {
            return ['success' => true, 'message' => 'Cadastro realizado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao cadastrar!'];
        }
    }

    public static function autenticar($email, $senha)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');

        $stmt = $conexao->prepare("SELECT ID_pessoa, nome, senha FROM pessoa WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $linha = $result->fetch_assoc();

        $stmt->close();
        $conexao->close();

        if ($linha && password_verify($senha, $linha['senha'])) {
            return [
                'success' => true,
                'id' => $linha['ID_pessoa'],
                'nome' => $linha['nome']
            ];
        } else {
            return ['success' => false];
        }
    }
}
