<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $student_phone
 * @property string|null $adress
 * @property int|null $gender
 * @property string|null $birthday
 * @property string|null $passport_number
 * @property string|null $passport_serial
 * @property string|null $passport_pin
 * @property string|null $passport_issued_date
 * @property string|null $passport_given_date
 * @property string|null $passport_given_by
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $is_deleted
 *
 * @property StudentGroup[] $studentGroups
 * @property User $user
 */
class Std extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'std';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['passport_pin', 'trim'],
            ['passport_pin', 'required'],
            ['passport_pin', 'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'username',
                'message' => 'Bu JSHIR avval ro\'yhatga olingan.',
                'filter' => function ($query) {
                    if (!$this->isNewRecord) {
                        $query->andWhere(['<>', 'id', $this->user_id]); // Hozirgi ID ni tekshirishdan chiqarish
                    }
                },
                'when' => function ($model) {
                    $user = User::find()
                        ->where(['username' => $model->passport_pin])
                        ->andWhere(['<>', 'id', $model->user_id]) // Hozirgi yozuvni tekshirishdan chiqarish
                        ->one();
                    if ($user) {
                        if ($user->status == 10) {
                            $this->addError('passport_pin', 'Bu JSHIR avval ro\'yhatga olingan.');
                        } elseif ($user->status == 0) {
                            $this->addError('passport_pin', 'Bu JSHIR avval ro\'yhatga olingan va blocklangan.');
                        }
                        return false;
                    }
                    return true;
                }
            ],
            [['gender', 'status',
                'first_name',
                'last_name',
//                'middle_name',
                'passport_number',
                'passport_serial',
                'passport_pin',
                'passport_issued_date',
                'passport_given_date',
                'passport_given_by',
//                'student_phone',
                'birthday',
                'adress',
            ], 'required'],
            [['user_id', 'gender', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['adress'], 'string'],
            [['birthday'], 'safe'],
            [['first_name', 'last_name', 'middle_name', 'passport_number', 'passport_serial', 'passport_pin', 'passport_issued_date', 'passport_given_date', 'passport_given_by'], 'string', 'max' => 255],
            [['student_phone'], 'string', 'max' => 100],
            [
                'student_phone',
                'match',
                'pattern' => '/^[+][0-9]{3} [(][0-9]{2}[)] [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
                'message' => 'Telefon raqamni to\'liq kiriting',
            ],
            ['passport_pin', 'string', 'length' => 14, 'message' => 'JSHIR 14 ta raqamdan iborat bo\'lishi kerak.'],
            ['passport_pin', 'match', 'pattern' => '/^\d{14}$/', 'message' => 'JSHIR faqat raqamlardan iborat bo\'lishi kerak.'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'student_phone' => Yii::t('app', 'Student Phone'),
            'adress' => Yii::t('app', 'Adress'),
            'gender' => Yii::t('app', 'Gender'),
            'birthday' => Yii::t('app', 'Birthday'),
            'passport_number' => Yii::t('app', 'Passport Number'),
            'passport_serial' => Yii::t('app', 'Passport Serial'),
            'passport_pin' => Yii::t('app', 'Passport Pin'),
            'passport_issued_date' => Yii::t('app', 'Passport Issued Date'),
            'passport_given_date' => Yii::t('app', 'Passport Given Date'),
            'passport_given_by' => Yii::t('app', 'Passport Given By'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[StudentGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentGroups()
    {
        return $this->hasMany(StudentGroup::class, ['std_id' => 'id']);
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


    public static function createItem($model , $post)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        $user = new User();
        $user->username = $model->passport_pin;
        $user->user_role = 'std';

        $password = $model->passport_serial.$model->passport_number;

        $user->setPassword($password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generatePasswordResetToken();
        $user->status = $model->status;

        if ($user->save(false)) {
            $newAuth = new AuthAssignment();
            $newAuth->item_name = 'std';
            $newAuth->user_id = $user->id;
            $newAuth->created_at = time();
            $newAuth->save(false);
        } else {
            $errors[] = ['User not saved.'];
        }
        $model->user_id = $user->id;
        $model->save(false);

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }


    public static function updateItem($model , $post)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        $user = $model->user;
        $user->username = $model->passport_pin;

        $password = $model->passport_serial.$model->passport_number;

        $user->setPassword($password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generatePasswordResetToken();
        $user->status = $model->status;

        if (!$user->save(false)) {
            $errors[] = ['User not saved.'];
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
