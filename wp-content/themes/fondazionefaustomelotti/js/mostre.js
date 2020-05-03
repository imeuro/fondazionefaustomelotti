var w = $(window).width();
var b = 600;

function setScrollableContentHeight() {
  var offset = $('.scrollable-content:first').offset();
  var h = $(window).height() - offset.top -20;

  $('.scrollable-content').height(h);
}

function updateScrollbars() {
  $('#scrollbar1').scrollTop(0);
  $('#scrollbar1').perfectScrollbar('update');
  $('#scrollbar2').scrollTop(0);
  $('#scrollbar2').perfectScrollbar('update');
}

$(document).ready(function () {
  if (w > b) {
    setScrollableContentHeight();
    $('#scrollbar1').perfectScrollbar({ suppressScrollX: true });
    $('#scrollbar2').perfectScrollbar({ suppressScrollX: true });
  }

  $('#years-index li').click(function () {
    $('#years-index li.active').removeClass('active');
    $(this).addClass('active');
    $('.exhibition-block').hide();
    var id = $(this).data('id');
    $('#solo-' + id).show();
    $('#group-' + id).show();
    if (w > b) {
      updateScrollbars();
    }
  });
  $('#years-index li:first').click();
});

if (w > b) {
  $(window).load(function () {
    updateScrollbars();
  });

  $(window).resize(function () {
    setScrollableContentHeight();
    updateScrollbars();
  });
}