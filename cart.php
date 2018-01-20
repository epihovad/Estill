<?
require('inc/common.php');
//unset($_SESSION['cart']);

if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		// -------------- ДОБАВЛЕНИЕ ТОВАРА В КОРЗИНУ
		case 'add':

		  //unset($_SESSION['cart']); exit;
			$id = (int)$_GET['mod'];
			$kol = (int)$_GET['quant'];
			$kol = $kol ? $kol : 1;

			$mod = getRow("SELECT * FROM {$prx}mods WHERE status = 1 AND id = '{$id}'");
			if(!$mod['id']) exit;
			$good = getRow("SELECT * FROM {$prx}goods WHERE status = 1 AND id = '{$mod['id_good']}'");
			if(!$good['id']) exit;

			$_SESSION['cart']['mods'][$id] = array(
			  'quant'     => $kol,
        'price'     => $mod['price'],
				'amount'    => $kol * $mod['price'],
        'shelf'     => (int)$_GET['shelf'],
        'good_link' => $good['url'].$good['link'].'.htm',
        'good_name' => $good['name'],
        'mod_name'  => $mod['name']
      );
			$quant = 0;
			$total = 0;
			foreach ($_SESSION['cart']['mods'] as $arr) {
				$quant += $arr['quant'];
        $total += $arr['amount'];
			}

			$_SESSION['cart']['quant'] = $quant;
			$_SESSION['cart']['total'] = $total;

			?>
			<script>
        top.jQuery('#cart span').html('<?=$_SESSION['cart']['quant']?>');
				top.jQuery(document).jAlert('show','confirm',
					'Товар добавлен к Вашему заказу<br>Желаете перейти к оформлению?',
					function(){top.location.href='/cart/'},
					{b_confirm : {b1:'Оформить',b2:'Позже'}}
				);
				top.jQuery('.tocart').removeClass('disabled');
        top.jQuery('.tocart-mini[mod="<?=$id?>"]').removeClass('disabled');
			</script>
			<?
			break;

		// -------------- ИЗМЕНЕНИЕ КОЛ-ВА/УДАЛЕНИЕ ТОВАРА В КОРЗИНЕ
    case 'change':
      $remove_mod_id = (int)$_GET['mod'];
			if($remove_mod_id){
        unset($_SESSION['cart']['mods'][$remove_mod_id]);
      }

			$quant = 0;
			$total = 0;
      foreach ($_POST['quant'] as $mod_id=>$mod_quant){
				$_SESSION['cart']['mods'][$mod_id]['quant'] = $mod_quant;
				$_SESSION['cart']['mods'][$mod_id]['amount'] = $mod_quant * $_SESSION['cart']['mods'][$mod_id]['price'];
        $quant += $mod_quant;
				$total += $_SESSION['cart']['mods'][$mod_id]['amount'];
			}

			if(!$quant){
        unset($_SESSION['cart']);
        ?><script>top.location.href = '/cart/'</script><?
        exit;
      }

			$_SESSION['cart']['quant'] = $quant;
			$_SESSION['cart']['total'] = $total;

      ?>
      <script>
        top.jQuery('#cart span').html('<?=$_SESSION['cart']['quant']?>');
        top.jQuery('tr.total .c6').html('<?=price($_SESSION['cart']['total'])?> руб.');
        <? foreach ($_SESSION['cart']['mods'] as $mod_id => $none){?>
        top.jQuery('tr[mod="<?=$mod_id?>"] .c6').html('<?=price($_SESSION['cart']['mods'][$mod_id]['amount'])?> руб.');
        <?}?>
      </script>
      <?
      break;

		// -------------- СОХРАНЕНИЕ ЗАКАЗА
		case 'save':

			if(!$_SESSION['cart']) exit;

		  foreach ($_POST['user'] as $k => $v)
        $$k = clean($v);

			$jAlert_js = "top.jQuery('.btn.oform').removeClass('disabled');";

			// проверка обязательных полей
			if(!$name) jAlert('Пожалуйста, введите Ваше ФИО');
			if(!check_mail($email)) jAlert('Некорректный E-mail');
			$phone = substr(preg_replace("/\D/",'',$phone), -10);
			if(strlen($phone) != 10) jAlert('Некорректный номер телефона');

			$callme = (int)$_POST['callme'];
			$sendmail = (int)$_POST['sendmail'];
			$subscribe = (int)$_POST['subscribe'];

			// регим пользователя
			if(!$id_user = $_SESSION['user']['id'])
			{
			  if(!$id_user = getField("SELECT * FROM {$prx}users WHERE email='{$email}'")){
			    $pass = get_new_pass();
          if($id_user = update('users',"name='{$name}',email='{$email}',pass=md5('{$pass}'),phone='{$phone}'")){
            /*$_SESSION['user'] = gtv('users','*',$id_user);

            // отправляем письмо пользователю
            $tema  = "Регистрация на сайте {$_SERVER['SERVER_NAME']}";
            $text  = "Уважаемый <b>{$name}</b>,<br><br>Вы зарегистрировались на сайте <a href='http://{$_SERVER['SERVER_NAME']}'>{$_SERVER['SERVER_NAME']}</a>.<br>";
            $text .= "Ваш E-mail: <b>{$email}</b><br>";
            $text .= "Ваш пароль: <b>{$pass}</b>";
            mailTo($email,$tema,$text,set('admin_mail'));
            */
            // журнал
            update('log',"text='зарегистрирован новый пользователь',link='users.php?red={$id_user}'");
          }
			  }

			}

			// добавляем в подписку
			if($subscribe){
			  sql("INSERT INTO {$prx}subscribers SET email = '{$email}' ON DUPLICATE KEY UPDATE unsubscribe_date=NULL");
			}

			// информация о клиенте
			$user_info  = '';
			$user_info .= "<b>ФИО</b>: {$name}<br>";
			$user_info .= "<b>E-mail</b>: {$email}<br>";
			$user_info .= "<b>Телефон</b>: +7{$phone}<br>";
			if($index = clean($_POST['user']['index'],true))
				$user_info .= "<b>Почтовый индекс</b>: {$index}<br>";
			if($address = clean($_POST['user']['address'],true))
				$user_info .= "<b>Адрес доставки</b>: {$address}<br>";
			if($notes = clean($_REQUEST['notes'],true))
				$user_info .= "<b>Примечание к заказу</b>: {$notes}";

			// информация о заказе
			$order_info = '';

			ob_start();
			?><table cellpadding="5" cellspacing="0" border="1"><thead><tr><th width="20">№</th><th>Наименование</th><th>Цена (руб.)</th><th>Кол-во</th><th>Стоимость (руб.)</th></tr></thead><?
			$table = ob_get_clean();

			ob_start();
			?><table class="subtab"><thead><tr><th width="20">№</th><th>Наименование</th><th>Цена (руб.)</th><th>Кол-во</th><th>Стоимость (руб.)</th></tr></thead><?
			$order_info = ob_get_clean();

			$mods = array();
			$n=1;
			$table .= '<tbody>';
			$order_info .= '<tbody>';
			foreach($_SESSION['cart']['mods'] as $mod_id => $arr)
			{
				ob_start();
				?>
				<tr>
					<th><?=$n++?></th>
					<td align="left">
					  <a href="http://<?=$_SERVER['SERVER_NAME'].$_SESSION['cart']['mods'][$mod_id]['good_link']?>"><?=$_SESSION['cart']['mods'][$mod_id]['good_name']?></a><br>
					  размер: <span><?=$_SESSION['cart']['mods'][$mod_id]['mod_name']?>, <?=$_SESSION['cart']['mods'][$mod_id]['shelf']?'с полочкой':'без полочки'?>
					</td>
					<td align="right"><?=price($_SESSION['cart']['mods'][$mod_id]['price'])?></td>
					<td align="center"><?=$arr['quant']?></td>
					<td align="right"><?=price($arr['amount'])?></td>
				</tr>
				<?
				$data = ob_get_clean();
				$table .= $data;
				$order_info .= $data;
			}

			$table .= '</tbody>';
			$order_info .= '</tbody>';

			ob_start();
			?>
			  <tfoot>
          <tr>
            <td align="right" colspan="4"><b>Итого</b></td>
            <td align="right"><b><?=price($_SESSION['cart']['total'])?></b></td>
          </tr>
				</tfoot>
			</table>
			<?
			$data = ob_get_clean();
			$table .= $data;
			$order_info .= $data;

			// сохраняем заказ
			$set = "id_user='{$id_user}',
			        email='{$email}',
			        phone='{$phone}',
			        order_info='".clean($order_info)."',
			        order_info_html='".(clean($table))."',
			        user_info='{$user_info}',
			        cost='{$_SESSION['cart']['total']}',
			        notes='{$notes}',
			        sendmail='{$sendmail}',
			        callme='{$callme}'";

			if(!$id_order = update('orders',$set)){
			  jAlert('Во время сохранения данных произошла ошибка.<br>Администрация сайта приносит Вам свои извинения.<br>Мы уже знаем об этой проблеме и работаем над её устранением.');
			}

			$number = date('Ymd').'/'.$id_order;
			update('orders',"`number`='{$number}'",$id_order);

			$_SESSION['orders'][] = $id_order;

			// журнал
      update("log","text='новый заказ',link='orders.php?red={$id_order}'");

			// мылим
      $subject = 'Заказ №'.$number.' от '.date('d.m.Y').' с сайта '.$_SERVER['SERVER_NAME'];
      ob_start();
        ?>
        <h2>Заказ №<?=$number?> от <?=date('d.m.Y')?></h2>
        <h3 style="margin-bottom:5px;">Покупатель:</h3>
        <div style="margin-bottom:10px;"><?=$user_info?></div>
        <h3 style="margin-top:5px;">Информация о заказе:</h3>
        <?=$table?>
        <?
      $text = ob_get_clean();

      mailTo(array(set('admin_mail'),'info@estill.ru',$email), $subject, $text);

      unset($_SESSION['cart']);

      $message  = 'Уважаемый(ая) '.$name.'!';
      $message .= '<br>Номер Вашего заказа: <b>'.$number.'</b> от <b>'.date('d.m.Y').'</b>';
      $message .= '<br>Заказ отправлен в отдел продаж.';
      $message .= '<br>Благодарим Вас за обращение в нашу Компанию.';

      ?><script>top.jQuery(document).jAlert('show','alert','<?=$message?>',function(){top.location.href='/cart/?show=res&order=<?=$id_order?>'});</script><?

			break;
	}
	exit;
}

ob_start();
?><link type="text/css" rel="stylesheet" href="/css/cart.css" /><?
$const['css_links'] = ob_get_clean();

ob_start();
?>
<script src="/js/jquery/inputmask.min.js"></script>
<script src="/js/jquery/inputmask.phone.extensions.min.js"></script>
<script src="/js/cart.js"></script>
<?
$const['js_links'] = ob_get_clean();

// ------------------ПРОСМОТР---------------------
ob_start();

switch(@$_GET['show'])
{
	// ----------------- ОФОРМЛЕНИЕ ЗАКАЗА
	default:

		if(!$_SESSION['cart']){
			header('Location: /cart/?show=empty');
			exit;
		}

		$navigate = 'Оформление заказа';

		?>
    <h1>Оформление заказа</h1>
    <form id="frm-order" action="/cart/?action=save" target="ajax" method="post">

      <h2 style="margin-top:40px;">Информация о заказе</h2>
      <table class="cart">
        <thead>
          <tr>
            <th class="c1">№</th>
            <th class="c2">Фото</th>
            <th class="c3">Наименование</th>
            <th class="c4">Цена</th>
            <th class="c5">Кол-во</th>
            <th class="c6">Стоимость</th>
            <th class="cell-fake"></th>
          </tr>
        </thead>
        <tbody>
				<?
				$ids_mods = implode(',', array_keys($_SESSION['cart']['mods']));
				//$mods = array();
				$r = sql("SELECT * FROM {$prx}mods WHERE id IN ({$ids_mods})");
				$i=1;
				while ($mod = mysql_fetch_assoc($r)){
					$good = gtv('goods','*',$mod['id_good']);
					$quant = $_SESSION['cart']['mods'][$mod['id']]['quant'];
					$price = $_SESSION['cart']['mods'][$mod['id']]['price'];
					$amount = $_SESSION['cart']['mods'][$mod['id']]['amount'];
					$shelf = $_SESSION['cart']['mods'][$mod['id']]['shelf'];
					?>
          <tr mod="<?=$mod['id']?>" class="row-mod">
            <td class="c1"><?=$i++?></td>
            <td class="c2">
              <a href="/goods/<?=$good['id']?>.jpg" rel="nofollow" title="<?=htmlspecialchars($good['name'].' (размер: '.$mod['name'].', '.($shelf?'с полочкой':'без полочки').')')?>">
                <img src="/goods/45x45/<?=$good['id']?>.jpg">
              </a>
            </td>
            <td class="c3"><?=$good['name']?><div>размер: <span><?=$mod['name']?></span>, <span><?=$shelf?'с полочкой':'без полочки'?></span></div></td>
            <td class="c4"><?=price($price)?> руб.</td>
            <td class="c5"><?=chQuant('quant['.$mod['id'].']', $quant)?></td>
            <td class="c6"><?=price($amount)?> руб.</td>
            <td class="c7"><a href="" rel="nofollow" class="gdel glyphicon glyphicon-remove"></a></td>
          </tr>
					<?
				}
				?>
        </tbody>
        <tfoot>
          <tr class="total">
            <th colspan="5">Итого</th>
            <td class="c6"><?=price($_SESSION['cart']['total'])?> руб.</td>
            <td class="cell-fake"></td>
          </tr>
        </tfoot>
      </table>

      <h2>Контактная информация</h2>

      <div class="contacts-note content">
        <p>Личная информация о наших клиентах строго конфиденциальна!</p>
        <p>Нам нужны Ваши данные для того, чтобы Вы всегда могли получать такие важные уведомления как:</p>
        <ul>
          <li>уточнения по заказу;</li>
          <li>статус заказа;</li>
          <li>информация о горячих новинках;</li>
          <li>информация об актуальных акциях.</li>
        </ul>
        <p>СПАМ мы не рассылаем!<br>После регистрации Вы можете в личном кабинете выполнить настройку уведомлений.</p>
        <div class="checkbox" style="margin:0; color:#999;">
          <label>
            <input type="checkbox" name="sendmail" value="1" checked> я хочу получать уведомления об изменении статуса моего заказа по электронной почте
          </label>
        </div>
        <div class="checkbox" style="margin:0; color:#999;">
          <label>
            <input type="checkbox" name="subscribe" value="1" checked> я не против получать дополнительную информацию по электронной почте
          </label>
        </div>
      </div>

      <div class="user-data">
        <div class="fld"><label class="zv">Ваше ФИО</label><input type="text" name="user[name]" value="" class="form-control" placeholder="ФИО указывается полностью"></div>
        <div class="fld"><label class="zv">Ваш E-mail</label><input type="text" name="user[email]" value="" class="form-control" placeholder="Адрес почтового ящика"></div>
        <div class="fld"><label class="zv">Ваш телефон</label><input type="text" name="user[phone]" value="" class="form-control" placeholder="+7 (___) ___-__-__"></div>
        <div class="fld"><label>Почтовый индекс</label><input type="text" name="user[index]" value="" class="form-control" placeholder="Почтовый индекс"></div>
        <div class="fld"><label>Ваш адрес</label><input type="text" name="user[address]" value="" class="form-control" placeholder="Адрес доставки"></div>
        <?/*<div class="fld">
          <label>Ваш пароль:</label><input type="password" name="user[pwd]" value="" class="form-control" placeholder="минимум 6 символов">
          <span>необходим для входа в личный кабинет</span>
        </div>
        <div class="fld"><label>Повторите пароль:</label><input type="password" name="user[pwd-retry]" value="" class="form-control"></div>*/?>
        <div class="fld"><label>Примечание к заказу</label><textarea name="user[notes]" class="form-control" rows="5" placeholder="Ваш комментарий к заказу"></textarea></div>
      </div>

      <div style="text-align:center; padding-top:20px;">
        <div class="btn btn-default medium oform" onclick="$(this).addClass('disabled');$('#frm-order').submit();">Подтверждаю заказ</div>
        <div class="callme">
          <input type="hidden" name="callme" value="1">
          <span>после оформления заказа наш менеджер свяжется с Вам для уточнения информации</span>
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle btn-mini" data-toggle="dropdown"><b>да</b><span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">да, так надёжнее</a></li>
              <li><a href="#">нет, не нужно</a></li>
            </ul>
          </div>
        </div>
        <div class="confirm">Нажимая на кнопку «Подтверждаю заказ» я даю своё согласие на обработку моих <a href="/personal_data.htm" target="_blank">персональных данных</a>,
          в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных
          <a href="/privacy_policy.htm" target="_blank">Политикой конфиденциальности</a>.</div>
      </div>

    </form>
		<?

		break;
	// ----------------- КОРЗИНА ПУСТА
	case 'empty':

    $navigate = 'Корзина';

    $title = $page['name'];
    foreach(array('title','keywords','description') as $val)
      if($page[$val]) $$val = $page[$val];

    ob_start();
    echo catalog();
    $Lcol = ob_get_clean();

    ?>
    <h1>Корзина</h1>
    <div class="content">В данный момент Ваша корзина пуста</div>
    <a href="" class="back" rel="nofollow">назад</a>
    <?

		break;
	// ----------------- РЕЗУЛЬТАТ ЗАКАЗА ---------------------------
	case 'res':

	  if(!$_SESSION['orders'] || !$id_order = (int)$_GET['order']){ header("HTTP/1.0 404 Not Found"); $code = '404'; require('errors.php'); exit; }
		if(!in_array($id_order,(array)$_SESSION['orders'])){ header("HTTP/1.0 404 Not Found"); $code = '404'; require('errors.php'); exit; }
		if(!$order = getRow("SELECT * FROM {$prx}orders WHERE id='{$id_order}'")){ header("HTTP/1.0 404 Not Found"); $code = '404'; require('errors.php'); exit; }

		$title = $navigate = 'Информация о заказе';

		?>
    <link rel="stylesheet" type="text/css" href="/css/cart-print.css" media="print" />
    <style>
    .subtab { width:100%; margin-bottom:40px;}
    .subtab th, .subtab td { border:1px solid #D0E0F3; }
		.subtab thead th { background-color:#e7f3ff; padding:3px 10px; color:#006cb0; white-space:nowrap; text-align:center; width:20%; }
		.subtab thead th:nth-child(1) { width:1%;}
		.subtab thead th:nth-child(2) { width:50%;}
		.subtab tbody th { text-align:center;}
		.subtab tbody td { padding:10px 10px; }
		.subtab tbody td:nth-child(3), .subtab tbody td:nth-child(5) { text-align:right; padding-left:40px; white-space:nowrap; font: normal 24px/30px 'Source Sans Pro', sans-serif; color: #01a6ff;}
		.subtab tfoot td { padding:10px 10px; text-align:right; padding-left:40px; white-space:nowrap; font: normal 24px/30px 'Source Sans Pro', sans-serif; color: #01a6ff;}
		.subtab tfoot b { font-weight:400; color: #01a6ff;}
		.client-info b { font-weight:400; }
		</style>

		<h1 style="float:left">Заказ №<?=$order['number']?> от <?=date('d.m.Y')?></h1>
    <div style="float:left; margin:5px 0 0 20px;"><a title="распечатать" href="javascript:print();"><img src="/img/print.png" width="24" height="24"></a></div>
    <div class="clear"></div>

    <h2>Покупатель:</h2>
    <div class="client-info" style="margin-bottom:20px;"><?=$order['user_info']?></div>

    <h2>Информация о заказе:</h2>
    <?=$order['order_info']?>
		<?
		break;
}

$content = ob_get_clean();
require("tpl/tpl.php");