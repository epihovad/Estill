<?
function setPriv($mail,$pass)
{
	global $prx;

	unset($_SESSION['user']);

	if($row = getRow("SELECT * FROM {$prx}users WHERE mail='{$mail}' AND pass=md5('{$pass}') AND status=1"))
		$_SESSION['user'] = $row;

	return isset($_SESSION['user']);
}

// МЕНЮ (ОСНОВНОЕ)
function main()
{
	global $prx, $mainID;

	$res = sql("SELECT * FROM {$prx}pages WHERE status=1 AND main=1 ORDER BY sort,id");
	if(!$count = @mysql_num_rows($res)) return;

	$url = $_SERVER['REQUEST_URI'];

	while($row = mysql_fetch_assoc($res))
	{
		$link = $row['type']=='link' ? $row['link'] : ($row['link']=='/' ? '/' : "/{$row['link']}.htm");
		$cur = $row['id']==$mainID || ($url=='/' && $link=='/') ? true : false;

		?><div><a id="lnk<?=$row['id']?>" href="<?=$link?>"<?=$cur?' class="cur"':''?>><?=$row['name']?></a></div><?
	}
}

function islider()
{
	global $prx;

	?><div id="islider"><?
	$r = sql("SELECT * FROM {$prx}slider WHERE status=1 ORDER BY sort,id");
	while($img = @mysql_fetch_assoc($r))
	{
		$id = $img['id'];
		if($img['link']){ ?><a href="<?=$img['link']?>"><img src="/slider/<?=$id?>.jpg"></a><? }
		else { ?><img src="/slider/<?=$id?>.jpg"><? }
	}
	?>
</div>
  <link type="text/css" href="/inc/advanced/jRotator/jRotator.css" rel="stylesheet"/>
  <script type="text/javascript" src="/inc/advanced/jRotator/jRotator.js"></script>
  <script>$(function(){$('#islider').jRotator({pAlign:'center',timeLineColor:'#ff7900'})});</script>
	<?
}

function navigate()
{
  ?>
  <div id="navigate">
    <div class="in">
      <a href="/">Главная</a><span>&rarr;</span><a href="/catalog">Каталог</a><span>&rarr;</span>Водяные полотенцесушители
    </div>
  </div>
  <?
}

function catalog()
{
  ?>
  <div id="catalog">
    <div class="lvl1"><a href="#">Комплектующие для полотенцесушителей</a></div>
    <div class="lvl1"><span>Водяные полотенцесушители</span></div>
    <div class="lvl2"><a href="#">«Лесенка» электрические полотенцесушители</a></div>
    <div class="lvl2 active"><span>«Лесенка» с полкой электрические полотенцесушители</span></div>
    <div class="lvl2"><a href="#">Электрические полотенцесушители Шнурового типа</a></div>
    <div class="lvl1"><a href="#">Электрические полотенцесушители</a></div>
  </div>
  <?
}

// СЧЕТЧИКИ (ФУТЕР)
function counters()
{
	global $prx;

	$res = sql("SELECT html FROM {$prx}counters WHERE status=1 ORDER BY sort,id");
	while($row = @mysql_fetch_assoc($res))
		echo "&nbsp;{$row['html']}&nbsp;";
}

// ПОЛЕ ДЛЯ ВВОДА КОЛ-ВА
function chQuant($name='quant',$quant=1)
{
	?>
	<div class="input-group">
		<span class="input-group-btn">
			<button type="button" class="btn btn-default btn-number"<?=$quant<=1?' disabled="disabled"':''?> data-type="minus">
				<span class="glyphicon glyphicon-minus"></span>
			</button>
		</span>
		<input type="text" name="<?=$name?>" class="form-control input-number" value="<?=$quant?>" min="1" max="99">
		<span class="input-group-btn">
			<button type="button" class="btn btn-default btn-number"<?=$quant>=99?' disabled="disabled"':''?> data-type="plus">
				<span class="glyphicon glyphicon-plus"></span>
			</button>
		</span>
	</div>
	<?
}

// Страницы навигации
// show_navigate_pages(количество страниц,текущая,'ссылка = ?topic=news&page=')
function show_navigate_pages()
{
	global $count_obj,$count_obj_on_page,$kol_str,$cur_page,$dopURL;
	$x = $kol_str; $p = $cur_page;
	if($x<2) return;
	
	preg_match('/(&page=[0-9]+)/',$_SERVER['REQUEST_URI'],$h);
	$link = str_replace($h[1],'',$_SERVER['REQUEST_URI']);
	
	?><div id="navPages"><div class="pages"><?
	if($p!=1)
	{
		?><a class="bk4" href="<?=$link?>&page=<?=($p-1)?><?=$dopURL?>" title="предыдущая">Назад</a><?
	}  
	if($x<4)
	{
		for($i=1;$i<=$x;$i++)
		{
			if($i==$p) echo '<b class="bk4">'.$i.'</b>';
			else echo get_href($link,$i);
		}
	}
	if($x==4)
	{
		if($p==1) 		echo '<b class="bk4">'.$p.'</b>'.get_href($link,$p+1).'<span>...</span>'.get_href($link,$x);// 1
		if($p==2) 		echo get_href($link,1).'<b class="bk4">'.$p.'</b>'.get_href($link,$p+1).'<span>...</span>'.get_href($link,$x);// 2
		if(($p-1)==2) echo get_href($link,1).'<span>...</span>'.get_href($link,$p-1).'<b class="bk4">'.$p.'</b>'.get_href($link,$x);// 3
		if($p==$x) 		echo get_href($link,1).'<span>...</span>'.get_href($link,$x-1).'<b class="bk4">'.$p.'</b>';// 4
	}
	if($x>4)
	{
		if($p==1) 					echo '<b class="bk4">1</b>'.get_href($link,$p+1).'<span>...</span>'.get_href($link,$x);// 1
		elseif($p==2) 			echo get_href($link,1).'<b class="bk4">'.$p.'</b>'.get_href($link,$p+1).'<span>...</span>'.get_href($link,$x);// 2
		elseif(($p-1)==2) 	echo get_href($link,1).'<span>...</span>'.get_href($link,$p-1).'<b class="bk4">'.$p.'</b>'.get_href($link,$p+1).'<span>...</span>'.get_href($link,$x);// 3
		elseif(($x-$p)==1) 	echo get_href($link,1).'<span>...</span>'.get_href($link,$p-1).'<b class="bk4">'.$p.'</b>'.get_href($link,$x);// 4
		elseif($p==$x) 			echo get_href($link,1).'<span>...</span>'.get_href($link,$x-1).'<b class="bk4">'.$p.'</b>';// 5
		else								echo get_href($link,1).'<span>...</span>'.get_href($link,$p-1).'<b class="bk4">'.$p.'</b>'.get_href($link,$p+1).'<span>...</span>'.get_href($link,$x);
	}
	if($p<$x)
	{
		?><a class="bk4" href="<?=$link?>&page=<?=($p+1)?>" title="следующая">Вперед</a><?
	}	
	$start = $count_obj_on_page*$p-$count_obj_on_page;
	$end = $count_obj_on_page+$start;
  $end = $end>$count_obj?$count_obj:$end;
	?></div><div class="info">Показано с <?=$start+1?> по <?=$end?> из <?=$count_obj?> (<?=$x?> <?=num2str($x,'страница')?>)</div></div><?
}
function get_href($link,$page)
{
	global $dopURL;
	ob_start();
		?><a class="bk4" href="<?=$link?>&page=<?=$page?><?=$dopURL?>"><?=$page?></a><?
	return ob_get_clean();
}

function num2str($count,$txt='товар')
{
	$pat = array( 'товар'=>array('товар','товара','товаров'),
                'страница'=>array('страница','страницы','страниц')
  );
	
	$count = $count%100;
  if($count>19) $count = $count%10;
  switch($count)
	{
    case 1:  return($pat[$txt][0]);
    case 2: case 3: case 4:  return($pat[$txt][1]);
    default: return($pat[$txt][2]);
  }
}

// ВЫВОД ALERT ОБ ОШИБКЕ (и прерывание выполнения)
function jAlert($text,$method='',$type='',$func='',$prm='',$exit=true)
{
	$method = $method ? $method : 'show';
	$type = $type ? $type : 'alert';
	$prm = $prm ? $prm : '{}';
	?><script>
		top.jQuery(document).jAlert('<?=$method?>','<?=$type?>','<?=$text?>',function(){<?=$func?>},<?=$prm?>);
		top.jQuery('#ajax').attr('src','/inc/none.htm');
	</script><?
  if($exit) exit;
}