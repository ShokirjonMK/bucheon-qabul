<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "drift_course".
 *
 * @property int $id
 * @property int $drift_form_id
 * @property int $course_id
 * @property float $price
 * @property int $edu_year_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property Course $course
 * @property DriftForm $driftForm
 * @property EduYear $eduYear
 */
class DriftCourse extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drift_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['drift_form_id', 'course_id', 'price', 'edu_year_id'], 'required'],
            [['drift_form_id', 'course_id', 'edu_year_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['price'], 'number'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['drift_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => DriftForm::class, 'targetAttribute' => ['drift_form_id' => 'id']],
            [['edu_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYear::class, 'targetAttribute' => ['edu_year_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'drift_form_id' => Yii::t('app', 'Drift Form ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'price' => Yii::t('app', 'Price'),
            'edu_year_id' => Yii::t('app', 'Edu Year ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
    }

    /**
     * Gets query for [[DriftForm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDriftForm()
    {
        return $this->hasOne(DriftForm::class, ['id' => 'drift_form_id']);
    }

    /**
     * Gets query for [[EduYear]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduYear()
    {
        return $this->hasOne(EduYear::class, ['id' => 'edu_year_id']);
    }

    public static function createItem($model , $post)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        if ($model->status == 1) {
            DriftCourse::updateAll(['status' => 0] , ['drift_form_id' => $model->drift_form_id, 'is_deleted' => 0]);
            $model->status = 1;
        }

        $model->save(false);

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }

}
