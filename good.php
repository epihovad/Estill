<?

// -------------------- TITLE + КЛЮЧЕВЫЕ СЛОВА
$title = $good['name'];
foreach(array('title','keywords','description') as $val)
	if($good[$val]) $$val = $good[$val];

ob_start();
?><link rel="stylesheet" href="/css/good.css" type="text/css" /><?
$const['css_links'] = ob_get_clean();

ob_start();
?><script type="text/javascript" src="/js/good.js"></script><?
$const['js_links'] = ob_get_clean();

ob_start();

$images = array();
// остальные фото
$imgs = getImages('goods',$good['id']);
foreach ($imgs as $im){
	$images[] = array(
		'base' => "/uploads/goods/265x265/{$im}",
		'href' => "/uploads/goods/{$im}",
		'src' => "/uploads/goods/45x45/{$im}"
	);
}

?>
<h1 class="page"><?=$title?></h1>

<div class="gim">
  <div class="gim-chief"><img src="<?=$images[0]['base']?>"></div>
  <div class="gim-other">
		<?
		$i=0;
		foreach ($images as $img){
			?><a class="im<?=!$i++?' active':''?>" base="<?=$img['base']?>" href="<?=$img['href']?>" title="<?=$good['name']?>" data-gallery=""><img src="<?=$img['src']?>"></a><?
		}
		?>
  </div>
</div>

<div class="good-preview">
  <? if($good['feature']){ ?>
  <div class="h">Характеристики</div>
  <div class="info"><?=$good['feature']?></div>
  <?}?>
	<? if($good['kit']){ ?>
  <div class="h">Комплектация</div>
  <div class="info"><?=$good['kit']?></div>
	<?}?>
</div>

<?
// модификации
$r = sql("SELECT * FROM {$prx}mods WHERE id_good='{$good['id']}' AND status = 1 ORDER BY sort,price");
$mods = array();
while ($arr = @mysql_fetch_assoc($r)){
  $mods[] = $arr;
}

?>

<div class="good-prm">
  <div class="lb">Цена</div>
  <div class="price"><span><?=number_format($mods[0]['price'],0,',',' ')?></span> руб.</div>
  <div class="note">Стоимость изделия зависит от выбранных параметров</div>
  <div class="sep"></div>
  <div class="lb">Размер</div>
  <select name="size" class="form-control">
    <?
    foreach ($mods as $mod){
      ?><option mod="<?=$mod['id']?>" price="<?=number_format($mod['price'],0,',',' ')?>" price_shelf="<?=number_format($mod['price_shelf'],0,',',' ')?>" sections="<?=$mod['sections']?>"><?=$mod['name']?></option><?
    }
    ?>
  </select>
  <div class="sep"></div>
  <div class="lb">С полкой</div>
  <select name="shelf" class="form-control">
    <option>да</option>
    <option selected>нет</option>
  </select>
  <div class="sep"></div>
  <div class="lb">Кол-во секций</div>
  <div class="sections"><?=$mods[0]['sections']?></div>
  <div class="sep"></div>
  <div class="lb">Количество</div>
	<?=chQuant()?>
  <div class="sep"></div>
  <div class="btn btn-default tocart">в корзину<span></span></div>
</div>

<div class="clear"></div>

<div class="good-info">
  <div class="h">Описание</div>
  <div class="content"><?=$good['text']?></div>
</div>

<?
$r = sql("SELECT * FROM {$prx}goods WHERE id_catalog IN ({$ids_child_rubric}) AND NOT id = '{$good['id']}' AND status=1");
if(@mysql_num_rows($r)){
  ?>
  <div class="good-similar">
    <div class="h">Похожие товары</div>
    <div class="sep"></div>
    <div id="glist" class="row"><?
      $i=0;
      while ($g = mysql_fetch_assoc($r)){
        $name = $g['title'] ? $g['title'] : $g['name'];
        $lnk = $g['url'].$g['link'].'.htm';
        $mod = getRow("SELECT * FROM {$prx}mods WHERE id_good='{$g['id']}' AND status = 1 ORDER BY sort,price LIMIT 1");
        ?>
        <div class="col-md-4">
          <div class="good">
            <a href="<?=$lnk?>" class="name">
              <div><?=$name?></div>
              <img src="/goods/200x200/<?=$g['id']?>.jpg">
            </a>
            <div class="clear"></div>
            <div class="price"><?=number_format($mod['price'],0,',',' ')?> руб.</div>
            <div class="btn btn-default tocart">в корзину<span></span></div>
          </div>
        </div>
        <?
      }
    ?></div>
  </div>
  <?
}

$content = ob_get_clean();
require('tpl/tpl.php');