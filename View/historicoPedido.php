<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
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
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="titulo">
            <h1 class="txthistoricoP">Histórico de Pedidos</h1>
        </div>
        <div class="filters">
            <label>intervalo de dias:
                <input type="text" id="filter-date">

                <script>
                    // flatpicker para selecionar duas datas ao mesmo tempo em um campo
                    flatpickr("#filter-date", {
                        mode: "range",
                        dateFormat: "d/m/Y",
                        locale: "pt",
                        maxDate: "today" //limitar a seleção a somente a dia atual e anteriores
                    });
                </script>
            </label>
            <label>Status:
                <select id="filter-status">
                    <option value="todos">Todos</option>
                    <option value="pendente">Pendente</option>
                    <option value="concluido">Concluído</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </label>
            <button onclick="applyFilters()" class="statusf">Filtrar</button>
        </div>
        <ul class="order-list" id="order-list">
            <li class="order-item status-pendente">Pedido #001 - Pendente - 10/04/2025</li>
            <li class="order-item status-concluido">Pedido #002 - Concluído - 11/04/2025</li>
            <li class="order-item status-cancelado">Pedido #003 - Cancelado - 12/04/2025</li>
        </ul>
    </div>

    <script>
        function applyFilters() {
            const dateRange = document.getElementById("filter-date").value;
            const status = document.getElementById("filter-status").value;

            fetch("../Model/filtro_pedidos.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `dateRange=${encodeURIComponent(dateRange)}&status=${status}`
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("order-list").innerHTML = data;
                })
                .catch(error => {
                    console.error("Erro ao filtrar pedidos:", error);
                });
        }
    </script>

    </div>

    <?php include 'footer.php'; ?>
</body>

</html>