<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "drift".
 *
 * @property int $id
 * @property string $name_uz
 * @property string $name_ru
 * @property string $name_en
 * @property string $code
 * @property int $etype_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property DriftForm[] $driftForms
 * @property Etype $etype
 */
class Drift extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru', 'name_en', 'code', 'etype_id'], 'required'],
            [['etype_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['name_uz', 'name_ru', 'name_en'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
            [['etype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etype::class, 'targetAttribute' => ['etype_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_uz' => Yii::t('app', 'Yo\'nalish nomi'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
            'code' => Yii::t('app', 'Yo\'nalish kodi'),
            'etype_id' => Yii::t('app', 'Ta\'lim turi'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[DriftForms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDriftForms()
    {
        return $this->hasMany(DriftForm::class, ['drift_id' => 'id']);
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
}
