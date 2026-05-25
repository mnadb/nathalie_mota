document.addEventListener("DOMContentLoaded", () => {
  // Gere l'ouverture et la fermeture du formulaire de contact.
  // On récupère la popup dans le HTML.
  const popup = document.querySelector("#contact-popup");

  // Si la popup n'existe pas sur la page, on arrête le script.
  if (!popup) return;

  const closeButton = popup.querySelector("#close-contact-popup");
  const dialog = popup.querySelector(".popup-content");

  // Boutons qui doivent ouvrir la popup : bouton contact de la single, menu contact, etc.
  const openButtons = document.querySelectorAll(".js-open-contact-popup, .contact-button, .btn-contact");

  // On transforme aussi le lien "Contact" du menu en ouverture de popup.
  const contactLinks = Array.from(document.querySelectorAll("a")).filter((link) => {
    const href = link.href.toLowerCase();
    const text = link.textContent.trim().toLowerCase();

    return href.includes("contact") || text === "contact";
  });

  // Remplit automatiquement le champ "RÉF. PHOTO" depuis la page single.
  const fillReference = (reference) => {
    if (!reference) return;

    const fields = popup.querySelectorAll("input, textarea");

    fields.forEach((field) => {
      const fieldName = `${field.name || ""} ${field.id || ""} ${field.placeholder || ""}`.toLowerCase();
      const label = field.closest(".wpforms-field")?.querySelector("label") || popup.querySelector(`label[for="${field.id}"]`);
      const labelText = label ? label.textContent.toLowerCase() : "";
      const isReferenceField = labelText.startsWith("réf") || labelText.startsWith("ref") || fieldName.includes("reference") || fieldName.includes("référence");

      if (field.type !== "hidden" && field.type !== "email" && isReferenceField) {
        field.value = reference;
      }
    });
  };

  // Ouvre la popup.
  const openPopup = (reference = "") => {
    fillReference(reference);
    popup.classList.add("active");
    popup.setAttribute("aria-hidden", "false");
    document.body.classList.add("has-popup-open");
    closeButton?.focus();
  };

  // Ferme la popup.
  const closePopup = () => {
    popup.classList.remove("active");
    popup.setAttribute("aria-hidden", "true");
    document.body.classList.remove("has-popup-open");
  };

  // Ouvre la popup quand on clique sur un bouton Contact.
  openButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      openPopup(button.dataset.reference || "");
    });
  });

  // Ouvre la popup quand on clique sur le lien Contact du menu.
  contactLinks.forEach((link) => {
    link.addEventListener("click", (event) => {
      event.preventDefault();
      openPopup();
    });
  });

  closeButton?.addEventListener("click", closePopup);

  // Ferme la popup si on clique sur le fond gris.
  popup.addEventListener("click", (event) => {
    if (!dialog.contains(event.target)) {
      closePopup();
    }
  });

  // Ferme la popup avec la touche Échap.
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && popup.classList.contains("active")) {
      closePopup();
    }
  });

  // Si on arrive directement sur la page contact, on ouvre la popup automatiquement.
  if (document.querySelector("[data-open-contact-popup='true']") || window.location.pathname.toLowerCase().includes("contact")) {
    openPopup();
  }
});
