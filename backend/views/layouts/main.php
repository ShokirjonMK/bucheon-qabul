<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\bootstrap5\Html;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">

        <?= $this->render('_meta');?>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?= $this->render('_css'); ?>
        <link href="/admin/edu-assets/image/home-image/logo.svg" rel="icon">
        <link href="/admin/edu-assets/image/home-image/logo.svg" rel="apple-touch-icon">
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="pageLoading">
        <div class="ik_loader">
            <div class="ik_load"></div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="none">
                <path d="M64 448H148.627V64H64V448ZM363.372 448H448V64H363.372V448ZM263.562 448H348.189V64H263.562V448ZM163.811 309.898H248.438V64H163.811V309.898Z" fill="#fff"/>
            </svg>
        </div>
        <h5>TASHKENT PERFECT <br> UNIVERSITY </h5>
    </div>

    <div class="root">

        <?= $this->render('_sidebar');?>

        <div class="root_right">

            <?= $this->render('_header');?>

            <div class="content left-260">
                <div class="main-content">
                    <?= $content ?>
                </div>
            </div>

        </div>

    </div>

    <?= $this->render('_script');?>
    <?php $this->endBody() ?>
    <?= Alert::widget() ?>
    </body>
    </html>
<?php $this->endPage();
