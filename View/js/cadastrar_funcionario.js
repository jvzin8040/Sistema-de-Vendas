
document.addEventListener("DOMContentLoaded", function () {
    const telInput = document.getElementById('telefone');
    if (!telInput) return;

    telInput.addEventListener('input', function (e) {
        let value = telInput.value.replace(/\D/g, '');

     
        value = value.slice(0, 11);

        if (value.length > 2 && value.length <= 7) {
          
            value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
        } else if (value.length > 7) {
           
            value = `(${value.slice(0, 2)}) ${value.slice(2, 7)}-${value.slice(7)}`;
        } else if (value.length > 2) {
            value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
        } else if (value.length > 0) {
            value = `(${value}`;
        }

        telInput.value = value;
    });

    
    telInput.addEventListener('blur', function () {
        let value = telInput.value.replace(/\D/g, '');
        if (value.length === 10) {
           
            telInput.value = `(${value.slice(0, 2)}) ${value.slice(2, 6)}-${value.slice(6, 10)}`;
        } else if (value.length === 11) {
         
            telInput.value = `(${value.slice(0, 2)}) ${value.slice(2, 7)}-${value.slice(7, 11)}`;
        }
    });
});