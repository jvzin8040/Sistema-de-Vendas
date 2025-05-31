<?php include '../Controller/verifica_login.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Pedidos</title>
    <!-- Bibliotecas e CSS do projeto -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/histPedido.css">
</head>
<body class="bdhistoricop">
    <div class="pagina-wrapper">
        <?php include 'header.php'; ?>
        <div class="container">
            <div class="titulo">
                <h1 class="txthistoricoP">Histórico de Pedidos</h1>
            </div>
            <div class="filters">
                <label>
                    Intervalo de dias:
                    <input type="text" id="filter-date" placeholder="Selecione o período">
                </label>
                <label>
                    Status:
                    <select id="filter-status">
                        <option value="todos">Todos</option>
                        <option value="Pendente">Pendente</option>
                        <option value="Concluído">Concluído</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </label>
                <button onclick="applyFilters()" class="statusf">Filtrar</button>
            </div>
            <ul class="order-list" id="order-list">
                <!-- Os pedidos serão carregados aqui via AJAX -->
            </ul>
            <!-- Espaço flexível para empurrar o footer -->
            <div class="espaco-flex"></div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
    <script>
        flatpickr("#filter-date", {
            mode: "range",
            dateFormat: "d/m/Y",
            locale: "pt",
            maxDate: "today"
        });
        document.addEventListener("DOMContentLoaded", function () {
            applyFilters();
        });
        function applyFilters() {
            const dateRange = document.getElementById("filter-date").value;
            const status = document.getElementById("filter-status").value;
            fetch("../Controller/filtrarPedido.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `dateRange=${encodeURIComponent(dateRange)}&status=${encodeURIComponent(status)}`
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("order-list").innerHTML = data;
            })
            .catch(error => {
                document.getElementById("order-list").innerHTML = "<li class='order-item'>Erro ao filtrar pedidos.</li>";
                console.error("Erro ao filtrar pedidos:", error);
            });
        }
    </script>
</body>
</html>