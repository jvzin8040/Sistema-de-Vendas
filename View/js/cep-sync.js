function formatarCep(valor) {
    valor = valor.replace(/\D/g, "").slice(0, 8);
    if (valor.length > 5) valor = valor.replace(/^(\d{5})(\d{0,3})/, "$1-$2");
    return valor;
}
function sincronizarCamposCep() {
    var camposCEP = Array.from(document.querySelectorAll('#header-cep, #cep'));
    var lastCep = sessionStorage.getItem("lastCep") || "";
    if (lastCep) {
        camposCEP.forEach(function(input) {
            input.value = lastCep;
        });
    }
    camposCEP.forEach(function(input) {
        input.addEventListener("input", function() {
            input.value = formatarCep(input.value);
            camposCEP.forEach(function(outro) {
                if (outro !== input) outro.value = input.value;
            });
            sessionStorage.setItem("lastCep", input.value);
        });
    });
}
document.addEventListener("DOMContentLoaded", sincronizarCamposCep);