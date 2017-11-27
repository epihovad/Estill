<?
require('inc/common.php');

ob_start();
?><link rel="stylesheet" href="/css/good.css" type="text/css" /><?
$const['css_links'] = ob_get_clean();

ob_start();
?><script type="text/javascript" src="/js/good.js"></script><?
$const['js_links'] = ob_get_clean();

ob_start();
echo catalog();
$Lcol = ob_get_clean();

ob_start();

?>
<h1 class="page">Полотенцесушитель Цунами Электрический с полкой</h1>

<div class="gim">
  <div class="gim-chief"><img src="/img/good-list.jpg"></div>
  <div class="gim-other">
		<?
		//$i=0;
		//foreach ($images as $img){
    for($i=0; $i<4; $i++){
			/*?><a class="im<?=!$i++?' active':''?>" base="<?=$img['base']?>" href="<?=$img['href']?>" title="<?=$good['name']?>" data-gallery=""><img src="<?=$img['src']?>"></a><?*/
			?><a class="im<?=!$i?' active':''?>" href="/img/good-list.jpg" title=""><img src="/img/good-list.jpg" height="45"></a><?
		}
		?>
  </div>
</div>

<div class="good-preview">
  <div class="h">Характеристики</div>
  <div class="info">
    Производитель: «ЕвроСтиль»<br>
    Изготовлен из нержавеющей стали 2,0 мм<br>
    Подключается к электрической сети<br>
    Средняя потребляемая мощность 100 Вт<br>
    Номинальная мощность ТЭНа 300 Вт<br>
    Срок гарантии на ТЭН 1 год<br>
    Срок службы полотенцесушителя 10 и более лет
  </div>
  <div class="h">Комплектация</div>
  <div class="info">
    Кран «Маевского» (воздушный клапан) 3 шт.<br>
    Кронштейн телескопический (верхний крепеж) 3 шт.<br>
    Тэн MEG 1.0 1 штука
  </div>
</div>

<div class="good-prm">
  <div class="lb">Цена</div>
  <div class="price">4890 руб.</div>
  <div class="note">Стоимость изделия зависит от выбранных параметров</div>
  <div class="sep"></div>
  <div class="lb">Размер</div>
  <select name="size" class="form-control">
    <option>100x60</option>
    <option>150x40</option>
  </select>
  <div class="sep"></div>
  <div class="lb">С полкой</div>
  <select name="shelf" class="form-control">
    <option>да</option>
    <option>нет</option>
  </select>
  <div class="sep"></div>
  <div class="lb">Количество</div>
	<?=chQuant()?>
  <div class="sep"></div>
</div>

<div class="clear"></div>

<div class="good-info">
  <div class="h">Описание</div>
  <div class="content">
    <p>Электрические полотенцесушители для ванной могут быть теновыми и шнуровыми. В первом случае, в полотенцесушитель заливают
    антифриз, во втором — прокладывают шнур. И тот и другой вариант Вы легко разместите в любом помещении, где есть розетка.
    Чтобы приобрести электро полотенцесушитель в Москве, свяжитесь с нами по телефону или закажите обратный звонок.</p>
    <p>Электро полотенцесушители «ЕвроСтиль» имеют следующие преимущества:</p>
    <ul>
      <li>простая установка в любом месте, где есть розетка;</li>
      <li>автономная работа. Изделия не зависимы от системы отопления;</li>
      <li>возможность регулировки температурного режима;</li>
      <li>эстетичный внешний вид;</li>
      <li>минимальное потребление энергии;</li>
      <li>долгий сорок службы — более 10 лет.</li>
    </ul>
    <p>Электрические полотенцесушители от производителя «Маргроид» предусматривают возможность регулировки температуры с
    помощью термостатической головки или встроенного термостата. Они потребляют небольшое количество энергии до 120 Вт,
    благодаря чему считаются энергоэффективными и экономичными по затратам моделями. При необходимости, Вы всегда можете
    отключить полотенцесушитель.</p>
    <p>Чтобы купить электрический полотенцесушитель для ванной в Москве недорого, обращайтесь напрямую к производителю
    «ЕвроСтиль». Наши электрические полотенцесушители имеют доступные цены, кроме того, мы постоянно запускаем в производство
    новые модели, что позволяет устраивать распродажи, и предоставлять скидки на ранее выпущенные изделия.</p>
  </div>
</div>

<div class="good-similar">
  <div class="h">Похожие товары</div>
  <div class="sep"></div>

  <div id="glist" class="row">
		<? for($i=0; $i<3; $i++){?>
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

</div>
<?

$content = ob_get_clean();
require('tpl/tpl.php');