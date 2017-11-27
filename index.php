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
      <div class="row">
        <div class="col-md-4 item">
          <a href="#">
            <img src="/img/good-list.jpg">
            <div class="sep"></div>
            <div class="name">Комплектующие для полотенцесушителей</div>
          </a>
        </div>
        <div class="col-md-4 item">
          <a href="#">
            <img src="/img/good-list.jpg">
            <div class="sep"></div>
            <div class="name">Водяные полотенцесушители</div>
          </a>
        </div>
        <div class="col-md-4 item">
          <a href="#">
            <img src="/img/good-list.jpg">
            <div class="sep"></div>
            <div class="name">Электрические полотенцесушители</div>
          </a>
        </div>
      </div>
      <div class="clear" style="padding-top:50px;"></div>
      <div class="btn medium btn-default">перейти в каталог</div>
    </div>
  </div>

  <script type="text/javascript" src="/js/jquery/parallax.min.js"></script>
  <div id="about-us" data-parallax="scroll" data-image-src="/img/about-bg.jpg">
    <div class="inMiddle">
      <div class="h">
        Компания «...» - один из крупнейших производителей
        полотенцесушителей с огромным количеством
        благодарных клиентов.
      </div>
      <div class="sep"></div>
      <div class="note">
        Постоянное увеличение и совершенствование ассортимента продукции, внедрение инновационных производственных процессов,
        широкая сеть каналов сбыта по всей России и странам СНГ — все это позволяет компании «...» сохранять лидирующие позииции на рынке долгие годы.
      </div>
    </div>
  </div>

  <div id="clients">
    <div class="inMiddle">
      <div class="h">Наши благодарные клиенты</div>
      <div class="sep"></div>
      <div class="row">
        <? for($i=0; $i<4; $i++){?>
        <div class="col-md-3 item">
          <div class="author">
            <img src="/img/client.jpg">
            <div class="name">Ольга</div>
            <div class="prof">Домохозяйка</div>
          </div>
          <div class="clear"></div>
          <div class="sep"></div>
          <div class="txt">
            На прошлой неделе приобрели
            в компании «...» новый полотенцесушитель.
            Выбрали угловой с боковым подключением.
            Места у нас в ванной комнате не очень
            много, поэтому приходится экономить
            каждый сантиметр.
            Работает превосходно.
            Полотенца и мелкие вещи сушит очень
            быстро. Покупкой очень довольна.
            Рекомендую всем.
          </div>
        </div>
				<?}?>
      </div>
    </div>
  </div>

  <div id="blog">
    <div class="inMiddle">
      <div class="h">Наш блог</div>
      <div class="sep"></div>
      <div class="clear" style="padding-top:60px;"></div>
      <div class="posts">
				<? for($i=0; $i<6; $i++){?>
        <a href="" class="post">
          <div class="im"><img src="/img/post.jpg"></div>
          <div class="preview">
            <div class="name">Как правильно установить полотенцесушитель</div>
            <div class="date">22.10.2017</div>
            <div class="txt">Полотенцесушитель в ванной комнате – чрезвычайно удобный прибор. Благодаря ему, комфортность пользования этим помещением значительно возрастает. Всегда есть возможность просушить влажные полотенца, одеть после душа теплый халат, а для молодых мам очень важным моментом является и сушка детских вещей после экспресс-стирок, которые порой случаются по нескольку раз на день. Да и в самой ванной от размещённого на стене полотенцесушителя — значительно теплее, так как он играет еще и роль своеобразного радиатора отопления.</div>
          </div>
        </a>
				<?}?>
      </div>
      <div class="clear"></div>
    </div>
  </div>
<?

$content = ob_get_clean();
require('tpl/tpl.php');