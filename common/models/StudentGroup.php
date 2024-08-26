<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_group".
 *
 * @property int $id
 * @property int $std_id
 * @property int $user_id
 * @property int|null $drift_id
 * @property int|null $drift_form_id
 * @property int|null $drift_course_id
 * @property int|null $edu_year_id
 * @property int|null $language_id
 * @property int|null $course_id
 * @property int|null $etype_id
 * @property float|null $price
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $is_deleted
 *
 * @property Course $course
 * @property Drift $drift
 * @property DriftCourse $driftCourse
 * @property DriftForm $driftForm
 * @property EduYear $eduYear
 * @property Etype $etype
 * @property Languages $language
 * @property Std $std
 * @property User $user
 */
class StudentGroup extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['drift_course_id', 'price'], 'required'],
            [['std_id', 'user_id', 'drift_id', 'down_time', 'drift_form_id', 'drift_course_id', 'edu_year_id', 'language_id', 'course_id', 'etype_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['price'], 'number'],
            [['contract_second' , 'contract_third'], 'string' , 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['drift_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => DriftCourse::class, 'targetAttribute' => ['drift_course_id' => 'id']],
            [['drift_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => DriftForm::class, 'targetAttribute' => ['drift_form_id' => 'id']],
            [['drift_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drift::class, 'targetAttribute' => ['drift_id' => 'id']],
            [['edu_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYear::class, 'targetAttribute' => ['edu_year_id' => 'id']],
            [['etype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etype::class, 'targetAttribute' => ['etype_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
            [['std_id'], 'exist', 'skipOnError' => true, 'targetClass' => Std::class, 'targetAttribute' => ['std_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'std_id' => Yii::t('app', 'Std ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'drift_id' => Yii::t('app', 'Drift ID'),
            'drift_form_id' => Yii::t('app', 'Drift Form ID'),
            'drift_course_id' => Yii::t('app', 'Drift Course ID'),
            'edu_year_id' => Yii::t('app', 'Edu Year ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'etype_id' => Yii::t('app', 'Etype ID'),
            'price' => Yii::t('app', 'Price'),
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
     * Gets query for [[Drift]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrift()
    {
        return $this->hasOne(Drift::class, ['id' => 'drift_id']);
    }

    /**
     * Gets query for [[DriftCourse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDriftCourse()
    {
        return $this->hasOne(DriftCourse::class, ['id' => 'drift_course_id']);
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

    /**
     * Gets query for [[Etype]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtype()
    {
        return $this->hasOne(Etype::class, ['id' => 'etype_id']);
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

    /**
     * Gets query for [[Std]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStd()
    {
        return $this->hasOne(Std::class, ['id' => 'std_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function createItem($model , $std)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        $model->std_id = $std->id;
        $model->user_id = $std->user_id;

        $course = DriftCourse::findOne([
            'id' => $model->drift_course_id,
            'is_deleted' => 0
        ]);

        if ($course) {
            $driftForm = $course->driftForm;
            $drift = $driftForm->drift;

            $model->etype_id = $drift->etype_id;
            $model->drift_id = $drift->id;
            $model->drift_form_id = $driftForm->id;
            $model->drift_course_id = $course->id;
            $model->edu_year_id = $driftForm->edu_year_id;
            $model->language_id = $driftForm->language_id;
            $model->course_id = $course->course_id;
        } else {
            $errors[] = ['Kurs mavjud emas!!!'];
        }
        $model->save(false);

        if ($model->status == 1) {
            StudentGroup::updateAll(['status' => 0], ['std_id' => $model->std_id]);
            $model->status = 1;
            $model->save(false);
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $micTime = (int) round(microtime(true) * 1000);
            $this->contract_second = '2'.$micTime;
            $this->contract_third = '3'.$micTime;
        }
        return parent::beforeSave($insert);
    }
}
