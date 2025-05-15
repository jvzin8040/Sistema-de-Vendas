<header>
    <h1>🛒 Sistema de Vendas EID Store</h1>
    <p>Um sistema de vendas simples e funcional.</p>
</header>

  <h2>📋 Funcionalidades</h2>
    <ul>
        <li>✅ Cadastro de produtos com nome, categoria, preço, estoque e imagem, permitindo gerenciamento direto pelo administrador.</li>
        <li>✅ Registro de clientes com nome, email, telefone e endereço para acompanhamento de compras.</li>
        <li>✅ Carrinho de compras dinâmico, onde os clientes podem adicionar, remover e atualizar quantidades de produtos.</li>
        <li>✅ Finalização de compras com cálculo automático do valor total, incluindo taxas e descontos aplicáveis.</li>
        <li>✅ Histórico de compras para clientes, permitindo visualização de pedidos anteriores.</li>      
        <li>✅ Sistema de login para administrador, garantindo acesso seguro às funcionalidades de gerenciamento.</li>
    </ul>
    <h2> 🛠️ Tecnologias Utilizadas</h2>
    <ul>
        <li><strong>Backend:</strong> PHP</li>
        <li><strong>Frontend:</strong> HTML, CSS, JavaScript</li>
        <li><strong>Banco de Dados:</strong> MySQL</li>
    </ul>
    <h2>🚀 Como Executar o Projeto</h2>
   


1. Clone o repositório:
   ```html
   git clone https://github.com/jvzin8040/Sistema-de-Vendas
   ```

2. Importe o banco de dados ###.sql para o seu servidor MySQL:

```html

CREATE DATABASE site_de_vendas;

USE site_de_vendas;

CREATE TABLE Pessoa (
    ID_pessoa INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    sobrenome VARCHAR(100), -- adicionado sobrenome
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
    registro VARCHAR(50),
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

CREATE TABLE Categoria (
    ID_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);
-- adicionado nova tabela categoria para o produto

CREATE TABLE Produto (
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
-- adicionado nova tabela categoria e imagens para o produto

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

```

3. Configure o arquivo conexãoBD.php com as credenciais do seu banco de dados.

4. Faça a configuração inicial do servidor:

```html

###

```

5. Inicie o servidor local (XAMPP, WAMP) e acesse:
   http://localhost/Sistema-de-Vendas/
    </pre>

    <h2>📸 Capturas de Tela</h2>
    <p>**</p>

    <h2>📄 Licença</h2>
    <p>Este projeto está sob a licença ###. Consulte o arquivo LICENSE para mais informações.</p>


<footer>
    <p>Desenvolvido por # | <a href="https://github.com/jvzin8040/Sistema-de-Vendas">GitHub</a></p>
</footer>
