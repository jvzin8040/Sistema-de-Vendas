// Formatação e sincronização do campo CEP (com header)
function formatarCep(valor) {
    valor = valor.replace(/\D/g, "").slice(0, 8);
    if (valor.length > 5) valor = valor.replace(/^(\d{5})(\d{0,3})/, "$1-$2");
    return valor;
}

// Formatação para CPF: 000.000.000-00
function formatarCPF(valor) {
    valor = valor.replace(/\D/g, "").slice(0, 11);
    if (valor.length > 9) {
        valor = valor.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2})/, "$1.$2.$3-$4");
    } else if (valor.length > 6) {
        valor = valor.replace(/^(\d{3})(\d{3})(\d{0,3})/, "$1.$2.$3");
    } else if (valor.length > 3) {
        valor = valor.replace(/^(\d{3})(\d{0,3})/, "$1.$2");
    }
    return valor;
}

// Formatação para RG: 00.000.000-0
function formatarRG(valor) {
    valor = valor.replace(/\D/g, "").slice(0, 9);
    if (valor.length > 7) {
        valor = valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,1})/, "$1.$2.$3-$4");
    } else if (valor.length > 4) {
        valor = valor.replace(/^(\d{2})(\d{3})(\d{0,3})/, "$1.$2.$3");
    } else if (valor.length > 2) {
        valor = valor.replace(/^(\d{2})(\d{0,3})/, "$1.$2");
    }
    return valor;
}

document.addEventListener("DOMContentLoaded", function() {
    var headerCep = document.getElementById("header-cep");
    var cadastroCep = document.getElementById("cep");
    var cpf = document.getElementById("cpf");
    var rg = document.getElementById("rg");

    // Preenche os dois com o que estiver no sessionStorage
    if (headerCep && sessionStorage.getItem("lastCep")) headerCep.value = sessionStorage.getItem("lastCep");
    if (cadastroCep && sessionStorage.getItem("lastCep")) cadastroCep.value = sessionStorage.getItem("lastCep");

    // CEP sync
    if (headerCep) {
        headerCep.addEventListener("input", function() {
            headerCep.value = formatarCep(headerCep.value);
            sessionStorage.setItem("lastCep", headerCep.value);
            if (cadastroCep) cadastroCep.value = headerCep.value;
        });
    }
    if (cadastroCep) {
        cadastroCep.addEventListener("input", function() {
            cadastroCep.value = formatarCep(cadastroCep.value);
            sessionStorage.setItem("lastCep", cadastroCep.value);
            if (headerCep) headerCep.value = cadastroCep.value;
        });
    }
    // CPF
    if (cpf) {
        cpf.addEventListener("input", function() {
            cpf.value = formatarCPF(cpf.value);
        });
    }
    // RG
    if (rg) {
        rg.addEventListener("input", function() {
            rg.value = formatarRG(rg.value);
        });
    }
});