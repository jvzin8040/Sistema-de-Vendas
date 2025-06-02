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