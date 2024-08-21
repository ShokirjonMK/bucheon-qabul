<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Status;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Drift;
use common\models\DriftForm;
use common\models\Course;
use common\models\Languages;
use common\models\EduYear;
use common\models\DriftCourse;

/** @var yii\web\View $this */
/** @var common\models\Std $std */
/** @var common\models\StudentGroupSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $std->last_name." ".$std->first_name." ".$std->middle_name;
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Talabalar'),
    'url' => ['index'],
];
\yii\web\YiiAsset::register($this);
?>
<div class="std-view">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php
            foreach ($breadcrumbs['item'] as $item) {
                echo "<li class='breadcrumb-item'><a href='". Url::to($item['url']) ."'>". $item['label'] ."</a></li>";
            }
            ?>
            <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
        </ol>
    </nav>

    <p class="mb-3">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $std->id], ['class' => 'b-btn b-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $std->id], [
            'class' => 'b-btn b-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="page-item mb-4">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-section">
                    <div class="form-section_item">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="view-info-right">
                                    <div class="subject_box">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>F.I.O:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->last_name." ".$std->first_name." ".$std->middle_name ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Telefon raqam:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->student_phone ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>JSHIR:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->passport_pin ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Seriya va Raqam:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->passport_serial." ".$std->passport_number ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Tug'ilgan sana:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->birthday ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="subject_box_left">
                                                <p>Status:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= Status::stdStatus($std->status) ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="view-info-right">
                                    <div class="subject_box">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Jisni:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= Status::genderId($std->gender) ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Pasport berilgan sana:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->passport_issued_date ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Pasport amal qilish sanasi:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->passport_given_date ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Pasport berilgan joy:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->passport_given_by ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="subject_box_left">
                                                <p>Manzil:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $std->adress ?></h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <p class="mt-4 mb-3">
        <?= Html::a(Yii::t('app', 'Boshqich qoshish'), ['student-group/create' , 'id' => $std->id], ['class' => 'b-btn b-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'drift_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->drift->name_uz;
                }
            ],
            [
                'attribute' => 'drift_form_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $driftForm = $model->driftForm;
                    return $driftForm->eduForm->name_uz." | ".$driftForm->language->name_uz;
                }
            ],
            [
                'attribute' => 'edu_year_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->eduYear->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'edu_year_id',
                    ArrayHelper::map(EduYear::find()->all(), 'id', 'name'),
                    ['class'=>'form-control','prompt' => 'Ta\'lim yili']),
            ],
            'price',
            [
                'attribute' => 'status',
                'contentOptions' => ['date-label' => 'adress'],
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->status == 1) {
                        return "<div class='badge-table-div active'><span>Faol</span></div>";
                    } elseif ($model->status == 0) {
                        return "<div class='badge-table-div inactive'><span>No faol</span></div>";
                    }
                },
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'd-flex justify-content-around'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'view'   => function () {
                        return false;
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['student-group/update', 'id' => $model->id]);
                        return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                            'title' => 'update',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['student-group/delete', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title'        => 'delete',
                            'class' => 'tableIcon',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method'  => 'post',
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>
</div>



