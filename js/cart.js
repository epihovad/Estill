jQuery(document).ready(function( $ ) {
  //
  $('.user-data input[type=text], .user-data input[name="user[pwd]"], .user-data textarea').val('');
  //
  $('.cart tbody .c2 a').click(function () {
    $this = $(this);
    var link = $this.attr('href'),
        options = {index: link},
        links = $this;
    blueimp.Gallery(links, options);
    return false;
  });
  //
  $('.cart tbody tr.row-mod').hover(
    function () { $(this).find('th,td').css('background-color','#f9fcff'); },
    function () { $(this).find('th,td').css('background-color','#fff'); }
  );
  //
  Inputmask({mask: '+7 (999) 999-99-99', showMaskOnHover: false}).mask($('input[name="user[phone]"]'));
  //
  $('a.gdel').click(function(){
    var mod = parseInt($(this).parents('tr:first').attr('mod'));
    $(this).parents('tr:first').remove();
    $('#frm-order').attr('action','/cart.php?action=change&mod='+mod).submit();
  });
  //
  $('.callme li').click(function () {
    var ind = $(this).index();
    $('.callme button').html('<b>'+(ind?'нет':'да')+'</b><span class="caret"></span>');
    $('.callme input').val(ind?'0':'1');
    $(this).parents('.btn-group:first').removeClass('open');
    return false;
  });
});