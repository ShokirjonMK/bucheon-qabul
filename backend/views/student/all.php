<?php

use common\models\StudentDtm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Status;
use kartik\export\ExportMenu;
use yii\widgets\LinkPager;


/** @var yii\web\View $this */
/** @var common\models\StudentDtmSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \common\models\EduYearType $edu_type */

$this->title = Yii::t('app', 'Students');
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
?>
<div class="student-dtm-index">

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

    <?php echo $this->render('_all-search', ['model' => $searchModel]); ?>

    <?php $data = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'F.I.O',
            'contentOptions' => ['date-label' => 'F.I.O'],
            'format' => 'raw',
            'value' => function($model) {
                if ($model->user->step == 1) {
                    return "---- ---- ----";
                }
                return $model->last_name.' '.$model->first_name.' '.$model->middle_name. " | ".$model->passport_serial.' '.$model->passport_number;
            },
        ],
        [
            'attribute' => 'Tel raqam',
            'contentOptions' => ['date-label' => 'Tel raqam'],
            'format' => 'raw',
            'value' => function($model) {
                return $model->user->username;
            },
        ],
        [
            'attribute' => 'Ro\'yxatga olingan sana',
            'contentOptions' => ['date-label' => 'Ro\'yxatga olingan sana'],
            'format' => 'raw',
            'value' => function($model) {
                $target = $model->user->target;
                $text = '';
                if ($target) {
                    $text = "<div class='badge-table-div active mt-2'>".$model->user->target->name."</div>";
                }
                return "<div><div>". date("Y-m-d H:i:s" , $model->user->created_at) ."</div>$text</div>";
            },
        ],
        [
            'attribute' => 'Ariza tasdiqlagan vaqti',
            'contentOptions' => ['date-label' => 'Ro\'yxatga olingan sana'],
            'format' => 'raw',
            'value' => function($model) {
                $user = $model->user;
                if ($user->step_confirm_time == null) {
                    return "-------";
                }
                return "<div><div>". date("Y-m-d H:i:s" , $model->user->step_confirm_time) ."</div></div>";
            },
        ],
        [
            'attribute' => 'DOMEN',
            'contentOptions' => ['date-label' => 'DOMEN'],
            'format' => 'raw',
            'value' => function($model) {
                $cons = $model->user->cons_id;
                if ($cons == 1) {
                    return "<a href='https://qabul.tpu.uz' class='badge-table-div active mt-2'> qabul.tpu.uz </a>";
                } elseif ($cons == 2) {
                    return "<a href='https://edu.tpu.uz' class='badge-table-div active mt-2'> edu.tpu.uz </a>";
                } elseif ($cons == 3) {
                    return "<a href='https://cons.tpu.uz' class='badge-table-div active mt-2'> cons.tpu.uz </a>";
                } else {
                    return "<a href='#' class='badge-table-div active mt-2'> ----- </a>";
                }
            },
        ],
        [
            'attribute' => 'Batafsil',
            'contentOptions' => ['date-label' => 'Batafsil'],
            'format' => 'raw',
            'value' => function($model) {
                return "<a href='". Url::to(['view' , 'id' => $model->id]) ."' class='badge-table-div active'><span>Batafsil</span></a>";
            },
        ],
    ]; ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="d-flex justify-content-between align-items-center">
                <p><b>Jami soni: &nbsp; <?= $dataProvider->totalCount ?></b></p>

                <div class="page_export">
                    <?php echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $data,
                        'asDropdown' => false,
                    ]); ?>
                </div>

            </div>
        </div>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $data,
        'pager' => [
            'class' => LinkPager::class,
            'pagination' => $dataProvider->getPagination(),
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'nextPageLabel' => false,
            'prevPageLabel' => false,
            'maxButtonCount' => 10,
        ],
    ]); ?>

</div>
