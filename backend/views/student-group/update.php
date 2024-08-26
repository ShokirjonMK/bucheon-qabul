<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StudentGroup $model */

$this->title = Yii::t('app', 'Update Student Group: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="student-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
