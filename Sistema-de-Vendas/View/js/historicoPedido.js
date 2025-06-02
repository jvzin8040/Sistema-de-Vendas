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