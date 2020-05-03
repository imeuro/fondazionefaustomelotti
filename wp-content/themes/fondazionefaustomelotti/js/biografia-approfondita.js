$(document).ready(function () {
  $('#pages-index li').click(function () {
    $('#pages-index li.active').removeClass('active');
    $(this).addClass('active');
    $('.page-block').hide();
    var id = $(this).data('id');
    $('#page-' + id).show();
    $(document).scrollTop(0);
  });
  $('#pages-index li:first').click();
});
