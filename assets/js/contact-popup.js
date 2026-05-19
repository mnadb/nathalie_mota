// ouvrir/fermer la popup //

document.addEventListener('DOMContentLoaded', function () {
  const openBtn = document.getElementById('open-contact-popup');
  const closeBtn = document.getElementById('close-contact-popup');
  const popup = document.getElementById('contact-popup');
   console.log("j'affiche bien");

  if (!openBtn || !closeBtn || !popup) return;
 
  

  openBtn.addEventListener('click', function () {
    popup.classList.add('active');
    popup.setAttribute('aria-hidden', 'false');
  });

  closeBtn.addEventListener('click', function () {
    popup.classList.remove('active');
    popup.setAttribute('aria-hidden', 'true');
  });

  popup.addEventListener('click', function (event) {
    if (event.target === popup) {
      popup.classList.remove('active');
      popup.setAttribute('aria-hidden', 'true');
    }
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      popup.classList.remove('active');
      popup.setAttribute('aria-hidden', 'true');
    }
  });
});