document.addEventListener("DOMContentLoaded", () => {
  // Recupere l'image d'apercu et les fleches de navigation.
  const preview = document.querySelector("#nav-preview");
  const arrows = document.querySelectorAll(".navigation-arrow");

  // Arrete le script si la navigation n'existe pas.
  if (!preview || !arrows.length) return;

  // Change l'apercu lorsque la souris passe sur une fleche.
  arrows.forEach((arrow) => {
    arrow.addEventListener("mouseenter", () => {
      const newPreview = arrow.dataset.preview;

      if (newPreview) {
        preview.src = newPreview;
      }
    });
  });
});
