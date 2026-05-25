jQuery(function ($) {
  // Recupere les elements de la galerie.
  const form = document.querySelector("#form-filters");
  const grid = document.querySelector("#grid-photos");
  const button = document.querySelector("#load-more-photos");

  // Arrete le script si la galerie n'est pas sur cette page.
  if (!form || !grid || !button || typeof loaderPhotosData === "undefined") return;

  // Memorise la page de photos affichee.
  let currentPage = 1;
  let maxPages = Number(button.dataset.maxPages) || 1;
  let isLoading = false;

  // Laisse le bouton visible et indique clairement quand toutes les photos sont affichees.
  const updateButton = () => {
    const isComplete = currentPage >= maxPages;

    button.disabled = isLoading || isComplete;
    button.hidden = false;
    button.style.display = "";

    if (!isLoading) {
      button.textContent = isComplete ? "Fin" : "Charger plus";
    }
  };

  // Charge une page de photos sans recharger le site.
  const loadPhotos = async (resetGrid) => {
    if (isLoading) return;

    const requestedPage = resetGrid ? 1 : currentPage + 1;
    const data = new FormData();

    data.append("action", "filter_photos");
    data.append("nonce", loaderPhotosData.nonce);
    data.append("paged", requestedPage);
    data.append("categorie", form.elements.photo_categorie.value);
    data.append("format", form.elements.photo_format.value);
    data.append("order", form.elements.photo_order.value || "DESC");

    isLoading = true;
    button.textContent = "Chargement...";
    button.setAttribute("aria-busy", "true");
    updateButton();

    try {
      const response = await fetch(loaderPhotosData.ajaxurl, {
        method: "POST",
        body: data,
      });
      const result = await response.json();

      if (!response.ok || !result.success) {
        throw new Error("Le chargement a échoué.");
      }

      if (resetGrid) {
        grid.innerHTML = result.data.html;
      } else {
        grid.insertAdjacentHTML("beforeend", result.data.html);
      }

      currentPage = requestedPage;
      maxPages = Number(result.data.max_pages) || 1;
    } catch (error) {
      console.error("Erreur pendant le chargement des photos :", error);
    } finally {
      isLoading = false;
      button.removeAttribute("aria-busy");
      updateButton();
    }
  };

  /*
   * Select2 declenche le changement avec jQuery.
   * Une ecoute jQuery permet donc de recharger la grille au choix d'une option.
   */
  $(form).on("change", ".js-photo-filter", function () {
    loadPhotos(true);
  });

  // Charge les huit photos suivantes au clic.
  button.addEventListener("click", () => {
    if (!button.disabled) {
      loadPhotos(false);
    }
  });

  updateButton();
});
