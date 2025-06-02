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

function confirmLogout(userName) {
    if (confirm(`Olá, ${userName}! Tem certeza que deseja sair?`)) {
        window.location.href = '../Controller/logout.php';
    }
}