document.addEventListener("DOMContentLoaded", () => {
  const popup = document.querySelector("#contact-popup");

  if (!popup) return;

  const closeButton = popup.querySelector("#close-contact-popup");
  const dialog = popup.querySelector(".popup-content");
  const openButtons = document.querySelectorAll(".js-open-contact-popup, .contact-button, .btn-contact");
  const contactLinks = Array.from(document.querySelectorAll("a")).filter((link) => {
    const href = link.href.toLowerCase();
    const text = link.textContent.trim().toLowerCase();

    return href.includes("contact") || text === "contact";
  });

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

  const openPopup = (reference = "") => {
    fillReference(reference);
    popup.classList.add("active");
    popup.setAttribute("aria-hidden", "false");
    document.body.classList.add("has-popup-open");
    closeButton?.focus();
  };

  const closePopup = () => {
    popup.classList.remove("active");
    popup.setAttribute("aria-hidden", "true");
    document.body.classList.remove("has-popup-open");
  };

  openButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      openPopup(button.dataset.reference || "");
    });
  });

  contactLinks.forEach((link) => {
    link.addEventListener("click", (event) => {
      event.preventDefault();
      openPopup();
    });
  });

  closeButton?.addEventListener("click", closePopup);

  popup.addEventListener("click", (event) => {
    if (!dialog.contains(event.target)) {
      closePopup();
    }
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && popup.classList.contains("active")) {
      closePopup();
    }
  });

  if (document.querySelector("[data-open-contact-popup='true']") || window.location.pathname.toLowerCase().includes("contact")) {
    openPopup();
  }
});
