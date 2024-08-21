<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Status;
use common\models\EduYear;
use common\models\EduForm;
use common\models\Languages;

/** @var yii\web\View $this */
/** @var common\models\DriftForm $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="drift-form-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'edu_dureation')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'language_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Languages::find()->all(), 'id', 'name_uz'),
                            'options' => ['placeholder' => 'Ta\'lim tilini tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'edu_form_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(EduForm::find()->all(), 'id', 'name_uz'),
                            'options' => ['placeholder' => 'Ta\'lim shaklini tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'edu_year_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(EduYear::find()->all(), 'id', 'name'),
                            'options' => ['placeholder' => 'Ta\'lim yilini tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'status')->dropDownList(
                            Status::accessStatus(),
                            ['class'=>'form-select form-control']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group d-flex justify-content-end mt-4 mb-5">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
