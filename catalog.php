<?
require('inc/common.php');

ob_start();
echo catalog();
$Lcol = ob_get_clean();

ob_start();

?>
<div id="cat-im"><img src="/img/cat-list.png"></div>
<div id="cat-header"><h1>Водяные<br>полотенцесушители</h1></div>
<div id="cat-preview">
  Идеальным вариантом для обустройства ванной комнаты станут электрические полотенцесушители.
  Их основное назначение — сушка полотенец и других вещей, кроме этого, они способны обогреть
  помещение и выступают в качестве декоративного элемента. Очень удобно, что электро
  полотенцесушители не зависят от систем отопления и водоснабжения. Компания «ЕвроСтиль»
  производит и реализует электрические полотенцесушители в Москве и других городах России недорого.
  В данном разделе представлено более 45 видов изделий, среди которых Вы гарантированно подберете
  подходящий вариант. Каждое изделие имеет четкое фото и подробные характеристики.
</div>

<ul class="pagination fright">
  <li class="disabled"><a href="#">&laquo;</a></li>
  <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>
<div class="clear"></div>

<div id="glist" class="row">
  <? for($i=0; $i<12; $i++){?>
  <div class="col-md-4">
    <div class="good">
      <a href="/good.php" class="name">
        <div>Полотенцесушитель Вид 52 шнурового типа полотенцесушитель Вид 52 шнурового типа</div>
        <img src="/img/good-list.jpg" height="200">
      </a>
      <div class="price">4890 руб.</div>
      <div class="btn btn-default tocart">в корзину<span></span></div>
    </div>
  </div>
  <?}?>
</div>

<ul class="pagination fright">
  <li class="disabled"><a href="#">&laquo;</a></li>
  <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>
<div class="clear"></div>
<?

$content = ob_get_clean();
require('tpl/tpl.php');