<?php
require_once('../Model/Produto.php');
$produtos = Produto::listarTodos();
$categorias = Produto::listarCategorias();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EID Store - Editar Produto</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/form.css" />
    <link rel="stylesheet" href="css/footer.css" />
</head>
<body>
    <header>
        <div class="top-header">
            <img src="images/eid_store_logo.png" alt="Logo EID Store" class="logo-img" />
            <div class="header-actions">
                <a href="#">Login</a>
                <a href="#">Minha Conta</a>
                <a href="#">Carrinho</a>
            </div>
        </div>
    </header>
    <main style="background-color: #820AD1; padding: 50px 20px; min-height: 100vh;">
        <div style="background-color: white; max-width: 600px; margin: 0 auto; padding: 40px; border-radius: 10px;">
            <h2 style="text-align: center; margin-bottom: 30px;">Editar produto</h2>

            <label for="produto_id">Escolha o produto</label>
            <select id="produto_id" name="produto_id" onchange="carregarProdutoPorId()" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="">Selecione um produto</option>
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?= htmlspecialchars($produto['ID_produto']) ?>">
                        <?= htmlspecialchars($produto['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <form action="../Controller/editarProdutoAction.php" method="post" enctype="multipart/form-data">
                <label for="nome">Alterar nome do produto</label>
                <input type="text" id="nome" name="nome" required />

                <label for="descricao">Alterar descrição do produto</label>
                <input type="text" id="descricao" name="descricao" required />

                <label for="imagens">Imagens do produto</label>
                <input type="file" id="imagens" name="imagens[]" multiple accept="image/*" />

                <label for="categoria">Alterar categoria do produto</label>
                <select id="categoria" name="categoria" required style="margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['ID_categoria']) ?>">
                            <?= htmlspecialchars($cat['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="preco">Alterar preço (R$) do produto</label>
                <input type="number" step="0.01" id="preco" name="preco" required />

                <label for="quantidade">Alterar quantidade disponível</label>
                <input type="number" id="quantidade" name="quantidade" required />

                <input type="hidden" name="produto_id" id="produto_id_hidden" />

                <button type="submit" style="background-color: #820AD1; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; margin-top: 20px; cursor:pointer;">Editar produto</button>
            </form>

            <form action="../Controller/excluirProdutoAction.php" method="post" onsubmit="return verificarProdutoSelecionado();" style="margin-top:15px;">
                <input type="hidden" name="codigo" id="produto_id_hidden_excluir" />
                <button type="submit" class="delete-button" style="background-color: #d11a2a; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; cursor:pointer;">Excluir produto</button>
            </form>

            <script>
                function verificarProdutoSelecionado() {
                    var produtoId = document.getElementById('produto_id_hidden_excluir').value;
                    if (!produtoId) {
                        alert('Por favor, selecione um produto antes de tentar excluí-lo.');
                        return false;
                    }
                    return confirm('Tem certeza que deseja excluir este produto?');
                }
            </script>
        </div>
    </main>

    <script>
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
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>