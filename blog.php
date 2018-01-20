<?
require('inc/common.php');

$link = clean($_GET['link']);
$tbl = 'blog';
$title = 'Блог';

ob_start();
echo catalog();
$Lcol = ob_get_clean();

ob_start();

if($link)
{
	if(!$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE link='{$link}' AND status=1")) { header("HTTP/1.0 404 Not Found"); $code = '404'; require('errors.php'); exit; }

	$navigate = '<a href="/blog/">Блог</a><span>&rarr;</span>'.$row['name'];
	$h1 = $row['name'];

	?>
  <h1><?=$row['name']?></h1>
  <div class="content"><?=$row['text']?></div>
  <a href="" class="back" rel="nofollow">&laquo; назад</a>
	<?

	$title = $row['name'];
	foreach(array('title','keywords','description') as $val)
		if($row[$val]) $$val = $row[$val];
}
else
{
	$navigate = 'Блог';

	$cur_page = (int)$_GET['page'];
	$cur_page = $cur_page ? $cur_page : 1;

	$h1 = $title;

	?><h1><?=$title?></h1><?

	$query = "SELECT * FROM {$prx}{$tbl} WHERE status=1";

	$r = sql($query);
	$count_goods = (int)@mysql_num_rows($r); // кол-во объектов в базе
	$count_goods_on_page = 3; // кол-во объектов на странице
	$count_page = ceil($count_goods/$count_goods_on_page); // количество страниц
	$cur_page = (int)$_GET['page'] ? (int)$_GET['page'] : 1;

	$query .= ' ORDER BY `date` DESC LIMIT '.($count_goods_on_page*$cur_page-$count_goods_on_page).",".$count_goods_on_page;
	$res = sql($query);
	if(@mysql_num_rows($res))
	{
		?>
    <div class="fright"><?=pagination($count_page, $cur_page)?></div>
    <div class="clear"></div>
    <div id="nlist">
    <?
    while($row = mysql_fetch_array($res))
    {
      $id = $row['id'];
      $link = "/{$tbl}/{$row['link']}.htm";
      ?>
      <div class="item">
        <? if(file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/{$tbl}/{$id}.jpg")){ ?>
          <div class="im left"><a href="<?=$link?>" rel="nofollow"><img src="/<?=$tbl?>/<?=$id?>.jpg" width="350" /></a></div>
        <? }?>
        <h3><a href="<?=$link?>"><?=$row['name']?></a></h3>
        <div class="date"><?=getRusDate('d M y',$row['date'])?></div>
        <div class="preview"><?=$row['preview']?></div>
        <div class="lnk">
          <a class="bk4 right" href="<?=$link?>" class="bk4 right" rel="nofollow">Подробнее</a>
          <hr>
        </div>
        <div class="clear"></div>
      </div>
      <?
    }
    ?>
    <div class="fright"><?=pagination($count_page, $cur_page)?></div>
    <div class="clear"></div>
    </div>
    <?
	}
	else
	{
		?><div class="nofind">новости отсутствуют</div><?
	}
}
$content = ob_get_clean();
require('tpl/tpl.php');
