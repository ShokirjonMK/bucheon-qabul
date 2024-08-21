<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DriftCourse $model */

$this->title = Yii::t('app', 'Update Drift Course: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Drift Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="drift-course-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
