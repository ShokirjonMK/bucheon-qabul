<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\StudentOperatorType $model */

$this->title = $model->name;
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Types'),
    'url' => ['index'],
];
\yii\web\YiiAsset::register($this);
?>
<div class="student-operator-type-view">

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

    <div class="grid-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->status == 1) {
                            return "<span class='editable editable-click'>Faol</span>";
                        } else {
                            return "<span class='editable editable-click editable-empty'>No faol</span>";
                        }
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s' , $model->created_at);
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s' , $model->updated_at);
                    }
                ],
                [
                    'attribute' => 'created_by',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->created_by == null || $model->created_by == 0) {
                            return 0;
                        }
                        $profile = $model->createdBy->employee;
                        return $profile->first_name . " " .$profile->last_name. " ". $profile->middle_name;
                    }
                ],
                [
                    'attribute' => 'updated_by',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->updated_by == null || $model->updated_by == 0) {
                            return 0;
                        }
                        $profile = $model->updatedBy->employee;
                        return $profile->first_name . " " .$profile->last_name. " ". $profile->middle_name;
                    }
                ],
            ],
        ]) ?>
    </div>

</div>
