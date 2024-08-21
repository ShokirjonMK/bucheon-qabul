<?php

namespace common\models;

use common\models\Student;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * StudentSearch represents the model behind the search form of `common\models\Student`.
 */
class StudentSearch extends Student
{
    public $full_name;

    public $group_id;

    public $subject_id;

    public $step;
    public $start_date;
    public $end_date;
    public $target_id;


    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['id','user_id', 'gender','language_id', 'edu_form_id','edu_year_form_id', 'direction_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted' , 'step' , 'target_id'], 'integer'],
            [['username'], 'string' , 'max' => 255],
            [['passport_serial'], 'string', 'min' => 2, 'max' => 2, 'message' => 'Pasport seria 2 xonali bo\'lishi kerak'],
            [['full_name','first_name', 'last_name', 'middle_name', 'recorded_date','passport_number' ,'passport_serial' ,'start_date', 'end_date', 'adress',  'password', 'exam_type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    public function search($params, $edu_type)
    {
        $user = Yii::$app->user->identity;
        $query = Student::find()
            ->where(['edu_year_type_id' => $edu_type->id])
            ->andWhere(['in' , 'user_id' , User::find()
                ->select('id')
                ->where(['step' => 5])
                ->andWhere(['user_role' => 'student'])
                ->andWhere(['cons_id' => $user->cons_id])
            ]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->status != null) {
            if ($edu_type->edu_type_id == 1) {
                if ($this->status <= 3) {
                    $query->andWhere(
                        ['in' , 'id' ,
                            Exam::find()->select('student_id')
                                ->where([
                                    'edu_year_type_id' => $edu_type->id,
                                    'status' => $this->status,
                                ])
                        ]);
                } elseif ($this->status == 4) {
                    $query->andWhere(
                        ['in' , 'id' ,
                            Exam::find()->select('student_id')
                                ->where([
                                    'edu_year_type_id' => $edu_type->id,
                                    'status' => 3,
                                ])->andWhere(['>' , 'down_time' , 0])
                        ]);
                } elseif ($this->status == 5) {
                    $query->andWhere(
                        ['in' , 'id' ,
                            Exam::find()->select('student_id')
                                ->where([
                                    'edu_year_type_id' => $edu_type->id,
                                    'status' => 3,
                                    'down_time' => null
                                ])
                        ]);
                }
            } elseif ($edu_type->edu_type_id == 2) {
                $query->andWhere(
                    ['in' , 'id' ,
                        StudentPerevot::find()->select('student_id')
                            ->where([
                                'file_status' => $this->status,
                                'status' => 1,
                                'is_deleted' => 0,
                            ])
                    ]);
            } elseif ($edu_type->edu_type_id == 3) {
                $query->andWhere(
                    ['in' , 'id' ,
                        StudentDtm::find()->select('student_id')
                            ->where([
                                'file_status' => $this->status,
                                'status' => 1,
                                'is_deleted' => 0,
                            ])
                    ]);
            }
        }

        if ($this->start_date != null) {
            $query->andWhere(
                ['in' , 'user_id',
                    User::find()->select('id')
                        ->where(['>=' , 'created_at' , strtotime($this->start_date)])
                ]);
        }
        if ($this->end_date != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->where(['<=' , 'created_at' , strtotime($this->end_date)])
                ]);
        }

        if ($this->target_id != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->andWhere(['target_id' => $this->target_id])
                ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'language_id' => $this->language_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'direction_id' => $this->direction_id,
            'created_at' => $this->created_at,
            'exam_type' => $this->exam_type,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        if ($this->username != '+998 (__) ___-__-__') {
            $query->andFilterWhere(['like', 'username', $this->username]);
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'first_name', $this->full_name])
            ->andFilterWhere(['like', 'passport_serial', $this->passport_serial])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->orFilterWhere(['like', 'last_name', $this->full_name])
            ->orFilterWhere(['like', 'middle_name', $this->full_name])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'password', $this->password]);
        return $dataProvider;
    }

    public function step($params)
    {
        $user = Yii::$app->user->identity;
        $query = Student::find()
            ->andWhere(['in' , 'user_id' , User::find()
                ->select('id')
                ->where(['<' , 'step' , 5])
                ->andWhere(['user_role' => 'student'])
                ->andWhere(['cons_id' => $user->cons_id])
            ]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->start_date != null) {
            $query->andWhere(
                ['in' , 'user_id',
                    User::find()->select('id')
                        ->where(['>=' , 'created_at' , strtotime($this->start_date)])
                ]);
        }
        if ($this->end_date != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->where(['<=' , 'created_at' , strtotime($this->end_date)])
                ]);
        }
        if ($this->status != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->where([
                            'status' => $this->status,
                        ])
                ]);
        }

        if ($this->step != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->where([
                            'step' => $this->step,
                        ])
                ]);
        }

        if ($this->target_id != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->andWhere(['target_id' => $this->target_id])
                ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'language_id' => $this->language_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'direction_id' => $this->direction_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        if ($this->username != '+998 (__) ___-__-__') {
            $query->andFilterWhere(['like', 'username', $this->username]);
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'passport_serial', $this->passport_serial])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'first_name', $this->full_name])
            ->orFilterWhere(['like', 'last_name', $this->full_name])
            ->orFilterWhere(['like', 'middle_name', $this->full_name])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'password', $this->password]);
        return $dataProvider;
    }

    public function all($params)
    {
        $query = Student::find()
            ->andWhere(['in' , 'user_id' , User::find()
                ->select('id')
                ->andWhere(['user_role' => 'student'])
//                ->andWhere(['>' , 'created_at' , 1723306434])
//                ->orderBy([
//                    'created_at' => SORT_DESC,
//                    'step_confirm_time' => SORT_DESC,
//                ])
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'language_id' => $this->language_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'direction_id' => $this->direction_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        if ($this->username != '+998 (__) ___-__-__') {
            $query->andFilterWhere(['like', 'username', $this->username]);
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'passport_serial', $this->passport_serial])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'first_name', $this->full_name])
            ->orFilterWhere(['like', 'last_name', $this->full_name])
            ->orFilterWhere(['like', 'middle_name', $this->full_name])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'password', $this->password]);
        return $dataProvider;
    }

}
