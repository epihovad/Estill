jQuery(document).ready(function( $ ) {
  //
  $('.gim-other a.im').click(function () {
    var $this = $(this);
    var ind = $this.index();
    var src = $this.attr('base');
    var $chief = $('.gim-chief');
    $chief.attr('ind',ind);
    $chief.find('img').attr('src',src);
    $('.gim-other a.im').removeClass('active');
    $(this).addClass('active');
    return false;
  });
  //
  $('.gim-chief').click(function () {
    var ind = parseInt($(this).attr('ind'));
    ind = isNaN(ind) ? 0 : ind;
    if(ind >= 0){
      var $im = $('.gim-other a.im').eq(ind);
      var link = $im.attr('href'),
          options = {index: link, index: ind},
          links = $('.gim-other').find('a');
      blueimp.Gallery(links, options);
    } else {
      var link = $('.gim-mods a.im.active').attr('href'),
          options = {index: link},
          links = $('.gim-mods a.im.active');
      blueimp.Gallery(links, options);
    }
  });
  //
  $('.gim-mods a.im').click(function () {
    //
    var $this = $(this);
    $('.gim-mods a.im').removeClass('active');
    $this.addClass('active');
    //
    $('.good-tocart .lb div').html($this.attr('mod_type'));
    //
    $('.good-tocart .price-actual').html($this.attr('price')+' руб');
    var old_price = parseInt($this.attr('old_price'));
    $('.good-tocart .price-old').html(old_price > 0 ? old_price+' руб' : '');
    //
    var src = $this.attr('base');
    var $chief = $('.gim-chief');
    $chief.attr('ind',-1);
    $chief.find('img').attr('src',src);
    $('.gim-other a.im').removeClass('active');
    $('.gim-over').hide();
    return false;
  });
  //
  $('.tocart').click(function(){
    var mod = $('.gim-mods a.im.active').attr('mod');
    var quant = $('.good-tocart input[name="quant"]').val();
    $('.tocart').addClass('disabled');
    toCart(mod,quant);
    return false;
  });
  //
  $('.one-click').click(function(){
    var mod = $('.gim-mods a.im.active').attr('mod');
    jPop('/inc/actions.php?show=call&mod='+mod);
    return false;
  });
});