document.addEventListener("DOMContentLoaded", () => {
  const preview = document.querySelector("#nav-preview");
  const arrows = document.querySelectorAll(".navigation-arrow");

  if (!preview || !arrows.length) return;

  arrows.forEach((arrow) => {
    arrow.addEventListener("mouseenter", () => {
      const newPreview = arrow.dataset.preview;

      if (newPreview) {
        preview.src = newPreview;
      }
    });
  });
});