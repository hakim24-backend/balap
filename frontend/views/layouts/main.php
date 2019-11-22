<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$this->title = 'Race Event';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <header id="header">
      <div class="container">

        <div id="logo" class="pull-left">
          <!-- Uncomment below if you prefer to use a text logo -->
          <!-- <h1><a href="#main">C<span>o</span>nf</a></h1>-->
          <a href="http://localhost:8080/balap" class="scrollto"><img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo.png' ?>" alt="" title=""></a>
        </div>

        <nav id="nav-menu-container">
          <ul class="nav-menu">
            <li class="menu-active"><a href="#intro">Home</a></li>
            <li><a href="<?=Url::to(['site/index'])?>#about">About</a></li>
            <li><a href="<?=Url::to(['site/index'])?>#schedule">Schedule</a></li>
            <li><a href="<?=Url::to(['site/index'])?>#venue">Gallery</a></li>
            <li><a href="<?=Url::to(['site/index'])?>#venue">Article</a></li>
  <!--           <li><a href="#contact">Contact</a></li> -->
            <li class="buy-tickets"><a href="index.php#contact">Contact</a></li>
          </ul>
        </nav><!-- #nav-menu-container -->
      </div>
    </header><!-- #header -->

  <main id="main" class="main-page">

  <?= $content ?>

  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-9 col-md-6 footer-info">
            <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo.png' ?>" alt="TheEvenet">
            <p>In alias aperiam. Placeat tempore facere. Officiis voluptate ipsam vel eveniet est dolor et totam porro. Perspiciatis ad omnis fugit molestiae recusandae possimus. Aut consectetur id quis. In inventore consequatur ad voluptate cupiditate debitis accusamus repellat cumque.</p>
          </div>


          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              Jl. Ploso Baru No.110 <br>
              Surabaya, Jawa Timur 535022<br>
              Indonesia <br>
              <strong>Phone:</strong> +62 5589 55488 55<br>
              <strong>Email:</strong> info@example.com<br>
            </p>

            <div class="social-links">
              <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
              <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Balap</strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=TheEvent
        -->
        Developed by <a href="https://mamorasoft.com/">Mamorasoft</a>
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

  <?php
    if (class_exists('yii\debug\Module')) {
        $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
    }
  ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
