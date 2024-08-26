<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\models\Student;
use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use common\widgets\Alert;

AppAsset::register($this);
$user = Yii::$app->user->identity;
$student = Student::findOne(['user_id' => $user->id]);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link href="/admin/edu-assets/image/home-image/logo.svg" rel="icon">
        <link href="/admin/edu-assets/image/home-image/logo.svg" rel="apple-touch-icon">
        <script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?= $this->render('loading') ; ?>

    <div class="root">
        <?= $this->render('_cabinet-header' , [
             'student' => $student
        ]) ; ?>
        <div class="cab_content">
            <div class="cab_content-left">
                <?= $this->render('_cabinet-sidebar' , [
                    'student' => $student
                ]) ; ?>
            </div>
            <div class="cab_content-right">
                <?= $content ?>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    <?= Alert::widget() ?>
    </body>
    </html>
<?php $this->endPage();
