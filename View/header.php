<?php
if (!isset($_SESSION)) {
    session_start();
}

// Buscar categorias do banco
require_once(__DIR__ . '/../Model/produto.php');
$categorias = Produto::listarCategorias();
?>

<header class="header">
    <div class="top-header">

        <!-- Logo -->
        <a href="../View/index.php">
            <img src="../View/images/eid_store_logo.png" alt="EID Store Logo" class="logo-img">
        </a>

        <!-- Busca -->
        <div class="search-wrapper">
            <div class="search-bar">
                <select class="search-category" id="search-categoria">
                    <option value="">Todos</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['nome']) ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" placeholder="Buscar produtos..." id="input-busca-produto" autocomplete="off">
                <button class="search-button">🔍</button>
            </div>
            <div id="resultado-busca-produto" class="search-results"></div>
        </div>

        <!-- Área de ações do usuário -->
        <div class="header-actions">
            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                <a href="minhaConta.php">Minha Conta</a>
                <a href="historicoPedido.php">Histórico de Pedidos</a>
                <!-- Ícone do carrinho -->
                <a href="carrinho.php" aria-label="Carrinho de compras">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                        <path d="M7 18c-1.104 0-2 .897-2 2s.896 2 2 2c1.103 0 2-.897 2-2s-.897-2-2-2zm10 0c-1.103 0-2 .897-2 2s.897 2 2 2c1.104 0 2-.897 2-2s-.896-2-2-2zm1.293-11.707l-1.086 5.434c-.098.489-.53.857-1.029.857h-8.535l-.389-2h7.863c.553 0 1-.447 1-1s-.447-1-1-1h-8.893l-.37-1.882c-.095-.484-.528-.828-1.025-.828h-1.807c-.553 0-1 .447-1 1s.447 1 1 1h.878l1.74 8.707c.096.485.528.829 1.025.829h9.645c.466 0 .868-.316.974-.769l1.374-6.869c.113-.564-.259-1.109-.823-1.223-.564-.113-1.109.259-1.223.823z" />
                    </svg>
                </a>
                <a href="#" class="login-button" onclick="confirmLogout('<?php echo addslashes($_SESSION['usuario_nome'] ?? 'usuario'); ?>')">Sair</a>
            <?php else: ?>
                <a href="criar_conta.php">Crie sua conta</a>
                <button class="login-button" onclick="window.location.href='pagina_login.php'">Entre</button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Campo de CEP + Navegação -->
    <div class="linha">
        <div class="coluna">
            <div class="cep-wrapper">
                <div class="cep-input-group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cep-icon" viewBox="0 0 24 24" fill="none" stroke="#820AD1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 6-9 13-9 13S3 16 3 10a9 9 0 1 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <input type="text" placeholder="Informe seu CEP" class="input-cep" id="header-cep" maxlength="9">
                </div>
            </div>
        </div>

        <div class="coluna">
            <nav class="bottom-nav">
                <a href="index.php#produtos">Produtos</a>
                <a href="index.php#categorias">Categorias</a>
                <a></a>
            </nav>
        </div>

        <div class="coluna"></div>
    </div>
</header>

<script>
    // Busca dinâmica de produtos com filtro de categoria + FIX de dropdown flutuante
    const inputBusca = document.getElementById('input-busca-produto');
    const selectCategoria = document.getElementById('search-categoria');
    const resultadoBusca = document.getElementById('resultado-busca-produto');

    function posicionarResultados() {
        const searchBar = document.querySelector('.search-bar');
        if (!searchBar || !resultadoBusca) return;
        const rect = searchBar.getBoundingClientRect();
        resultadoBusca.style.position = "fixed";
        resultadoBusca.style.left = rect.left + "px";
        resultadoBusca.style.top = rect.bottom + "px";
        resultadoBusca.style.width = rect.width + "px";
        resultadoBusca.style.margin = "0";
        resultadoBusca.style.right = "unset";
        resultadoBusca.style.zIndex = 9999;
        resultadoBusca.style.maxWidth = rect.width + "px";
    }

    if (inputBusca && resultadoBusca && selectCategoria) {
        inputBusca.addEventListener('input', fazerBusca);
        selectCategoria.addEventListener('change', fazerBusca);

        function fazerBusca() {
            const termo = inputBusca.value.trim();
            const categoria = selectCategoria.value;
            if (termo.length < 2) {
                resultadoBusca.innerHTML = '';
                resultadoBusca.style.display = 'none';
                return;
            }
            fetch(`../Controller/buscar_produto.php?q=${encodeURIComponent(termo)}&categoria=${encodeURIComponent(categoria)}`)
                .then(res => res.json())
                .then(produtos => {
                    if (!produtos.length) {
                        resultadoBusca.innerHTML = '<div class="no-result">Nenhum produto encontrado.</div>';
                        resultadoBusca.style.display = 'block';
                        posicionarResultados();
                        return;
                    }
                    resultadoBusca.innerHTML = produtos.map(prod => `
                    <div class="search-item" onclick="window.location.href='../View/exibirProduto.php?id=${prod.ID_produto}'">
                        <img src="../public/uploads/${prod.imagem ? prod.imagem : 'no-image.png'}" alt="" width="40" height="40">
                        <span>${prod.nome} - R$ ${Number(prod.preco).toFixed(2)}</span>
                    </div>
                `).join('');
                    resultadoBusca.style.display = 'block';
                    posicionarResultados();
                });
        }

        document.addEventListener('click', function(e) {
            if (!resultadoBusca.contains(e.target) && e.target !== inputBusca) {
                resultadoBusca.style.display = 'none';
            }
        });
        // Reposiciona ao redimensionar a tela
        window.addEventListener('resize', function() {
            if (resultadoBusca.style.display === 'block') {
                posicionarResultados();
            }
        });
        // Opcional: Reposiciona ao dar scroll
        window.addEventListener('scroll', function() {
            if (resultadoBusca.style.display === 'block') {
                posicionarResultados();
            }
        }, true);
    }

    // --- Sincronização do campo CEP (header <-> forms de CEP) ---
    function formatarCep(valor) {
        valor = valor.replace(/\D/g, "").slice(0, 8);
        if (valor.length > 5) valor = valor.replace(/^(\d{5})(\d{0,3})/, "$1-$2");
        return valor;
    }

    document.addEventListener("DOMContentLoaded", function() {
        var headerCep = document.getElementById("header-cep");
        var cadastroCep = document.getElementById("cep");

        // Preenche os dois com o que estiver no sessionStorage (permanece na aba)
        if (headerCep && sessionStorage.getItem("lastCep")) headerCep.value = sessionStorage.getItem("lastCep");
        if (cadastroCep && sessionStorage.getItem("lastCep")) cadastroCep.value = sessionStorage.getItem("lastCep");

        // Evento de digitação no header CEP
        if (headerCep) {
            headerCep.addEventListener("input", function() {
                headerCep.value = formatarCep(headerCep.value);
                sessionStorage.setItem("lastCep", headerCep.value);
                if (cadastroCep) cadastroCep.value = headerCep.value;
            });
        }
        // Evento de digitação no completar cadastro/checkout CEP
        if (cadastroCep) {
            cadastroCep.addEventListener("input", function() {
                cadastroCep.value = formatarCep(cadastroCep.value);
                sessionStorage.setItem("lastCep", cadastroCep.value);
                if (headerCep) headerCep.value = cadastroCep.value;
            });
        }
    });
</script>
<script>
    function confirmLogout(userName) {
        if (confirm(`Olá, ${userName}! Tem certeza que deseja sair?`)) {
            window.location.href = '../Controller/logout.php';
        }
    }
</script>
<script src="js/cep-sync.js"></script>