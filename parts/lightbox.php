<!--
    Lightbox des photos.
    Elle est cachée par défaut.
    Le JavaScript remplit l'image, la référence et la catégorie au clic sur une photo.
-->
<div class="lightbox" id="photo-lightbox" aria-hidden="true">
    <!-- Bouton pour fermer la lightbox. -->
    <button class="lightbox__close" type="button" aria-label="Fermer la lightbox">×</button>

    <!-- Bouton pour afficher la photo précédente. -->
    <button class="lightbox__nav lightbox__nav--prev" type="button" aria-label="Photo précédente">
        <span>Précédente</span>
    </button>

    <!-- Image principale de la lightbox. -->
    <figure class="lightbox__figure">
        <img class="lightbox__image" src="" alt="">

        <!-- Informations de la photo affichée. -->
        <figcaption class="lightbox__caption">
            <span class="lightbox__ref"></span>
            <span class="lightbox__category"></span>
        </figcaption>
    </figure>

    <!-- Bouton pour afficher la photo suivante. -->
    <button class="lightbox__nav lightbox__nav--next" type="button" aria-label="Photo suivante">
        <span>Suivante</span>
    </button>
</div>
