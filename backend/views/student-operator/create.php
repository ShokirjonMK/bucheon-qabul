<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StudentOperator $model */

$this->title = Yii::t('app', 'Create Student Operator');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Operators'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-operator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
