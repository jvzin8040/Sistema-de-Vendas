-- Modelagem das estruturas do banco de dados 

CREATE DATABASE Site_de_Vendas;

USE Site_de_Vendas;

CREATE TABLE Pessoa (
    ID_pessoa INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100),
    senha VARCHAR(100),
    dataNascimento DATE,
    logradouro VARCHAR(100),
    numero INT,
    bairro VARCHAR(50),
    complemento VARCHAR(50),
    cidade VARCHAR(50),
    uf CHAR(2),
    cep VARCHAR(10),
    telefone VARCHAR(15),
    rg VARCHAR(20),
    cpf VARCHAR(14),
    cnpj VARCHAR(18)
);

CREATE TABLE Funcionario (
    ID_funcionario INT PRIMARY KEY,
    cargo VARCHAR(50),
    salario FLOAT,
    dataAdmissao DATE,
    login VARCHAR(50),
    senha VARCHAR(100),
    FOREIGN KEY (ID_funcionario) REFERENCES Pessoa(ID_pessoa)
);

CREATE TABLE Cliente (
    ID_cliente INT PRIMARY KEY,
    preferencias VARCHAR(100),
    historicoCompras VARCHAR(255),
    FOREIGN KEY (ID_cliente) REFERENCES Pessoa(ID_pessoa)
);

CREATE TABLE Proprietario (
    ID_proprietario INT PRIMARY KEY,
    empresa VARCHAR(100),
    dataRegistro DATE,
    FOREIGN KEY (ID_proprietario) REFERENCES Pessoa(ID_pessoa)
);

CREATE TABLE Produto (
    ID_produto INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    preco FLOAT,
    qtdEstoque INT
    categoria VARCHAR(50), 
    descricao VARCHAR(255),
);
-- adicionado campo categoria e descricao para o produto

CREATE TABLE Carrinho (
    ID_carrinho INT PRIMARY KEY AUTO_INCREMENT,
    ID_cliente INT,
    produtos VARCHAR(255),
    FOREIGN KEY (ID_cliente) REFERENCES Cliente(ID_cliente)
);

CREATE TABLE Carrinho_Produto (
    ID_carrinho INT,
    ID_produto INT,
    quantidade INT,
    PRIMARY KEY (ID_carrinho, ID_produto),
    FOREIGN KEY (ID_carrinho) REFERENCES Carrinho(ID_carrinho),
    FOREIGN KEY (ID_produto) REFERENCES Produto(ID_produto)
);

CREATE TABLE Pedido (
    ID_pedido INT PRIMARY KEY AUTO_INCREMENT,
    data DATE,
    status VARCHAR(30),
    qtdDeProduto INT,
    precoUnitario FLOAT,
    precoTotal FLOAT,
    ID_cliente INT,
    FOREIGN KEY (ID_cliente) REFERENCES Cliente(ID_cliente)
);

CREATE TABLE MetodoPagamento (
    ID_metodo INT PRIMARY KEY AUTO_INCREMENT,
    cartaoDebito VARCHAR(30),
    cartaoCredito VARCHAR(30),
    chavePix VARCHAR(50),
    boleto VARCHAR(50)
);

CREATE TABLE Sistema (    
    versao FLOAT,
    nome VARCHAR(100),
    anoDeCriacao DATE,
    criador VARCHAR(100),
    usuarioAtual INT,
    FOREIGN KEY (usuarioAtual) REFERENCES Pessoa(ID_pessoa)
);
