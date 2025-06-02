
document.addEventListener('DOMContentLoaded', function () {
    const telefoneInput = document.getElementById('telefone');

    telefoneInput.addEventListener('input', function (e) {
        let valor = e.target.value.replace(/\D/g, ''); // remove tudo que não for número

        if (valor.length > 11) {
            valor = valor.slice(0, 11); // limita a 11 dígitos
        }

        let formatado = valor;

        if (valor.length >= 2) {
            formatado = `(${valor.slice(0, 2)}`;
        }
        if (valor.length >= 7) {
            formatado += `) ${valor.slice(2, 7)}-${valor.slice(7)}`;
        } else if (valor.length > 2) {
            formatado += `) ${valor.slice(2)}`;
        }

        e.target.value = formatado;
    });
});
