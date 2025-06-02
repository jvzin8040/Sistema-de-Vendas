function verificarCategoriaSelecionada() {
    var categoriaId = document.getElementById('categoria_id_hidden_excluir').value;
    if (!categoriaId) {
        alert('Por favor, selecione uma categoria antes de tentar excluí-la.');
        return false;
    }
    return confirm('Tem certeza que deseja excluir esta categoria?');
}

function carregarCategoriaPorId() {
    var categoriaId = document.getElementById('categoria_id').value;
    if (!categoriaId) {
        document.getElementById('nome_categoria').value = '';
        document.getElementById('categoria_id_hidden').value = '';
        document.getElementById('categoria_id_hidden_excluir').value = '';
        return;
    }

    fetch('../Controller/get_categoria.php?id=' + categoriaId)
        .then(response => {
            if (!response.ok) throw new Error('Categoria não encontrada');
            return response.json();
        })
        .then(data => {
            document.getElementById('nome_categoria').value = data.nome || '';
            document.getElementById('categoria_id_hidden').value = data.ID_categoria || '';
            document.getElementById('categoria_id_hidden_excluir').value = data.ID_categoria || '';
        })
        .catch(error => {
            console.error('Erro ao carregar categoria:', error);
            alert("Categoria não encontrada.");
            document.getElementById('nome_categoria').value = '';
            document.getElementById('categoria_id_hidden').value = '';
            document.getElementById('categoria_id_hidden_excluir').value = '';
        });
}