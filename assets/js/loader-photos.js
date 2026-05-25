jQuery(function ($) {
  let currentPage = 1;
  let maxPages = 1;
  let isLoading = false;

  function getFilters() {
    return {
      categorie: $('#form-filters select[name="photo_categorie"]').val() || '',
      format: $('#form-filters select[name="photo_format"]').val() || '',
      order: $('#form-filters select[name="photo_order"]').val() || 'DESC',
    };
  }

  function loadPhotos(reset = false) {
    if (isLoading) return;

    isLoading = true;

    if (reset) {
      currentPage = 1;
      $('#grid-photos').html('');
    }

    const data = {
      action: 'filter_photos',
      nonce: loaderPhotosData.nonce,
      paged: currentPage,
      ...getFilters(),
    };

    $.ajax({
      url: loaderPhotosData.ajaxurl,
      type: 'POST',
      data: data,
      success: function (response) {
        if (response.success) {
          if (reset) {
            $('#grid-photos').html(response.data.html);
          } else {
            $('#grid-photos').append(response.data.html);
          }

          maxPages = parseInt(response.data.max_pages, 10) || 1;

          if (currentPage >= maxPages) {
            $('#load-more-photos').hide();
          } else {
            $('#load-more-photos').show();
          }
        }
      },
      complete: function () {
        isLoading = false;
      }
    });
  }

  $('#form-filters select').on('change', function () {
    loadPhotos(true);
  });

  $('#load-more-photos').on('click', function () {
    if (currentPage >= maxPages) return;
    currentPage++;
    loadPhotos(false);
  });

  loadPhotos(true);
});