<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "drift_form".
 *
 * @property int $id
 * @property int $drift_id
 * @property float $edu_dureation
 * @property int $language_id
 * @property int $edu_form_id
 * @property int $edu_year_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property Drift $drift
 * @property DriftCourse[] $driftCourses
 * @property EduForm $eduForm
 * @property EduYear $eduYear
 * @property Languages $language
 */
class DriftForm extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drift_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_dureation', 'language_id', 'edu_form_id', 'edu_year_id'], 'required'],
            [['drift_id', 'language_id', 'edu_form_id', 'edu_year_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['edu_dureation'], 'number'],
            [['drift_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drift::class, 'targetAttribute' => ['drift_id' => 'id']],
            [['edu_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduForm::class, 'targetAttribute' => ['edu_form_id' => 'id']],
            [['edu_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYear::class, 'targetAttribute' => ['edu_year_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
       ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'drift_id' => Yii::t('app', 'Drift ID'),
            'edu_dureation' => Yii::t('app', 'Edu Dureation'),
            'language_id' => Yii::t('app', 'Language ID'),
            'edu_form_id' => Yii::t('app', 'Edu Form ID'),
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
     * Gets query for [[Drift]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrift()
    {
        return $this->hasOne(Drift::class, ['id' => 'drift_id']);
    }

    /**
     * Gets query for [[DriftCourses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDriftCourses()
    {
        return $this->hasMany(DriftCourse::class, ['drift_form_id' => 'id']);
    }

    /**
     * Gets query for [[EduForm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduForm()
    {
        return $this->hasOne(EduForm::class, ['id' => 'edu_form_id']);
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

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
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

        $limit = ceil($model->edu_dureation);
        $model->save(false);

        $query = DriftForm::find()
            ->where([
                'drift_id' => $model->drift_id,
                'edu_year_id' => $model->edu_year_id,
                'edu_form_id' => $model->edu_form_id,
                'language_id' => $model->language_id,
                'edu_dureation' => $model->edu_dureation,
                'is_deleted' => 0
            ])->andWhere(['<>' , 'id' , $model->id])->one();

        if ($query) {
            $errors[] = ['Bu ma\'lumot avval qo\'shilgan.!'];
            return ['is_ok' => false , 'errors' => $errors];
        }


        DriftCourse::updateAll(['is_deleted' => 1], ['drift_form_id' => $model->id , 'is_deleted' => 0]);
        $eduYears = EduYear::find()
            ->where(['is_deleted' => 0])
            ->andWhere(['>=' , 'id' , $model->edu_year_id])
            ->orderBy('id asc')
            ->limit($limit)
            ->all();
        if (count($eduYears) == $limit) {
            $i = 1;
            foreach ($eduYears as $eduYear) {
                $query = DriftCourse::findOne([
                    'edu_year_id' => $eduYear->id,
                    'drift_form_id' => $model->id,
                    'course_id' => $i,
                ]);
                if ($query) {
                    $query->is_deleted = 0;
                    $query->status = 0;
                    $query->save(false);
                } else {
                    $course = new DriftCourse();
                    $course->drift_form_id = $model->id;
                    $course->course_id = $i;
                    $course->price = 0;
                    $course->edu_year_id  = $eduYear->id;
                    $course->save(false);
                }
                $i++;
            }
        } else {
            $errors[] = ['Yil yetarli emas!!!'];
        }
        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }

}
