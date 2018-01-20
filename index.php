<?
require('inc/common.php');
ob_start();

?>
<?=islider()?>
<div id="advant">
  <div class="inMiddle">
    <div class="row">
      <div class="col-md-3 item">
        <div class="im"></div>
        <div class="prm">100%</div>
        <div class="sep"></div>
        <div class="note">Гарантия качества</div>
      </div>
      <div class="col-md-3 item">
        <div class="im"></div>
        <div class="prm">10</div>
        <div class="sep"></div>
        <div class="note">Лет на рынке</div>
      </div>
      <div class="col-md-3 item">
        <div class="im"></div>
        <div class="prm">16 500</div>
        <div class="sep"></div>
        <div class="note">Довольных клиентов</div>
      </div>
      <div class="col-md-3 item">
        <div class="im"></div>
        <div class="prm">?</div>
        <div class="sep"></div>
        <div class="note">Еще что-то важное</div>
      </div>
    </div>
  </div>
</div>

<div id="icatalog">
  <div class="inMiddle">
    <div class="h">Наш каталог</div>
    <div class="note">на текущий момент каталог насчитывает несколько десятков наименований</div>
    <div class="triangle"></div>
  </div>
</div>

<div id="catlist">
  <div class="inMiddle">
    <?
    $r = sql("SELECT * FROM {$prx}catalog WHERE id_parent='0' AND status=1 ORDER BY sort,id");
    if(@mysql_num_rows($r)){
      $i=0;
      while ($rb = mysql_fetch_assoc($r)){
        if($i++%3==0){ ?><div class="row"><? }
        ?>
        <div class="col-md-4 item">
          <a href="<?=getCatUrl($rb)?>">
            <img src="/catalog/250x250/<?=$rb['id']?>.jpg" height="235">
            <div class="sep"></div>
            <div class="name"><?=wordwrap($rb['name'], 50, '<br>')?></div>
          </a>
        </div>
        <?
      }
      ?></div><?
    }?>
    <div class="clear" style="padding-top:50px;"></div>
    <div class="btn medium btn-default">перейти в каталог</div>
  </div>
</div>

<script type="text/javascript" src="/js/jquery/parallax.min.js"></script>
<div id="about-us" data-parallax="scroll" data-image-src="/img/about-bg.jpg">
  <div class="inMiddle">
    <div class="h">
      Компания «ЕвроСтиль» - один из крупнейших производителей
      полотенцесушителей с огромным количеством
      благодарных клиентов.
    </div>
    <div class="sep"></div>
    <div class="note">
      Постоянное увеличение и совершенствование ассортимента продукции, внедрение инновационных производственных процессов,
      широкая сеть каналов сбыта по всей России и странам СНГ — все это позволяет компании «ЕвроСтиль» сохранять лидирующие позииции на рынке долгие годы.
    </div>
  </div>
</div>

<div id="clients">
  <div class="inMiddle">
    <div class="h">Наши благодарные клиенты</div>
    <div class="sep"></div>
    <div class="row">
      <?
      $r = sql("SELECT * FROM {$prx}reviews_index WHERE status=1 ORDER BY RAND() LIMIT 4");
      if(@mysql_num_rows($r)) {
        while ($arr = mysql_fetch_assoc($r)) {
          ?>
          <div class="col-md-3 item">
            <div class="author">
              <img src="/reviews/47x47/<?=$arr['id']?>.jpg">
              <div class="name"><?=$arr['name']?></div>
              <div class="prof"><?=$arr['prof']?></div>
            </div>
            <div class="clear"></div>
            <div class="sep"></div>
            <div class="txt"><?=$arr['text']?></div>
          </div>
          <?
        }
      }
      ?>
    </div>
  </div>
</div>

<?
$r = sql("SELECT * FROM {$prx}blog WHERE status=1 ORDER BY `date` DESC LIMIT " . (int)set('count_blog_index') ?: 3);
if(mysql_num_rows($r)){
  ?>
  <div id="blog">
    <div class="inMiddle">
      <div class="h">Наш блог</div>
      <div class="sep"></div>
      <div class="clear" style="padding-top:60px;"></div>
      <div class="posts"><?
      while($post = mysql_fetch_assoc($r)){
				$link = "/blog/{$post['link']}.htm";
        ?>
        <a href="<?=$link?>" class="post">
          <div class="im"><img src="/blog/-x270/<?=$post['id']?>.jpg"></div>
          <div class="preview">
            <div class="name"><?=$post['name']?></div>
            <div class="date"><?=getRusDate('d M y',$post['date'])?></div>
            <div class="txt"><?=$post['preview']?></div>
          </div>
        </a>
        <?
      } ?></div>
      <div class="clear"></div>
    </div>
  </div>
  <?
}

$content = ob_get_clean();
require('tpl/tpl.php');