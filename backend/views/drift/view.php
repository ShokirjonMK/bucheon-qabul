<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Status;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\EduYear;
use common\models\Languages;
use common\models\EduForm;

/** @var yii\web\View $this */
/** @var common\models\Drift $drift */
/** @var common\models\DriftFormSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $drift->name_uz;
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Yo\'nalishlar'),
    'url' => ['index'],
];
\yii\web\YiiAsset::register($this);
?>
<div class="page">
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
                                                <p>Name Uz:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $drift->name_uz ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Name Ru:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $drift->name_ru ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Name En:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $drift->name_en ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-3 align-items-center mt-3">
                                            <?= Html::a(Yii::t('app', 'Tahrirlash'), ['update', 'id' => $drift->id],
                                                [
                                                    'class' => 'sub_links',
                                                ])
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="view-info-right">
                                    <div class="subject_box">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Yo'nalish kodi:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $drift->code ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Yo'nalish Turi:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $drift->etype->name_uz ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="subject_box_left">
                                                <p>Status:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= Status::accessStatusId($drift->status) ?></h6>
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

    <div class="mb-3 mt-4">
        <?= Html::a(Yii::t('app', 'Qo\'shish'), ['drift-form/create' , 'id' => $drift->id], ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'edu_dureation',
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
            [
                'attribute' => 'language_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->language->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'language_id',
                    ArrayHelper::map(Languages::find()->all(), 'id', 'name_uz'),
                    ['class'=>'form-control','prompt' => 'Ta\'lim tili']),
            ],
            [
                'attribute' => 'edu_form_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->eduForm->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'edu_form_id',
                    ArrayHelper::map(EduForm::find()->all(), 'id', 'name_uz'),
                    ['class'=>'form-control','prompt' => 'Ta\'lim shakli']),
            ],
            [
                'attribute' => 'status',
                'contentOptions' => ['date-label' => 'status'],
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->status == 1) {
                        return "<div class='badge-table-div active'><span>Faol</span></div>";
                    } elseif ($model->status == 0) {
                        return "<div class='badge-table-div inactive'><span>No faol</span></div>";
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'status',
                    Status::accessStatus(),
                    ['class'=>'form-control','prompt' => 'Status ...']),
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'd-flex justify-content-around'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        $url = Url::to(['drift-form/view', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'view',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['drift-form/update', 'id' => $model->id]);
                        return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                            'title' => 'update',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['drift-form/delete', 'id' => $model->id]);
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
