function positionSearch() {
  var offsetMenu = $('#main-menu').offset();
  var offsetSearchLink = $('#utilities .search a').offset();
  var widthSearchLink = $('#utilities .search a').width();
  var gap = (($(window).width() - $('#wrapper').width()) / 2) - 10;

  $('#search').css({
    'left': (offsetMenu.left - gap) + 'px',
    'width': (offsetSearchLink.left - offsetMenu.left + widthSearchLink)  + 'px'
  });
}

$(document).ready(function () {
  var nav = responsiveNav('.nav-collapse');

  positionSearch();

  $('#utilities .search a').click(function (e) {
    e.preventDefault();
    $('#search').slideDown();
    $('#search .search-input').focus();
  });

  $('#search .close').click(function (e) {
    e.preventDefault();
    $('#search').slideUp();
  });
});

$(window).resize(function () {
  positionSearch();
});