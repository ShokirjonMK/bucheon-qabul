<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var common\models\StudentPerevot $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="check-perevot-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file_status')->widget(Select2::classname(), [
        'data' => Status::perStatus(),
        'options' => ['placeholder' => 'Status tanlang ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group mt-2">
        <?= $form->field($model, 'sms_text')->textarea(['rows' => 6]) ?>
    </div>

    <div class="form-group d-flex justify-content-end mt-3">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
$(document).ready(function() {
        $(".check-perevot-form #studentperevot-file_status").on('change', function () {
            var id = $(this).val();
            var text2 = 'Tabriklaymiz! Sizning “TASHKENT PERFECT UNIVERSITY”ga o\'qishni ko\'chirish uchun topshirgan arizangiz qabul qilindi. Tizimdan shartnoma yuklab olishni unutmang. Shaxsiy hujjatlaringizni universitet binosiga olib kelib topshirishingiz mumkin. Aloqa markazi: 77 129 29 29';
            var text3 = 'Hurmatli abituriyent! Sizning arizangiz rad etildi. Ta\'lim yo\'nalishi, o\'quv kursi va transkript faylni to\'g\'ri tanlab qayta ariza yuborishingiz mumkin.  Manzil: Toshkent shahar, Yunusobod tumani, Bog’ishamol ko’chasi 220-uy. Aloqa markazi: 77 129 29 29.';
            if (id == 3) {
                $(".check-perevot-form #studentperevot-sms_text").val(text3)
            } else {
                if (id == 2) {
                    $(".check-perevot-form #studentperevot-sms_text").val(text2)
                } else {
                    $(".check-perevot-form #studentperevot-sms_text").val('')
                }
            }
            
        });
    });
JS;
$this->registerJs($js);
?>
