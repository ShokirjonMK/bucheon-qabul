<?php

namespace frontend\models;

use common\models\AuthAssignment;
use common\models\EduYear;
use common\models\EduYearType;
use common\models\Exam;
use common\models\ExamStudentQuestions;
use common\models\ExamSubject;
use common\models\Message;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\httpclient\Client;

/**
 * Signup form
 */
class StepSecond extends Model
{
    public $check;

    public function rules()
    {
        return [
            [['check'], 'safe'],
        ];
    }

    function simple_errors($errors) {
        $result = [];
        foreach ($errors as $lev1) {
            foreach ($lev1 as $key => $error) {
                $result[] = $error;
            }
        }
        return array_unique($result);
    }

    public function ikStep($user, $student)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$this->validate()) {
            $errors[] = $this->simple_errors($this->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
        $activeYear = EduYear::findOne([
            'status' => 1,
            'is_deleted' => 0
        ]);
        $eduYearType = EduYearType::findOne([
            'edu_year_id' => $activeYear->id,
            'id' => $this->check,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if (!$eduYearType) {
            $errors[] = ['Qabul turi noto\'g\'ri tanlandi.'];
        } else {
            if ($student->edu_year_type_id != $eduYearType->id) {

                Exam::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                ExamSubject::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                ExamStudentQuestions::updateAll(['status' => 0 , 'is_deleted' => 2] , ['user_id' => $student->user_id]);
                StudentOferta::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentPerevot::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentDtm::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);

                $student->edu_year_type_id = $eduYearType->id;
                $student->edu_type_id = $eduYearType->eduType->id;
                $student->direction_id = null;
                $student->language_id = null;
                $student->edu_year_form_id = null;
                $student->edu_form_id = null;
                $student->direction_course_id = null;
                $student->course_id = null;
                $student->exam_type = null;
                $student->edu_name = null;
                $student->edu_direction = null;
                $student->save(false);
            }
            $user->step = 3;
            $user->save(false);
        }

        if (count($errors) == 0) {
            if ($student->lead_id != null) {
                $result = StepSecond::updateCrm($student);
                if ($result['is_ok']) {
                    $amo = $result['data'];
                    $student->pipeline_id = $amo->pipelineId;
                    $student->status_id = $amo->statusId;
                    $student->save(false);
                } else {
                    return ['is_ok' => false, 'errors' => $result['errors']];
                }
            }
            $transaction->commit();
            return ['is_ok' => true];
        }
        $transaction->rollBack();
        return ['is_ok' => false, 'errors' => $errors];
    }

    public static function updateCrm($student)
    {
        try {
            $amoCrmClient = Yii::$app->ikAmoCrm;
            $leadId = $student->lead_id;
            $tags = [];
            $message = '';

            $updatedFields = [
                'pipelineId' => $student->pipeline_id,
                'statusId' => User::STEP_STATUS_4
            ];

            $customFields = [
                // '900679' => $student->last_name, // Familya
                // '900681' => $student->first_name, // Ism
                // '900683' => $student->middle_name,  // Otasi
                // '900749' => $student->passport_serial,  // pas seriya
                // '900751' => $student->passport_number, // pas raqam
                // '900757' => $student->birthday, // Tug'ilgan sana
                '900685' => $student->eduType->name_uz, // qabul turi
                '900687' => null, // Ta'lim shakli
                '900689' => null, // Ta'lim tili
                '900691' => null, // Ta'lim yo'nalishi
                '900739' => null, // Imtixon shakli
            ];

            $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
            return ['is_ok' => true, 'data' => $updatedLead];
        } catch (\Exception $e) {
            $errors[] = ['Ma\'lumot uzatishda xatolik STEP 2: ' . $e->getMessage()];
            return ['is_ok' => false, 'errors' => $errors];
        }
    }

}
