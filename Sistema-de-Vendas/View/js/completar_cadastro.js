function formatarCep(valor) {
    valor = valor.replace(/\D/g, "").slice(0, 8);
    if (valor.length > 5) valor = valor.replace(/^(\d{5})(\d{0,3})/, "$1-$2");
    return valor;
}
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
function formatarCNPJ(valor) {
    valor = valor.replace(/\D/g, "").slice(0, 14);
    if (valor.length > 12) {
        valor = valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, "$1.$2.$3/$4-$5");
    } else if (valor.length > 8) {
        valor = valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,4})/, "$1.$2.$3/$4");
    } else if (valor.length > 5) {
        valor = valor.replace(/^(\d{2})(\d{3})(\d{0,3})/, "$1.$2.$3");
    } else if (valor.length > 2) {
        valor = valor.replace(/^(\d{2})(\d{0,3})/, "$1.$2");
    }
    return valor;
}
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
    var cnpj = document.getElementById("cnpj");
    var rg = document.getElementById("rg");

    if (headerCep && sessionStorage.getItem("lastCep")) headerCep.value = sessionStorage.getItem("lastCep");
    if (cadastroCep && sessionStorage.getItem("lastCep")) cadastroCep.value = sessionStorage.getItem("lastCep");

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
    if (cpf) {
        cpf.addEventListener("input", function() {
            cpf.value = formatarCPF(cpf.value);
        });
    }
    if (cnpj) {
        cnpj.addEventListener("input", function() {
            cnpj.value = formatarCNPJ(cnpj.value);
        });
    }
    if (rg) {
        rg.addEventListener("input", function() {
            rg.value = formatarRG(rg.value);
        });
    }
});