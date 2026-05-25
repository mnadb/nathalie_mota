document.addEventListener("DOMContentLoaded", () => {
  // Recupere le bouton burger et le menu mobile.
  const burger = document.querySelector(".burger");
  const menu = document.querySelector(".nav-menu");

  // Arrete le script si le menu n'est pas present.
  if (!burger || !menu) return;

  // Ferme le menu mobile.
  const closeMenu = () => {
    menu.classList.remove("open");
    burger.classList.remove("active");
    burger.setAttribute("aria-expanded", "false");
    burger.setAttribute("aria-label", "Ouvrir le menu");
    document.body.classList.remove("has-mobile-menu-open");
  };

  // Ouvre le menu mobile.
  const openMenu = () => {
    menu.classList.add("open");
    burger.classList.add("active");
    burger.setAttribute("aria-expanded", "true");
    burger.setAttribute("aria-label", "Fermer le menu");
    document.body.classList.add("has-mobile-menu-open");
  };

  // Ouvre ou ferme le menu au clic sur le burger.
  burger.addEventListener("click", () => {
    if (menu.classList.contains("open")) {
      closeMenu();
      return;
    }

    openMenu();
  });

  // Ferme le menu apres le clic sur un lien.
  menu.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", closeMenu);
  });

  // Ferme le menu avec la touche Echap.
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeMenu();
    }
  });

  // Ferme le menu quand on repasse en affichage large.
  window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
      closeMenu();
    }
  });
});
