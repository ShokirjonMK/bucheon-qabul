<?php

use common\models\Target;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Student;

/** @var yii\web\View $this */
/** @var common\models\TargetSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Targets');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$user = Yii::$app->user->identity;
$baseQuery = Student::find()
    ->alias('s')
    ->innerJoin('user u', 's.user_id = u.id')
    ->where(['u.cons_id' => $user->cons_id, 'u.user_role' => 'student']);

?>
<div class="target-index">

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

    <?php if (!($user->user_role == "moderator" || $user->user_role == "student")): ?>
        <div class="mb-3 mt-4">
            <?= Html::a(Yii::t('app', 'Qo\'shish'), ['create'], ['class' => 'b-btn b-primary']) ?>
        </div>
    <?php endif; ?>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'SMS kod tasdiqlamagan',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery, $user) {
                    $query = (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 9,
                            'u.step' => 1,
                            'u.cons_id' => $user->cons_id,
                            'u.target_id' => $model->id,
                        ])->count();
                    return $query;
                }
            ],
            [
                'attribute' => '1 qadam',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery, $user) {
                    $query = (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 1,
                            'u.cons_id' => $user->cons_id,
                            'u.target_id' => $model->id,
                        ])->count();
                    return $query;
                }
            ],
            [
                'attribute' => '2 qadam',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery, $user) {
                    $query = (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 2,
                            'u.cons_id' => $user->cons_id,
                            'u.target_id' => $model->id,
                        ])->count();
                    return $query;
                }
            ],
            [
                'attribute' => '3 qadam',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery, $user) {
                    $query = (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 3,
                            'u.cons_id' => $user->cons_id,
                            'u.target_id' => $model->id,
                        ])->count();
                    return $query;
                }
            ],
            [
                'attribute' => '4 qadam',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery, $user) {
                    $query = (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 4,
                            'u.cons_id' => $user->cons_id,
                            'u.target_id' => $model->id,
                        ])->count();
                    return $query;
                }
            ],
            [
                'attribute' => 'Qabul',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery, $user) {
                    $query = (clone $baseQuery)
                        ->andWhere([
                            's.edu_year_type_id' => 1,
                            'u.step' => 5,
                            'u.cons_id' => $user->cons_id,
                            'u.target_id' => $model->id,
                        ])->count();
                    return $query;
                }
            ],
            [
                'attribute' => 'o\'qishni ko\'chirish',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery, $user) {
                    $query = (clone $baseQuery)
                        ->andWhere([
                            's.edu_year_type_id' => 2,
                            'u.step' => 5,
                            'u.cons_id' => $user->cons_id,
                            'u.target_id' => $model->id,
                        ])->count();
                    return $query;
                }
            ],
            [
                'attribute' => 'DTM',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery, $user) {
                    $query = (clone $baseQuery)
                        ->andWhere([
                            's.edu_year_type_id' => 3,
                            'u.step' => 5,
                            'u.cons_id' => $user->cons_id,
                            'u.target_id' => $model->id,
                        ])->count();
                    return $query;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'd-flex justify-content-around'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        $url = Url::to(['view', 'id' => $model->id]);
                        return Html::a('URL', $url, [
                            'title' => 'view',
                            "data-bs-toggle" => "modal" , "data-bs-target" => "#targetViewModal" , 'data-toggle' => "modal",
                            'class' => 'badge-table-div active',
                        ]);
                    },
                    'update' => function ($url, $model) use ($user) {
                        $userRole = $user->user_role;
                        if ($userRole == "moderator" || $userRole == "student") {
                            return false;
                        }
                        $url = Url::to(['update', 'id' => $model->id]);
                        return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                            'title' => 'update',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return false;
                    },
                ]
            ],
        ],
    ]); ?>

    <div class="modal fade" id="targetViewModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="form-section">
                    <div class="form-section_item">
                        <div class="modal-header">
                            <div class="page-title-box m-0 p-0">
                                <h5>Target ma'lumotlari</h5>
                            </div>
                            <p class="btn-close" data-bs-dismiss="modal" aria-label="Close"></p>
                        </div>
                        <div class="modal-body" id="targetViewModalLoad">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$js = <<<JS
    $(document).ready(function() {
        $('#targetViewModal').on('show.bs.modal', function (e) {
            $(this).find('#targetViewModalLoad').load(e.relatedTarget.href);
        });
    });
JS;
$this->registerJs($js);
?>
