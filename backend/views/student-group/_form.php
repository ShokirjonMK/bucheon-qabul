<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\Drift;
use common\models\DriftForm;
use common\models\DriftCourse;

/** @var yii\web\View $this */
/** @var common\models\StudentGroup $model */
/** @var yii\widgets\ActiveForm $form */

$driftCourse = [];
$dCourses = DriftCourse::find()
    ->where(['is_deleted' => 0])
    ->all();
if (count($dCourses) > 0) {
    foreach ($dCourses as $dCours) {
        $dForm = $dCours->driftForm;
        $d = $dForm->drift;
        $driftCourse[$dCours->id] = $d->name_uz. " | ".$dCours->course->name_uz." | ".$dForm->eduForm->name_uz." | ".$dForm->language->name_uz." | ".$dForm->eduYear->name;
    }
}
?>

<div class="student-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'drift_course_id')->widget(Select2::classname(), [
                            'data' => $driftCourse,
                            'options' => ['placeholder' => 'Yo\'nalish tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'price')->textInput() ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
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

<?php
$js = <<<JS
    $(document).ready(function() {
        $("#studentgroup-drift_course_id").on('change', function () {
            var id = $(this).val();
            $.ajax({
                    url: '../drift-course/price/',
                    data: {id: id},
                    type: 'POST',
                    success: function (data) {
                        $("#studentgroup-price").val(data);
                    },
                    error: function () {
                        alert("Xatolik!!!");
                    }
                });
        });
    });
JS;
$this->registerJs($js);
?>
