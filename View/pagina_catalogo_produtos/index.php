<?php 
// Define o título da página
$title = "EID Store"; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade para dispositivos móveis -->
    <title><?php echo $title; ?></title> <!-- Insere o título da página dinâmico -->
    <link rel="stylesheet" href="style.css"> <!-- Conecta o arquivo CSS -->
</head>

<body>
    <!-- Cabeçalho do site -->
    <header class="header">
        <div class="top-header"> <!-- Seção superior do cabeçalho -->
            <img src="images/eid_store_logo.png" alt="EID Store Logo" class="logo-img"> <!-- Logo da loja -->
            <div class="search-wrapper"> <!-- Wrapper da barra de pesquisa -->
                <div class="search-bar"> <!-- Barra de pesquisa -->
                    <select class="search-category"> <!-- Categoria de busca -->
                        <option>Todos</option>
                        <option>Eletrônicos</option>
                        <option>Roupas</option>
                    </select>
                    <input type="text" placeholder="Buscar produtos..."> <!-- Campo de busca -->
                    <button class="search-button">🔍</button> <!-- Botão de busca -->
                </div>
            </div>
            <div class="header-actions"> <!-- Área de ações do usuário -->
                <a href="#">Crie sua conta</a> <!-- Link para criar conta -->
                <button class="login-button">Entre</button> <!-- Botão de login -->
                <a href="#" aria-label="Carrinho de compras"> <!-- Ícone do carrinho -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                        <path d="M7 18c-1.104 0-2 .897-2 2s.896 2 2 2c1.103 0 2-.897 2-2s-.897-2-2-2zm10 0c-1.103 0-2 .897-2 2s.897 2 2 2c1.104 0 2-.897 2-2s-.896-2-2-2zm1.293-11.707l-1.086 5.434c-.098.489-.53.857-1.029.857h-8.535l-.389-2h7.863c.553 0 1-.447 1-1s-.447-1-1-1h-8.893l-.37-1.882c-.095-.484-.528-.828-1.025-.828h-1.807c-.553 0-1 .447-1 1s.447 1 1 1h.878l1.74 8.707c.096.485.528.829 1.025.829h9.645c.466 0 .868-.316.974-.769l1.374-6.869c.113-.564-.259-1.109-.823-1.223-.564-.113-1.109.259-1.223.823z"/>
                    </svg>
                </a>
            </div>
        </div>

    <!-- Campo de CEP + Navegação -->
    <div class="linha">
        <!-- Coluna 1 (CEP Input e Navegação) -->
        <div class="coluna">
            <div class="cep-wrapper">
                <div class="cep-input-group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cep-icon" viewBox="0 0 24 24" fill="none" stroke="#820AD1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 6-9 13-9 13S3 16 3 10a9 9 0 1 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <input type="text" placeholder="Informe seu CEP" class="input-cep">
                </div>
            </div>
        </div>
        <!-- Coluna 2 -->
        <div class="coluna">
            <!-- Navegação Principal -->
            <nav class="bottom-nav">
                <a href="#">Categorias</a>
                <a href="#">Ofertas</a>
            </nav>
        </div>
  
        <!-- Coluna 3 -->
        <div class="coluna">
        </div>
    </div>

    </header>

        <!-- Banner Carrossel -->
        <section class="banner">
            <div class="carousel">
                <img src="images/banner-maes.png" class="slide active" alt="Banner 1">
                    <img src="images/banner-junino.png" class="slide" alt="Banner 2">
            </div>
        </section>
        <script src="scripts.js"></script>

    <!-- Produtos em destaque -->
    <section class="products product-list">
        <div class="product-card">
            <img src="images/iphone12.png" alt="iPhone 12">
            <h3>Iphone 12 128GB</h3>
            <p>R$ 3.374,10</p>
            <small>em 12x sem juros de R$ 281,18</small>
        </div>

        <div class="product-card">
            <img src="images/perfume.png" alt="Perfume Lancôme">
            <h3>La Vie Est Belle Lancôme</h3>
            <p>R$ 1.449,80</p>
            <small>10x sem juros de R$ 144,98</small>
        </div>

        <div class="product-card">
            <img src="images/tenis.png" alt="Tênis Olympikus">
            <h3>Tênis Feminino Olympikus Luna</h3>
            <p>R$ 149,90</p>
            <small>8x sem juros de R$ 18,74</small>
        </div>

        <div class="product-card">
            <img src="images/relogio.png" alt="Relógio Dourado">
            <h3>Relógio Feminino Espelhado Dourado</h3>
            <p>R$ 459,00</p>
            <small>9x sem juros de R$ 51,00</small>
        </div>
    </section>

    <!-- Categorias -->
    <section class="categories">
    <h2>Categorias</h2>
    <div class="linha">
        <!-- Coluna 1 (CEP Input e Navegação) -->
        <div class="category">
            <img src="images/smartphone.png" alt="Smartphones">
            <h3>Smartphones</h3>
            <p>Os melhores smartphones estão aqui na EID Store!</p>
        </div>
        <!-- Coluna 2 -->
        <div class="category">
            <img src="images/cama-mesa-banho.png" alt="Cama, Mesa e Banho">
            <h3>Cama, mesa e banho</h3>
            <p>Encontre produtos exclusivos!</p>
        </div>
  
        <!-- Coluna 3 -->
        <div class="category">
            <img src="images/eletrodomesticos.png" alt="Eletrodomésticos">
            <h3>Eletrodomésticos</h3>
            <p>As melhores ofertas de eletrodomésticos que a sua casa precisa!</p>
        </div>
    </div>
    </section>

<!-- Rodapé -->
<footer class="footer">
    <div class="footer-links">
        <div class="linha">
            <!-- Coluna 1 -->
            <div class="coluna">
                <p>Condições de Uso</p>
            </div>
            <!-- Coluna 2 -->
            <div class="coluna">
                <p>Política de Privacidade</p>
            </div>
            <!-- Coluna 3 -->
            <div class="coluna">
                <p>Ajuda</p>
            </div>
            <!-- Coluna 4 -->
            <div class="coluna">
                <p>Cookies</p>
            </div>
        </div>

        <!-- Texto abaixo das colunas -->
        <p>2025 - ETEC: Curso Técnico em Desenvolvimento de Sistemas - Turma: EID - Grupo 1</p>
    </div>
</footer>
</body>
</html>