<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <meta name="keywords" content="<?=$keywords?>" />
  <meta name="description" content="<?=$description?>" />
  <title><?=$title?></title>

  <link rel="icon" href="/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans" rel="stylesheet">

  <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css"/>
  <link rel="stylesheet" href="/css/style.css" type="text/css" />
	<?=$const['css_links']?>

  <script src="/js/jquery/jquery-3.1.1.min.js"></script>
  <script src="/js/jquery/jquery-migrate-3.0.0.js"></script>
  <script src="/js/bootstrap.min.js"></script>

  <script src="/js/jquery/arcticmodal/jquery.arcticmodal-0.3.min.js"></script>
  <link rel="stylesheet" href="/js/jquery/arcticmodal/jquery.arcticmodal-0.3.css">
  <link rel="stylesheet" href="/js/jquery/arcticmodal/themes/simple.css">
	<?=$const['js_links']?>
  <meta name="viewport" content="user-scalable=no,width=device-width" />

  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript" src="/js/utils.js"></script>
  <script type="text/javascript" src="/js/spec.js?v=1"></script>

  <script type="text/javascript" src="/js/jquery/jquery.mousewheel.min.js"></script>
  <script type="text/javascript" src="/inc/advanced/jB/jquery.jB.js"></script>
  <link rel="stylesheet" href="/inc/advanced/jAlert/jAlert.css" type="text/css" />
  <script type="text/javascript" src="/inc/advanced/jAlert/jquery.jAlert.js"></script>

</head>
<body>

<div id="Header">
  <div id="inHeader">
    <div id="Header-top" class="row">
      <div class="col-md-4 text-left"></div>
      <div class="col-md-4 text-center">Добро пожаловать в интернет магазин «ЕвроСтиль»</div>
      <div class="col-md-4 text-right">
        <div class="btn btn-default">бесплатная консультация</div>
      </div>
    </div>
    <div id="Header-middle">
      <a id="logo" class="fleft" href="/"><img src="/img/logo.png"></a>
      <div id="cart" class="fright">
        <a href="/cart/"><span>7</span></a>
      </div>
      <div id="feed-btns" class="fright">
        <div class="row">
          <div class="feed-phone col-md-4 item">
            <a href="#" rel="nofollow" class="fleft"></a>
            <div>бесплатный телефон</div><span>8-800-2000-600</span>
          </div>
          <div class="feed-mail col-md-4 item">
            <a href="#" rel="nofollow" class="fleft"></a>
            <div>firma@mail.ru<br>company@mail.ru</div>
          </div>
          <div class="feed-msg col-md-4 item">
            <a href="#" rel="nofollow" class="fleft"></a>
            <div>напишите нам и мы с радостью ответим на все Ваши вопросы</div>
          </div>
        </div>
      </div>
    </div>
    <div id="Header-bottom">
      <div class="line clear"></div>
      <ul id="main" class="row">
        <li class="col-md-2 active"><a href="/">На главную</a></li>
        <li class="col-md-2"><a href="">О компании</a></li>
        <li class="col-md-2"><a href="">Каталог</a></li>
        <li class="col-md-2"><a href="">Оптовикам</a></li>
        <li class="col-md-2"><a href="">Доставка и оплата</a></li>
        <li class="col-md-2"><a href="">Контакты</a></li>
      </ul>
    </div>
  </div>
</div>

<div id="Middle" class="<?=$index?'index':''?>">
  <div id="inMiddle">
    <?
    if($index){
      echo $content;
    } else {
      ?>
      <div class="inMiddle">
        <div id="Lcol"><?=$Lcol?></div>
        <div id="Center"><?=navigate()?><?=$content?></div>
      </div>
      <?
    }
    ?>
    <div class="clear"></div>
  </div>
</div>

<div id="Footer">
  <div id="inFooter">
    <div class="row">
      <div class="col-md-4"><a id="logo" class="fleft" href="/"><img src="/img/logo.png"></a></div>
      <div class="col-md-4">
        <div class="fnews">
          <div class="h">Новостная рассылка</div>
          <div class="sep"></div>
          <div class="info">Подпишитесь на наши последние новости. Не пропустите анонс интересных и выгодных предложений, новинок и специльных предложений.</div>
          <input type="text" class="form-control" placeholder="Введите Ваш E-mail">
          <div class="btn btn-default">Подписаться</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="contacts">
          <div class="h">Наши контакты</div>
          <div class="sep"></div>
          <div class="feed-phone">
            <a href="#" rel="nofollow" class="fleft"></a>
            <div>бесплатный телефон</div><span>8-800-2000-600</span>
          </div>
          <div class="feed-mail">
            <a href="#" rel="nofollow" class="fleft"></a>
            <div>firma@mail.ru<br>company@mail.ru</div>
          </div>
          <div class="feed-msg">
            <a href="#" rel="nofollow" class="fleft"></a>
            <div>напишите нам и мы с радостью ответим на все Ваши вопросы</div>
          </div>
        </div>
      </div>
    </div>
    <div class="copy">© 2010-<?=date('Y')?> Все права защищены</div>
  </div>
</div>

<iframe name="ajax" id="ajax"></iframe>

</body>
</html>