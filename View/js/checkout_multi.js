// Esconde o campo de parcelamento se não for cartão
document.addEventListener("DOMContentLoaded", function(){
    function toggleParcelamento() {
        var metodo = document.querySelector('input[name="metodo_pagamento"]:checked').value;
        var parcelaSection = document.getElementById('parcela-section');
        if(metodo === 'cartao'){
            parcelaSection.style.display = 'flex';
        } else {
            parcelaSection.style.display = 'none';
        }
    }
    document.querySelectorAll('input[name="metodo_pagamento"]').forEach(function(elem){
        elem.addEventListener('change', toggleParcelamento);
    });
    toggleParcelamento();
});

// Máscaras de CPF, RG, CNPJ, CEP
function aplicarMascara(elemento, mascara) {
    elemento.addEventListener('input', function() {
        let v = elemento.value.replace(/\D/g, '');
        let i = 0;
        elemento.value = mascara.replace(/#/g, _ => v[i++] || '');
    });
}
document.addEventListener("DOMContentLoaded", function() {
    // CPF: 000.000.000-00
    const cpf = document.getElementById('cpf');
    if (cpf) aplicarMascara(cpf, '###.###.###-##');
    // CNPJ: 00.000.000/0000-00
    const cnpj = document.getElementById('cnpj');
    if (cnpj) aplicarMascara(cnpj, '##.###.###/####-##');
    // RG: 00.000.000-0
    const rg = document.getElementById('rg');
    if (rg) aplicarMascara(rg, '##.###.###-#');
    // CEP: 00000-000
    const cep = document.getElementById('cep');
    if (cep) aplicarMascara(cep, '#####-###');
});