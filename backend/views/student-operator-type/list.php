<?php

use yii\helpers\Html;

/** @var common\models\StudentOperator $models */
?>

<div class="student-operator-type-form">

    <?php if (count($models) > 0) : ?>
        <?php $a = false ?>
        <?php foreach ($models as $model): ?>
            <div class="<?= $a ? 'mt-3' : ''; ?>">
                <div class="view-info-right">
                    <div class="subject_box">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="subject_box_left">
                                <p>Oxirgi bog'langan operator:</p>
                            </div>
                            <div class="subject_box_right">
                                <h6><?= $model->user->employeeFullName; ?></h6>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="subject_box_left">
                                <p>Oxirgi bog'langan vaqt:</p>
                            </div>
                            <div class="subject_box_right">
                                <h6><?= date("Y-m-d H:i:s" , $model->date); ?></h6>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="subject_box_left">
                                <p>Oxirgi xolati:</p>
                            </div>
                            <div class="subject_box_right">
                                <h6><?= $model->studentOperatorType->name; ?></h6>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <div class="subject_box_left">
                                <p>Oxirgi qisqacha ma'lumot:</p>
                            </div>
                            <div class="subject_box_right">
                                <h6>
                                    <?= $model->text; ?>
                                </h6>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php $a = true ?>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
