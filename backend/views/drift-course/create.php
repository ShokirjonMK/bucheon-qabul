<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DriftCourse $model */

$this->title = Yii::t('app', 'Create Drift Course');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Drift Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drift-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
