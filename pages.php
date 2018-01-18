<?
require('inc/common.php');

$link = clean($_GET['link']);
$page = getRow("SELECT * FROM {$prx}pages WHERE status=1 AND link='{$link}'");
if(!$page) { header("HTTP/1.0 404 Not Found"); $code = '404'; require('errors.php'); exit; }

$mainID = $page['id'];

$navigate = $page['name'];

$title = $page['name'];
foreach(array('title','keywords','description') as $val)
	if($page[$val]) $$val = $page[$val];

ob_start();
echo catalog();
$Lcol = ob_get_clean();

ob_start();
$h1 = $page['h1'] ? $page['h1'] : $page['name'];
?>
<h1><?=$h1?></h1>
<div class="content">
  <?=$page['text']?>
  <? if($page['link'] == 'optovikam'){ ?>
    <div style="text-align:center">
      <h3 style="padding-top:20px">Мы открыты для рассмотрения любых предложений и готовы к сотрудничеству.<br>Отправьте свою заявку прямо сейчас!</h3>
      <div class="btn btn-default medium fb-frm" tp="opt">отправить запрос</div>
    </div>
  <?}?>
</div>
<a href="" class="back" rel="nofollow">&laquo; назад</a>
<?
$content = ob_get_clean();
require('tpl/tpl.php');