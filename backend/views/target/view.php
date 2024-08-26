<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use Da\QrCode\QrCode;

/** @var yii\web\View $this */
/** @var common\models\Target $model */

$this->title = $model->name;
$user = Yii::$app->user->identity;
?>
<div class="target-view">

    <?php if ($user->user_role == 'supper_admin'): ?>
        <p class="mb-3 mt-2">
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'b-btn b-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'b-btn b-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>

    <div class="grid-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
            ],
        ]) ?>
    </div>

    <div class="form-section mt-3">
        <div class="form-section_item">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <?php
                        $url = "https://qabul.tpu.uz?id=".$model->id;
                    ?>
                    <h6 class="badge-table-div active"><?= $url ?></h6>
                    <div class="mt-3">
                        <?php
                        $lqr = (new QrCode($url))->setSize(300, 300)
                            ->setMargin(5);
                        $limg = $lqr->writeDataUri();
                        ?>
                        <img src="<?= $limg ?>" width="200px">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <?php
                    $url2 = "https://qabul.tpu.uz/site/sign-up?id=".$model->id;
                    ?>
                    <h6 class="badge-table-div active"><?= $url2 ?></h6>
                    <div class="mt-3">
                        <?php
                        $lqr2 = (new QrCode($url2))->setSize(300, 300)
                            ->setMargin(5);
                        $limg2 = $lqr2->writeDataUri();
                        ?>
                        <img src="<?= $limg2 ?>" width="200px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
