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
$h1 = $page['h1'] ? $page['h1'] : $page['name'];
?>
<h1><?=$h1?></h1>
<div class="content"><?=$page['text']?></div>
<a href="" class="back" rel="nofollow">&laquo; назад</a>
<?
$content = ob_get_clean();
require('tpl/tpl.php');