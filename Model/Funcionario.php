<?php
class Funcionario
{
    public static function cadastrar($nome, $registro, $telefone, $senha, $confirmar_senha)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');

        if ($senha !== $confirmar_senha) {
            return ['success' => false, 'message' => 'As senhas não coincidem.'];
        }

        $stmtVerifica = $conexao->prepare("SELECT registro FROM Funcionario WHERE registro = ?");
        $stmtVerifica->bind_param("s", $registro);
        $stmtVerifica->execute();
        $resultadoVerifica = $stmtVerifica->get_result();
        if ($resultadoVerifica->num_rows > 0) {
            $stmtVerifica->close();
            $conexao->close();
            return ['success' => false, 'message' => 'Erro: Registro já existente no sistema.'];
        }
        $stmtVerifica->close();

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmtPessoa = $conexao->prepare("INSERT INTO Pessoa (nome, telefone) VALUES (?, ?)");
        $stmtPessoa->bind_param("ss", $nome, $telefone);

        if ($stmtPessoa->execute()) {
            $idPessoa = $stmtPessoa->insert_id;
            $cargo = "Funcionário";
            $salario = 0.0;
            $dataAdmissao = date('Y-m-d');

            $stmtFuncionario = $conexao->prepare("INSERT INTO Funcionario (ID_funcionario, cargo, salario, dataAdmissao, registro, senha) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtFuncionario->bind_param("isdsss", $idPessoa, $cargo, $salario, $dataAdmissao, $registro, $senha_hash);

            if ($stmtFuncionario->execute()) {
                $stmtFuncionario->close();
                $stmtPessoa->close();
                $conexao->close();
                return ['success' => true, 'message' => 'Funcionário cadastrado com sucesso!'];
            } else {
                $stmtFuncionario->close();
                $stmtPessoa->close();
                $conexao->close();
                return ['success' => false, 'message' => 'Erro ao cadastrar funcionário.'];
            }
        } else {
            $stmtPessoa->close();
            $conexao->close();
            return ['success' => false, 'message' => 'Erro ao cadastrar pessoa.'];
        }
    }

    public static function autenticar($registro, $senha)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $stmt = $conexao->prepare("SELECT ID_funcionario, senha FROM Funcionario WHERE registro = ?");
        $stmt->bind_param("s", $registro);
        $stmt->execute();
        $result = $stmt->get_result();
        $linha = $result->fetch_assoc();
        $stmt->close();
        $conexao->close();

        if ($linha && password_verify($senha, $linha['senha'])) {
            return ['success' => true, 'id_funcionario' => $linha['ID_funcionario']];
        } else {
            return ['success' => false];
        }
    }
}
