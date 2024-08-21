<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Status;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\EduYear;
use common\models\Course;

/** @var yii\web\View $this */
/** @var common\models\DriftForm $driftForm */
/** @var common\models\DriftFormSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Ta\'lim shakli';
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => 'Yo\'nalish ( '.$driftForm->drift->name_uz.' )',
    'url' => ['drift/view' , 'id' => $driftForm->drift_id],
];
\yii\web\YiiAsset::register($this);
?>
<div class="drift-form-view">

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
                                                <p>Ta'lim yili:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $driftForm->eduYear->name ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Ta'lim shakli:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $driftForm->eduForm->name_uz ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Ta'lim tili:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $driftForm->language->name_uz ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>O'qish davomiyligi:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $driftForm->edu_dureation ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-3 align-items-center mt-3">
                                            <?= Html::a(Yii::t('app', 'Tahrirlash'), ['update', 'id' => $driftForm->id],
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
                                                <p>Ta'lim yo'nalishi:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $driftForm->drift->name_uz ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Yo'nalish kodi:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $driftForm->drift->code ?></h6>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="subject_box_left">
                                                <p>Yo'nalish kodi:</p>
                                            </div>
                                            <div class="subject_box_right">
                                                <h6><?= $driftForm->drift->etype->name_uz ?></h6>
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
                'attribute' => 'Boshqich',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->course->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'course_id',
                    ArrayHelper::map(Course::find()->all(), 'id', 'name_uz'),
                    ['class'=>'form-control','prompt' => 'Boshqich']),
            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value' => function ($model) {
                    return number_format((int)$model->price, 0, '', ' ');
                },
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
                    'view'   => function () {
                        return false;
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['drift-course/update', 'id' => $model->id]);
                        return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                            'title' => 'update',
                            'class' => 'tableIcon',
                            "data-bs-toggle" => "modal",
                            "data-bs-target" => "#driftCourseUpdate",
                        ]);
                    },
                    'delete' => function () {
                        return false;
                    },
                ]
            ],
        ],
    ]); ?>
</div>

<?php
$js = <<<JS
$(document).ready(function() {
    $('#driftCourseUpdate').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#driftCourseUpdateBody').load(url);
    });
});
JS;
$this->registerJs($js);
?>

<div class="modal fade" id="driftCourseUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="form-section">
                <div class="form-section_item">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Tahrirlash</h1>
                        <p class="btn-close" data-bs-dismiss="modal" aria-label="Close"></p>
                    </div>
                    <div class="modal-body" id="driftCourseUpdateBody">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>