document.addEventListener("DOMContentLoaded", () => {
  const lightbox = document.querySelector("#photo-lightbox");
  const photos = Array.from(document.querySelectorAll(".photo"));

  if (!lightbox || !photos.length) return;

  const image = lightbox.querySelector(".lightbox__image");
  const reference = lightbox.querySelector(".lightbox__ref");
  const category = lightbox.querySelector(".lightbox__category");
  const closeButton = lightbox.querySelector(".lightbox__close");
  const previousButton = lightbox.querySelector(".lightbox__nav--prev");
  const nextButton = lightbox.querySelector(".lightbox__nav--next");

  let currentIndex = 0;

  const updateLightbox = (index) => {
    const photo = photos[index];

    currentIndex = index;
    image.src = photo.dataset.full || "";
    image.alt = photo.dataset.ref || "";
    reference.textContent = photo.dataset.ref || "";
    category.textContent = photo.dataset.category || "";
  };

  const openLightbox = (index) => {
    updateLightbox(index);
    lightbox.classList.add("is-open");
    lightbox.setAttribute("aria-hidden", "false");
    document.body.classList.add("has-lightbox-open");
  };

  const closeLightbox = () => {
    lightbox.classList.remove("is-open");
    lightbox.setAttribute("aria-hidden", "true");
    document.body.classList.remove("has-lightbox-open");
    image.src = "";
  };

  const showPrevious = () => {
    const previousIndex = currentIndex === 0 ? photos.length - 1 : currentIndex - 1;
    updateLightbox(previousIndex);
  };

  const showNext = () => {
    const nextIndex = currentIndex === photos.length - 1 ? 0 : currentIndex + 1;
    updateLightbox(nextIndex);
  };

  photos.forEach((photo, index) => {
    const openButton = photo.querySelector(".js-open-lightbox");

    if (!openButton) return;

    openButton.addEventListener("click", (event) => {
      event.preventDefault();
      openLightbox(index);
    });
  });

  closeButton.addEventListener("click", closeLightbox);
  previousButton.addEventListener("click", showPrevious);
  nextButton.addEventListener("click", showNext);

  lightbox.addEventListener("click", (event) => {
    if (event.target === lightbox) {
      closeLightbox();
    }
  });

  document.addEventListener("keydown", (event) => {
    if (!lightbox.classList.contains("is-open")) return;

    if (event.key === "Escape") closeLightbox();
    if (event.key === "ArrowLeft") showPrevious();
    if (event.key === "ArrowRight") showNext();
  });
});
