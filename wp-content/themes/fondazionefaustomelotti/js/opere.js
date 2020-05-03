$(document).ready(function () {

  var $isotopeContainer = $('.items');
  $isotopeContainer.imagesLoaded(function () {
    $isotopeContainer.isotope({
      itemSelector: '.item'
    });
  });

  $('#work-type-filter').selectBoxIt();

  $('#work-type-filter').change(function () {
    var type = $(this).val();
    if (type != '*')
      type = '.' + type + ', .authentic';
    $isotopeContainer.isotope({ filter: type });
  });

  $('section').on('click', 'a:not(.close,.pdf)', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var pos = $(window).scrollTop();

    $('#work').css('top', pos + 'px');
    $('#work-loader').hide();
    $('#work-close').hide();
    $('#loading').fadeIn();

    $("#work-loader").load(url + " article", function () {
      $('#loading').hide();
      $('#work-loader').fadeIn();
      $('#work-close').fadeIn();
    });

  });

  $('#work-close a').click(function (e) {
    e.preventDefault();
    $('#work-loader').fadeOut();
    $('#work-close').fadeOut();
  });

});