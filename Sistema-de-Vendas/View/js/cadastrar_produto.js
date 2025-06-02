// Limita o número de imagens selecionadas para no máximo 3
function limitarImagens(input) {
    if (input.files.length > 3) {
        alert("Você pode enviar no máximo 3 imagens.");
        input.value = "";
    }
}