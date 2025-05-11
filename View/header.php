<header class="header">
    <div class="top-header">

        <!-- Logo -->
        <img src="images/eid_store_logo.png" alt="EID Store Logo" class="logo-img">

        <!-- Busca -->
        <!-- Wrapper da barra de pesquisa -->
        <div class="search-wrapper"> 
            <!-- Barra de pesquisa -->
            <div class="search-bar"> 
                    <!-- Categoria de busca -->
                    <select class="search-category"> 
                        <option>Todos</option>
                        <option>Eletrônicos</option>
                        <option>Roupas</option>
                    </select>
                    <!-- Campo de busca -->
                    <input type="text" placeholder="Buscar produtos..."> 
                    <!-- Botão de busca -->
                    <button class="search-button">🔍</button> 
                </div>
            </div>

            <!-- Área de ações do usuário (Conta e login)-->
            <div class="header-actions"> 
                <!-- Link para criar conta -->
                <a href="criar_conta.php">Crie sua conta</a> 
                <!-- Botão de login -->
                <button class="login-button" onclick="window.location.href='pagina_login.php'">Entre</button> 
                <!-- Ícone do carrinho -->
                <a href="#" aria-label="Carrinho de compras"> 
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
                    <a href="#categorias">Categorias</a>
                    <a href="#">Ofertas</a>
                </nav>
            </div>
  
            <!-- Coluna 3 -->
            <div class="coluna">
            </div>
        </div>
</header>