document.addEventListener("DOMContentLoaded", () => {
  const burger = document.querySelector(".burger");
  const menu = document.querySelector(".nav-menu");

  if (!burger || !menu) return;

  const closeMenu = () => {
    menu.classList.remove("open");
    burger.classList.remove("active");
    burger.setAttribute("aria-expanded", "false");
    burger.setAttribute("aria-label", "Ouvrir le menu");
    document.body.classList.remove("has-mobile-menu-open");
  };

  const openMenu = () => {
    menu.classList.add("open");
    burger.classList.add("active");
    burger.setAttribute("aria-expanded", "true");
    burger.setAttribute("aria-label", "Fermer le menu");
    document.body.classList.add("has-mobile-menu-open");
  };

  burger.addEventListener("click", () => {
    if (menu.classList.contains("open")) {
      closeMenu();
      return;
    }

    openMenu();
  });

  menu.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", closeMenu);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeMenu();
    }
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
      closeMenu();
    }
  });
});
