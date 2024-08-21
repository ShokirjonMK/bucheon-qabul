<?php

namespace frontend\controllers;

use common\components\AmoCrmClient;
use common\components\AmoCrmSettings;
use common\models\Flayer;
use common\models\Languages;
use common\models\Std;
use common\models\Student;
use common\models\StudentGroup;
use common\models\Target;
use common\models\User;
use common\models\Verify;
use frontend\models\ContractSearch;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPassword;
use frontend\models\StepOne;
use frontend\models\StepSecond;
use frontend\models\StepThree;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use kartik\mpdf\Pdf;

/**
 * Site controller
 */
class StdController extends Controller
{
    use ActionTrait;

    public function actionIndex()
    {
        $errors = [];
        $this->layout = '_cabinet-step';
        $model = new ContractSearch();

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            return $this->redirect(['search',
                'pin' => $model->pin,
                'seria' => $model->seria,
                'number' => $model->number
            ]);
        } else {
            $errors[] = $model->simple_errors($model->errors);
            \Yii::$app->session->setFlash('error' , $errors);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionSearch()
    {
        $this->layout = '_cabinet-step';

        $pin = Yii::$app->request->get('pin');
        $seria = Yii::$app->request->get('seria');
        $number = Yii::$app->request->get('number');

        $student = Std::findOne([
            'passport_pin' => $pin,
            'passport_serial' => $seria,
            'passport_number' => $number,
        ]);

        return $this->render('search', [
            'student' => $student
        ]);
    }


    public function actionContract($type , $id)
    {
        $student = $this->findStdGroup($id);
        $action = '';
        if ($type == 2) {
            $action = 'con2-uz';
        } elseif ($type == 3) {
            $action = 'con3-uz';
        }

        $content = $this->renderPartial($action, [
            'student' => $student,
            'type' => $type
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'marginLeft' => 25,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_DOWNLOAD,
            'content' => $content,
            'cssInline' => 'body { font-family: Times, "Times New Roman", serif; }',
            'filename' => date('YmdHis') . ".pdf",
            'options' => [
                'title' => 'Contract',
                'subject' => 'Student Contract',
                'keywords' => 'pdf, contract, student',
            ],
        ]);

        return $pdf->render();
    }

    protected function findStdGroup($id)
    {
        $model = StudentGroup::findOne(['id' => $id, 'is_deleted' => 0]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException();
    }


}
