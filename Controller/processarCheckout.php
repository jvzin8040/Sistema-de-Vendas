<?php
include '../Model/conexaoBD.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $rg = $_POST["rg"];
    $cpf_cnpj = $_POST["cpf_cnpj"];
    $logradouro = $_POST["logradouro"];
    $numero = $_POST["numero"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $cep = $_POST["cep"];
    $uf = $_POST["uf"];

    $sql = "INSERT INTO pedidos (nome, rg, cpf_cnpj, logradouro, numero, bairro, cidade, cep, uf)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $nome, $rg, $cpf_cnpj, $logradouro, $numero, $bairro, $cidade, $cep, $uf);
    $stmt->execute();

    header("Location: ../View/pedido_concluido.php");
    exit();
}
?>