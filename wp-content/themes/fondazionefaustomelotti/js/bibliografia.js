var w = $(window).width();
var b = 600;

if (w > b) {
  function setScrollableContentHeight() {
    var offset = $('.scrollable-content:first').offset();
    var h = $(window).height() - offset.top - 20;

    $('.scrollable-content').height(h);
  }

  function updateScrollbars() {
    $('#scrollbar1').perfectScrollbar('update');
    $('#scrollbar2').perfectScrollbar('update');
    $('#scrollbar3').perfectScrollbar('update');
  }

  $(document).ready(function () {
    setScrollableContentHeight();

    $('#scrollbar1').perfectScrollbar({ suppressScrollX: true });
    $('#scrollbar2').perfectScrollbar({ suppressScrollX: true });
    $('#scrollbar3').perfectScrollbar({ suppressScrollX: true });
  });

  $(window).resize(function () {
    setScrollableContentHeight();
    updateScrollbars();
  });
}