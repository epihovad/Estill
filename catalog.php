<?
require('inc/common.php');

$url = explode('/',$_SERVER['REQUEST_URI']);
$len = sizeof($url);
$links = array();
for($i=2; $i<$len-1; $i++)
	$links[] = $url[$i];

$id_parent = 0;
$rubric = array();

if(!$links){
  $rubric = getRow("SELECT * FROM {$prx}catalog WHERE id_parent='0' AND status=1 ORDER BY sort,id LIMIT 1");
} else {
	foreach($links as $link)
	{
		$rubric = getRow("SELECT * FROM {$prx}catalog WHERE link='{$link}' AND id_parent='{$id_parent}' AND status=1 LIMIT 1");
		$id_parent = $rubric['id'];
	}
}

if(!$rubric) { header("HTTP/1.0 404 Not Found"); $code = '404'; require('errors.php'); exit; }

$ids_parent_rubric = getArrParents("SELECT id,id_parent FROM {$prx}catalog WHERE status=1 AND id='%s'",$rubric['id']);
$ids_child_rubric = getIdChilds("SELECT * FROM {$prx}catalog WHERE status=1",$rubric['id'],false);

ob_start();
echo catalog();
$Lcol = ob_get_clean();

// Товар?
$good = array();
preg_match('/[^\.htm]*/', $url[sizeof($url)-1], $m);
if($good_link = clean($m[0])){
  $good = getRow("SELECT * FROM {$prx}goods WHERE link='{$good_link}' AND status=1");
}

if($good){
  include($_SERVER['DOCUMENT_ROOT'].'/good.php');
  exit;
}

// -------------------- TITLE + КЛЮЧЕВЫЕ СЛОВА
$title = $rubric['name'];
foreach(array('title','keywords','description') as $val)
	if($rubric[$val]) $$val = $rubric[$val];

ob_start();

if(file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/catalog/250x250/{$rubric['id']}.jpg")){
  ?><div id="cat-im"><img src="/catalog/250x250/<?=$rubric['id']?>.jpg"></div><?
}
?>
<div id="cat-header"><h1><?=wordwrap($rubric['name'], 40, '<br>')?></h1></div>
<div id="cat-preview"><?=$rubric['text']?></div>
<div class="clear"></div>
<?

$query = "SELECT * FROM {$prx}goods WHERE id_catalog IN ({$ids_child_rubric})";

$r = sql($query);
$count_goods = (int)@mysql_num_rows($r); // кол-во объектов в базе
$count_goods_on_page = 9; // кол-во объектов на странице
$count_page = ceil($count_goods/$count_goods_on_page); // количество страниц
$cur_page = (int)$_GET['page'] ? (int)$_GET['page'] : 1;

$query .= ' LIMIT '.($count_goods_on_page*$cur_page-$count_goods_on_page).",".$count_goods_on_page;
$res = sql($query);

?>
<div class="fright"><?=pagination($count_page, $cur_page)?></div>
<div class="clear"></div>
<?

if(@mysql_num_rows($res)){
	?><div id="glist" class="row"><?
  $i=0;
  while ($g = mysql_fetch_assoc($res)){
    $name = $g['h1'] ? $g['h1'] : $g['name'];
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
        <div class="btn btn-default tocart-mini" mod="<?=$mod['id']?>">в корзину<span></span></div>
      </div>
    </div>
    <?
  }
  ?></div><?
}
?>

<div class="fright"><?=pagination($count_page, $cur_page)?></div>
<div class="clear"></div>
<?

$content = ob_get_clean();
require('tpl/tpl.php');