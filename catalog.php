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
preg_match('/[^\.htm]*/', $url[end(array_keys($url))], $m);
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

?>
<div id="cat-im"><img src="/img/cat-list.png"></div>
<div id="cat-header"><h1><?=wordwrap($rubric['name'], 40, '<br>')?></h1></div>
<div id="cat-preview"><?=$rubric['text']?></div>

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
      <div class="clear"></div>
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