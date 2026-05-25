document.addEventListener("DOMContentLoaded", () => {
  // Recupere la fenetre plein ecran.
  const lightbox = document.querySelector("#photo-lightbox");

  // Arrete le script si la lightbox n'est pas presente.
  if (!lightbox) return;

  const image = lightbox.querySelector(".lightbox__image");
  const reference = lightbox.querySelector(".lightbox__ref");
  const category = lightbox.querySelector(".lightbox__category");
  const closeButton = lightbox.querySelector(".lightbox__close");
  const previousButton = lightbox.querySelector(".lightbox__nav--prev");
  const nextButton = lightbox.querySelector(".lightbox__nav--next");

  let photos = [];
  let currentIndex = 0;

  // Affiche l'image et ses informations.
  const updateLightbox = (index) => {
    const photo = photos[index];

    currentIndex = index;
    image.src = photo.dataset.full || "";
    image.alt = photo.dataset.ref || "";
    reference.textContent = photo.dataset.ref || "";
    category.textContent = photo.dataset.category || "";
  };

  // Ouvre la lightbox sur la photo choisie.
  const openLightbox = (index) => {
    photos = Array.from(document.querySelectorAll(".photo"));
    updateLightbox(index);
    lightbox.classList.add("is-open");
    lightbox.setAttribute("aria-hidden", "false");
    document.body.classList.add("has-lightbox-open");
  };

  // Ferme la lightbox.
  const closeLightbox = () => {
    lightbox.classList.remove("is-open");
    lightbox.setAttribute("aria-hidden", "true");
    document.body.classList.remove("has-lightbox-open");
    image.src = "";
  };

  // Affiche la photo precedente.
  const showPrevious = () => {
    const previousIndex = currentIndex === 0 ? photos.length - 1 : currentIndex - 1;
    updateLightbox(previousIndex);
  };

  // Affiche la photo suivante.
  const showNext = () => {
    const nextIndex = currentIndex === photos.length - 1 ? 0 : currentIndex + 1;
    updateLightbox(nextIndex);
  };

  // Fonctionne aussi avec les photos ajoutées par AJAX.
  document.addEventListener("click", (event) => {
    const openButton = event.target.closest(".js-open-lightbox");

    if (!openButton) return;

    const photo = openButton.closest(".photo");
    photos = Array.from(document.querySelectorAll(".photo"));
    const index = photos.indexOf(photo);

    if (index === -1) return;

    event.preventDefault();
    openLightbox(index);
  });

  // Relie les boutons de navigation.
  closeButton.addEventListener("click", closeLightbox);
  previousButton.addEventListener("click", showPrevious);
  nextButton.addEventListener("click", showNext);

  // Ferme la lightbox en cliquant sur son fond.
  lightbox.addEventListener("click", (event) => {
    if (event.target === lightbox) {
      closeLightbox();
    }
  });

  // Permet la navigation au clavier.
  document.addEventListener("keydown", (event) => {
    if (!lightbox.classList.contains("is-open")) return;

    if (event.key === "Escape") closeLightbox();
    if (event.key === "ArrowLeft") showPrevious();
    if (event.key === "ArrowRight") showNext();
  });
});
