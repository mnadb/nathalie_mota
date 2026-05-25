jQuery(function ($) {
  // Selectionne uniquement les listes de filtres presentes sur la page d'accueil.
  const $photoFilters = $('.js-photo-filter');

  // Evite une erreur JavaScript si le plugin Select2 n'est pas charge.
  if (!$photoFilters.length || typeof $.fn.select2 !== 'function') {
    return;
  }

  // Remplace chaque select natif et garde son premier libelle comme placeholder.
  $photoFilters.each(function () {
    const $filter = $(this);
    const placeholder = $filter.find('option[value=""]').first().text();
    const filterName = this.name.replace('photo_', '');

    $filter.select2({
      minimumResultsForSearch: Infinity,
      placeholder: placeholder,
      width: '100%',
      dropdownCssClass: 'photo-filter-dropdown'
    });

    // Le select natif est masque par Select2 : la classe positionne son champ visible.
    const $visibleFilter = $filter.next('.select2-container').addClass('photo-filter--' + filterName);

    /*
     * Sur un ecran tactile, ouvre explicitement la liste au relachement du doigt.
     * Cela evite que le premier appui soit absorbe par le champ genere par Select2.
     */
    $visibleFilter.find('.select2-selection').on('touchend', function (event) {
      event.preventDefault();
      $filter.select2('open');
    });
  });
});
