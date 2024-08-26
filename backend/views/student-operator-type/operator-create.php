<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\StudentOperatorType;

$types = StudentOperatorType::find()
    ->where(['is_deleted' => 0])
    ->orderBy('id desc')
    ->all();

/** @var yii\web\View $this */
/** @var common\models\StudentOperatorType $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="student-operator-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'student_operator_type_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($types, 'id', 'name'),
            'options' => ['placeholder' => 'Type tanlang ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'text')->textarea(['rows' => 4]) ?>
    </div>

    <div class="form-group d-flex justify-content-end mt-3">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
