<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_operator".
 *
 * @property int $id
 * @property int $student_id
 * @property int $user_id
 * @property int $date
 * @property int $student_operator_type_id
 * @property string|null $text
 * @property int|null $is_deleted
 *
 * @property Student $student
 * @property StudentOperatorType $studentOperatorType
 * @property Student[] $students
 * @property User $user
 */
class StudentOperator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_operator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_operator_type_id' , 'text'], 'required'],
            [['student_id', 'user_id', 'date', 'student_operator_type_id', 'is_deleted'], 'integer'],
            [['text'], 'string'],
            [['student_operator_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentOperatorType::class, 'targetAttribute' => ['student_operator_type_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
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
            'student_id' => Yii::t('app', 'Student ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'date' => Yii::t('app', 'Date'),
            'student_operator_type_id' => Yii::t('app', 'Student Operator Type ID'),
            'text' => Yii::t('app', 'Text'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }

    /**
     * Gets query for [[StudentOperatorType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentOperatorType()
    {
        return $this->hasOne(StudentOperatorType::class, ['id' => 'student_operator_type_id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::class, ['student_operator_id' => 'id']);
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

    public static function createItem($model , $student)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $userId = Yii::$app->user->identity->id;

        $model->student_id = $student->id;
        $model->user_id = $userId;
        $model->date = time();
        $model->save(false);

        $student->student_operator_type_id = $model->student_operator_type_id;
        $student->student_operator_id = $model->id;
        $student->save(false);

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }

}
