-- Modelagem das estruturas do banco de dados

CREATE DATABASE IF NOT EXISTS site_de_vendas;
USE site_de_vendas;

CREATE TABLE IF NOT EXISTS Pessoa (
    ID_pessoa INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    sobrenome VARCHAR(100),
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

CREATE TABLE IF NOT EXISTS Funcionario (
    ID_funcionario INT PRIMARY KEY,
    cargo VARCHAR(50),
    salario FLOAT,
    dataAdmissao DATE,
    registro VARCHAR(50),
    senha VARCHAR(100),
    FOREIGN KEY (ID_funcionario) REFERENCES Pessoa(ID_pessoa)
);

CREATE TABLE IF NOT EXISTS Cliente (
    ID_cliente INT PRIMARY KEY,
    preferencias VARCHAR(100),
    historicoCompras VARCHAR(255),
    FOREIGN KEY (ID_cliente) REFERENCES Pessoa(ID_pessoa)
);

CREATE TABLE IF NOT EXISTS Proprietario (
    ID_proprietario INT PRIMARY KEY,
    empresa VARCHAR(100),
    dataRegistro DATE,
    FOREIGN KEY (ID_proprietario) REFERENCES Pessoa(ID_pessoa)
);

CREATE TABLE IF NOT EXISTS Categoria (
    ID_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

CREATE TABLE IF NOT EXISTS Produto (
    ID_produto INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    preco FLOAT,
    qtdEstoque INT,
    ID_categoria INT,
    descricao VARCHAR(255),
    imagem VARCHAR(255),
    imagem_2 VARCHAR(255),
    imagem_3 VARCHAR(255),
    FOREIGN KEY (ID_categoria) REFERENCES Categoria(ID_categoria)
);

CREATE TABLE IF NOT EXISTS Carrinho (
    ID_carrinho INT PRIMARY KEY AUTO_INCREMENT,
    ID_cliente INT,
    produtos VARCHAR(255),
    FOREIGN KEY (ID_cliente) REFERENCES Cliente(ID_cliente)
);

CREATE TABLE IF NOT EXISTS Carrinho_Produto (
    ID_carrinho INT,
    ID_produto INT,
    quantidade INT,
    PRIMARY KEY (ID_carrinho, ID_produto),
    FOREIGN KEY (ID_carrinho) REFERENCES Carrinho(ID_carrinho),
    FOREIGN KEY (ID_produto) REFERENCES Produto(ID_produto)
);

CREATE TABLE IF NOT EXISTS Pedido (
    ID_pedido INT PRIMARY KEY AUTO_INCREMENT,
    data DATE,
    status VARCHAR(30),
    metodoPagamento VARCHAR(30), 
    parcelas INT DEFAULT NULL,
    qtdDeProduto INT,
    precoUnitario FLOAT,
    precoTotal FLOAT,
    ID_cliente INT,
    FOREIGN KEY (ID_cliente) REFERENCES Cliente(ID_cliente)
);

CREATE TABLE IF NOT EXISTS item_pedido (
    ID_item INT AUTO_INCREMENT PRIMARY KEY,
    ID_pedido INT NOT NULL,
    ID_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (ID_pedido) REFERENCES Pedido(ID_pedido),
    FOREIGN KEY (ID_produto) REFERENCES Produto(ID_produto)
);

CREATE TABLE IF NOT EXISTS MetodoPagamento (
    ID_metodo INT PRIMARY KEY AUTO_INCREMENT,
    cartaoDebito VARCHAR(30),
    cartaoCredito VARCHAR(30),
    chavePix VARCHAR(50),
    boleto VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Sistema (    
    versao FLOAT,
    nome VARCHAR(100),
    anoDeCriacao DATE,
    criador VARCHAR(100),
    usuarioAtual INT,
    FOREIGN KEY (usuarioAtual) REFERENCES Pessoa(ID_pessoa)
);