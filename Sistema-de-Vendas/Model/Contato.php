<?php
class Contato
{
    public static function salvar($id_pessoa, $assunto, $mensagem)
    {
        include(__DIR__ . '/../Model/conexaoBD.php');
        $stmt = $conexao->prepare("INSERT INTO Contato (ID_pessoa, assunto, mensagem) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_pessoa, $assunto, $mensagem);
        $ok = $stmt->execute();
        $stmt->close();
        $conexao->close();
        return $ok;
    }



    
}