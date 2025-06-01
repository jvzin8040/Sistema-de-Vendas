document.addEventListener('DOMContentLoaded', function() {
  // Miniaturas
  const miniaturas = document.querySelectorAll('.galeria-vertical img');
  const imagemPrincipal = document.getElementById('imgPrincipal');
  miniaturas.forEach(img => {
    img.addEventListener('click', () => {
      imagemPrincipal.src = img.src;
      miniaturas.forEach(m => m.classList.remove('selected'));
      img.classList.add('selected');
    });
  });

  // Zoom ao passar o mouse sobre a imagem principal
  imagemPrincipal.addEventListener('mouseenter', function() {
    imagemPrincipal.classList.add('zoom');
  });
  imagemPrincipal.addEventListener('mouseleave', function() {
    imagemPrincipal.classList.remove('zoom');
  });

  // Sincroniza quantidade única nos dois formulários antes de enviar
  function syncQuantidadeAndSubmit(formId, inputId) {
    const qty = document.getElementById('quantidadeUnica') ? document.getElementById('quantidadeUnica').value : 1;
    document.getElementById(inputId).value = qty;
    document.getElementById(formId).submit();
  }
  const formComprar = document.getElementById('formComprar');
  const formCarrinho = document.getElementById('formCarrinho');
  if (formComprar) {
    formComprar.addEventListener('submit', function(e) {
      e.preventDefault();
      syncQuantidadeAndSubmit('formComprar', 'quantidadeComprar');
    });
  }
  if (formCarrinho) {
    formCarrinho.addEventListener('submit', function(e) {
      e.preventDefault();
      syncQuantidadeAndSubmit('formCarrinho', 'quantidadeCarrinho');
    });
  }
});