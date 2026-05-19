 // MENU BURGER//
const burger = document.querySelector('.burger');
const menu = document.querySelector('.nav-menu');

burger.addEventListener('click', () => {
  const open = menu.classList.toggle('open');
  burger.classList.toggle('active');
  burger.setAttribute('aria-expanded', open);
});

// LIGHTBOX //


