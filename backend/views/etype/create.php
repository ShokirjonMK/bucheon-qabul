<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Etype $model */

$this->title = Yii::t('app', 'Create Etype');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Etypes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
