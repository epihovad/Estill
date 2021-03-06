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
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

  <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css"/>
  <link rel="stylesheet" href="/js/jquery/blueimp-gallery/blueimp-gallery.css" type="text/css" />
  <link rel="stylesheet" href="/js/jquery/blueimp-gallery/blueimp-gallery-indicator.css">
  <link rel="stylesheet" href="/css/style.css" type="text/css" />
	<?=$const['css_links']?>

  <script src="/js/jquery/jquery-3.1.1.min.js"></script>
  <script src="/js/jquery/jquery-migrate-3.0.0.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/jquery/blueimp-gallery/blueimp-gallery.js"></script>
  <script src="/js/jquery/blueimp-gallery/blueimp-gallery-indicator.js"></script>

  <script src="/js/jquery/arcticmodal/jquery.arcticmodal-0.3.min.js"></script>
  <link rel="stylesheet" href="/js/jquery/arcticmodal/jquery.arcticmodal-0.3.css">
  <link rel="stylesheet" href="/js/jquery/arcticmodal/themes/simple.css">
	<?=$const['js_links']?>
  <meta name="viewport" content="width=1263" />
  <meta name="format-detection" content="telephone=no">

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

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
  <div class="slides"></div>
  <h3 class="title"></h3>
  <a class="prev">‹</a>
  <a class="next">›</a>
  <a class="close">×</a>
  <a class="play-pause"></a>
  <ol class="indicator"></ol>
</div>

<div id="Header">
  <div id="inHeader">
    <div id="Header-top" class="row">
      <div class="col-md-4 text-left"></div>
      <div class="col-md-4 text-center"><?=set('greeting')?></div>
      <div class="col-md-4 text-right">
        <div class="btn btn-default fb-frm" tp="cns">бесплатная консультация</div>
      </div>
    </div>
    <div id="Header-middle">
      <a id="logo" class="fleft" href="/"><img src="/img/logo.png"></a>
      <div id="cart" class="fright">
        <a href="/cart/"><span><?=$_SESSION['cart']['quant']?></span></a>
      </div>
      <div id="feed-btns" class="fright">
        <div class="row">
          <div class="feed-phone col-md-4 item">
            <a href="" rel="nofollow" class="fleft fb-frm" tp="phone"></a>
            <div>бесплатный телефон</div><span><?=set('phone')?></span>
          </div>
          <div class="feed-mail col-md-4 item">
            <a href="" rel="nofollow" class="fleft fb-frm" tp="email"></a>
            <div><?=nl2br(set('email'))?></div>
          </div>
          <div class="feed-msg col-md-4 item">
            <a href="" rel="nofollow" class="fleft fb-frm" tp="msg"></a>
            <div>напишите нам и мы с радостью ответим на все Ваши вопросы</div>
          </div>
        </div>
      </div>
    </div>
    <div id="Header-bottom">
      <div class="line clear"></div>
      <?=main()?>
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
        <? if($Lcol){?>
        <div id="Lcol"><?=$Lcol?></div>
        <?}?>
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
            <a href="" rel="nofollow" class="fleft fb-frm" tp="phone"></a>
            <div>бесплатный телефон</div><span><?=set('phone')?></span>
          </div>
          <div class="feed-mail">
            <a href="" rel="nofollow" class="fleft fb-frm" tp="email"></a>
            <div><?=nl2br(set('email'))?></div>
          </div>
          <div class="feed-msg">
            <a href="" rel="nofollow" class="fleft fb-frm" tp="msg"></a>
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