$(document).ready(function () {
  $('article a').each(function () {
    var img = $(this).data('img');
    var div = $(this).children('.info');
    var labels = $(this).children('.labels');

    if (img) {
      $(this).css('background-image', 'url(' + img + ')');
      div.hide();
      $(this).mouseenter(function () {
        div.clearQueue().stop(true, true).fadeToggle();
        labels.addClass('active');
      }).mouseleave(function () {
        div.clearQueue().stop(true, true).fadeToggle();
        labels.removeClass('active');
      });
    } else {
      labels.addClass('active');
    }
  });
});