<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\Std $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="std-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'student_phone')
                            ->widget(\yii\widgets\MaskedInput::class, [
                                'mask' => '+\9\9\8 (99) 999-99-99',
                                'options' => [
                                    'placeholder' => '+998 (__) ___-__-__',
                                ],
                            ]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'gender')->dropDownList(
                            Status::gender(),
                            ['class'=>'form-select form-control']) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Tug\'ilgan sana'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'passport_serial')->textInput([
                            'maxlength' => true,
                            'placeholder' => '__',
                            'oninput' => "this.value = this.value.replace(/\\d/, '').toUpperCase()"
                        ]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'passport_number')->widget(\yii\widgets\MaskedInput::class, [
                            'mask' => '9999999',
                            'options' => [
                                'placeholder' => '_______',
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'passport_pin')->widget(\yii\widgets\MaskedInput::class, [
                            'mask' => '99999999999999',
                            'options' => [
                                'placeholder' => '______________',
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'passport_issued_date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Pasport berilgan sana'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'passport_given_date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Pasport amal qilish sanasi'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'passport_given_by')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'status')->dropDownList(
                            Status::stdStatus(),
                            ['class'=>'form-select form-control']) ?>
                    </div>
                </div>

                <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'adress')->textInput() ?>
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
