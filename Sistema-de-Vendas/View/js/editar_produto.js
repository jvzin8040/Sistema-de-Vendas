function verificarProdutoSelecionado() {
    var produtoId = document.getElementById('produto_id_hidden_excluir').value;
    if (!produtoId) {
        alert('Por favor, selecione um produto antes de tentar excluí-lo.');
        return false;
    }
    return confirm('Tem certeza que deseja excluir este produto?');
}

// Limita o número de imagens selecionadas para no máximo 3
function limitarImagens(input) {
    if (input.files.length > 3) {
        alert("Você pode enviar no máximo 3 imagens.");
        input.value = "";
    }
}

function carregarProdutoPorId() {
    var produtoId = document.getElementById('produto_id').value;
    if (!produtoId) {
        document.getElementById('nome').value = '';
        document.getElementById('descricao').value = '';
        document.getElementById('categoria').value = '';
        document.getElementById('preco').value = '';
        document.getElementById('quantidade').value = '';
        document.getElementById('produto_id_hidden').value = '';
        document.getElementById('produto_id_hidden_excluir').value = '';
        return;
    }

    fetch('../controller/get_produto.php?id=' + produtoId)
        .then(response => {
            if (!response.ok) throw new Error('Produto não encontrado');
            return response.json();
        })
        .then(data => {
            document.getElementById('nome').value = data.nome || '';
            document.getElementById('descricao').value = data.descricao || '';
            document.getElementById('categoria').value = data.ID_categoria || '';
            document.getElementById('preco').value = data.preco || '';
            document.getElementById('quantidade').value = data.qtdEstoque || '';
            document.getElementById('produto_id_hidden').value = data.ID_produto || '';
            document.getElementById('produto_id_hidden_excluir').value = data.ID_produto || '';
        })
        .catch(error => {
            console.error('Erro ao carregar produto:', error);
            alert("Produto não encontrado.");
            document.getElementById('nome').value = '';
            document.getElementById('descricao').value = '';
            document.getElementById('categoria').value = '';
            document.getElementById('preco').value = '';
            document.getElementById('quantidade').value = '';
            document.getElementById('produto_id_hidden').value = '';
            document.getElementById('produto_id_hidden_excluir').value = '';
        });
}