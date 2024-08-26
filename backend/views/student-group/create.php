<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StudentGroup $model */

$this->title = Yii::t('app', 'Create Student Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
