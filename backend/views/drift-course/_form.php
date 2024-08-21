<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use yii\helpers\ArrayHelper;
use common\models\Course;

/** @var yii\web\View $this */
/** @var common\models\DriftCourse $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="drift-course-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?= $form->field($model, 'price')->textInput() ?>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <?php $items = ArrayHelper::map(Course::find()->all(), 'id', 'name_uz'); ?>
                <?= $form->field($model, 'course_id')->dropDownList(
                    $items,
                    ['prompt'=>'Bosqich tanlang!']
                ); ?>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <?= $form->field($model, 'status')->dropDownList(
                    Status::accessStatus(),
                    ['class'=>'form-select form-control']) ?>
            </div>
        </div>
    </div>

    <div class="form-group d-flex justify-content-end mt-4">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
