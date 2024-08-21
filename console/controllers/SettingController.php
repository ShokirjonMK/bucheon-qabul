<?php

namespace console\controllers;

use common\models\AuthAssignment;
use common\models\Direction;
use common\models\DirectionSubject;
use common\models\Drift;
use common\models\DriftCourse;
use common\models\DriftForm;
use common\models\Exam;
use common\models\ExamSubject;
use common\models\Message;
use common\models\Options;
use common\models\Questions;
use common\models\Std;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentGroup;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use common\models\User;
use Yii;
use yii\console\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\httpclient\Client;

class SettingController extends Controller
{
    public function actionSend1()
    {
        $students = Student::find()
            ->andWhere(['in' , 'id' , StudentPerevot::find()
                ->select('student_id')
                ->andWhere(['is_deleted' => 0 , 'file_status' => 2])
            ])->all();

        $text1 = "Hurmatli abituriyent! \n\t\n Sizni “TASHKENT PERFECT UNIVERSITY”ga talabalikka tavsiya etilganingiz bilan tabriklaymiz! \n\t\n  To'lov shartnomasini https://qabul.tpu.uz qabul tizimi orqali yuklab olishingiz mumkin. Shoshiling, bizda o'quv jarayonlari 9-sentyabrdan boshlanadi.  \n\t\n Manzil: Toshkent sh., Olmazor t., Xastimom MFY, Zarqaynar ko'chasi, 10-uy. \n Aloqa markazi: 77 129 29 29 \n So'ngi yangiliklar rasmiy telegram kanalimizda: https://t.me/perfect_university";
        $text2 = "“TASHKENT PERFECT UNIVERSITY”ga talabalikka tavsiya etilgan abituriyentlar diqqatiga! \n\t\n 31-avgustgacha quyida ko'rsatilgan hujjatlaringizni universitet qabul bo'limiga topshirishingizni so'raymiz: \n\t\n - rektor nomiga ariza (OTMda yoziladi); \n - pasport yoki ID karta nusxasi 2 ta (asli koʻrsatilgan holda); \n - diplom yoki attestat (ilovasi bilan birga) asl nusxasi; \n - til bilish darajasini tasdiqlovchi sertifikat (mavjud bo‘lsa) asli; \n - 3x4 foto surat 8 ta; \n - hujjatlar yig‘ma jildi (папка, скоросшиватель).";

        if (count($students)) {
            $i = 0;
            foreach ($students as $student) {
                $phone = $student->username;
                Message::sendedSms($phone , $text1);
                Message::sendedSms($phone , $text2);
                echo $i++."\n";
            }
        }
    }

    public function actionSend2()
    {
        $students = Student::find()
            ->andWhere(['in' , 'id' , StudentDtm::find()
                ->select('student_id')
                ->andWhere(['is_deleted' => 0 , 'file_status' => 2])
            ])->all();

        $text1 = "Hurmatli abituriyent! \n\t\n Sizni “TASHKENT PERFECT UNIVERSITY”ga talabalikka tavsiya etilganingiz bilan tabriklaymiz! \n\t\n  To'lov shartnomasini https://qabul.tpu.uz qabul tizimi orqali yuklab olishingiz mumkin. Shoshiling, bizda o'quv jarayonlari 9-sentyabrdan boshlanadi.  \n\t\n Manzil: Toshkent sh., Olmazor t., Xastimom MFY, Zarqaynar ko'chasi, 10-uy. \n Aloqa markazi: 77 129 29 29 \n So'ngi yangiliklar rasmiy telegram kanalimizda: https://t.me/perfect_university";
        $text2 = "“TASHKENT PERFECT UNIVERSITY”ga talabalikka tavsiya etilgan abituriyentlar diqqatiga! \n\t\n 31-avgustgacha quyida ko'rsatilgan hujjatlaringizni universitet qabul bo'limiga topshirishingizni so'raymiz: \n\t\n - rektor nomiga ariza (OTMda yoziladi); \n - pasport yoki ID karta nusxasi 2 ta (asli koʻrsatilgan holda); \n - diplom yoki attestat (ilovasi bilan birga) asl nusxasi; \n - til bilish darajasini tasdiqlovchi sertifikat (mavjud bo‘lsa) asli; \n - 3x4 foto surat 8 ta; \n - hujjatlar yig‘ma jildi (папка, скоросшиватель).";

        if (count($students)) {
            $i = 0;
            foreach ($students as $student) {
                $phone = $student->username;
                Message::sendedSms($phone , $text1);
                Message::sendedSms($phone , $text2);
                echo $i++."\n";
            }
        }
    }

    public function actionSend3()
    {
        $students = Student::find()
            ->andWhere(['in' , 'id' , Exam::find()
                ->select('student_id')
                ->andWhere(['is_deleted' => 0 , 'status' => 3])
            ])->all();

        $text1 = "Hurmatli abituriyent! \n\t\n Sizni “TASHKENT PERFECT UNIVERSITY”ga talabalikka tavsiya etilganingiz bilan tabriklaymiz! \n\t\n  To'lov shartnomasini https://qabul.tpu.uz qabul tizimi orqali yuklab olishingiz mumkin. Shoshiling, bizda o'quv jarayonlari 9-sentyabrdan boshlanadi.  \n\t\n Manzil: Toshkent sh., Olmazor t., Xastimom MFY, Zarqaynar ko'chasi, 10-uy. \n Aloqa markazi: 77 129 29 29 \n So'ngi yangiliklar rasmiy telegram kanalimizda: https://t.me/perfect_university";
        $text2 = "“TASHKENT PERFECT UNIVERSITY”ga talabalikka tavsiya etilgan abituriyentlar diqqatiga! \n\t\n 31-avgustgacha quyida ko'rsatilgan hujjatlaringizni universitet qabul bo'limiga topshirishingizni so'raymiz: \n\t\n - rektor nomiga ariza (OTMda yoziladi); \n - pasport yoki ID karta nusxasi 2 ta (asli koʻrsatilgan holda); \n - diplom yoki attestat (ilovasi bilan birga) asl nusxasi; \n - til bilish darajasini tasdiqlovchi sertifikat (mavjud bo‘lsa) asli; \n - 3x4 foto surat 8 ta; \n - hujjatlar yig‘ma jildi (папка, скоросшиватель).";

        if (count($students)) {
            $i = 0;
            foreach ($students as $student) {
                $phone = $student->username;
                Message::sendedSms($phone , $text1);
                Message::sendedSms($phone , $text2);
                echo $i++."\n";
            }
        }
    }

    public function actionTest()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $inputFileName = __DIR__ . '/excels/333.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $bt = 0;
        foreach ($data as $key => $row) {
            if ($key != 0) {
                $phone = $row[0];
                $seria = $row[1];
                $number = (int)$row[2];
                $directionId = $row[3];
                $imtixon_turi = $row[4];
                $invois = $row[5];
                $entered = $row[6];
                $con_type = $row[7];
                $exanStudentId = $row[8];
                $ball = $row[9];
                $cr_at = $row[10];
                $bir = $row[11];

                echo $number."\n";
                if ($phone == 0) {
                    break;
                }
                $user = User::findOne(['username' => $phone]);
                if (!$user) {
                    $password = 'ikbol_2001';
                    $user = new User();
                    $user->username = $phone;
                    $user->user_role = 'student';

                    $user->setPassword($password);
                    $user->generateAuthKey();
                    $user->generateEmailVerificationToken();
                    $user->generatePasswordResetToken();
                    $user->status = 10;
                    $user->cons_id = 1;
                    $user->step = 1;
                    $user->save(false);

                    $newAuth = new AuthAssignment();
                    $newAuth->item_name = 'student';
                    $newAuth->user_id = $user->id;
                    $newAuth->created_at = time();
                    $newAuth->save(false);

                    $newStudent = new Student();
                    $newStudent->user_id = $user->id;
                    $newStudent->username = $user->username;
                    $newStudent->password = $password;
                    $newStudent->created_by = 0;
                    $newStudent->updated_by = 0;
                    $newStudent->save(false);

                    if ($seria != null && $number != null && $bir != null) {
                        $client = new Client();
                        $url = 'https://api.online-mahalla.uz/api/v1/public/tax/passport';
                        $params = [
                            'series' => $seria,
                            'number' => $number,
                            'birth_date' => date('Y-m-d' , strtotime($bir)),
                        ];
                        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl($url)
                            ->setData($params)
                            ->send();

                        if ($response->isOk) {
                            $responseData = $response->data;
                            $passport = $responseData['data']['info']['data'];
                            $newStudent->first_name = $passport['name'];
                            $newStudent->last_name = $passport['sur_name'];
                            $newStudent->middle_name = $passport['patronymic_name'];
                            $newStudent->passport_number = $number;
                            $newStudent->passport_serial = $seria;
                            $newStudent->passport_pin = (string)$passport['pinfl'];

                            $newStudent->passport_issued_date = date("Y-m-d" , strtotime($passport['expiration_date']));
                            $newStudent->passport_given_date = date("Y-m-d" , strtotime($passport['given_date']));
                            $newStudent->passport_given_by = $passport['given_place'];
                            $newStudent->birthday = date("Y-m-d" , strtotime($bir));
                            $newStudent->gender = $passport['gender'];

                            $newStudent->edu_year_type_id = 1;
                            $newStudent->edu_type_id = 1;
                            $newStudent->save(false);
                            $user->step = 3;
                            $user->save(false);

                            if ($directionId != null) {
                                $direaction = Direction::findOne(['id' => $directionId]);
                                if ($direaction) {
                                    $newStudent->direction_id = $direaction->id;
                                    $newStudent->edu_year_form_id = $direaction->edu_year_form_id;
                                    $newStudent->edu_form_id = $direaction->edu_form_id;
                                    $newStudent->language_id = $direaction->language_id;
                                    $newStudent->exam_type = $imtixon_turi;

                                    if ($direaction->oferta == 1) {
                                        $oferta = new StudentOferta();
                                        $oferta->user_id = $user->id;
                                        $oferta->student_id = $newStudent->id;
                                        $oferta->direction_id = $newStudent->direction_id;
                                        $oferta->save(false);
                                    }

                                    $exam = new Exam();

                                    if ($entered == 1 && $exanStudentId > 0) {
                                        if ($ball < 10) {
                                            $t = $ball;
                                            $exam->contract_type = 1.5;
                                            $exam->contract_price = $direaction->contract * 1.5;
                                        } elseif ($ball >= 10 && $ball <= 56.7) {
                                            $t = rand(58 , 65);
                                            $exam->contract_type = 1;
                                            $exam->contract_price = $direaction->contract;
                                        } else {
                                            $t = $ball;
                                            $exam->contract_type = 1;
                                            $exam->contract_price = $direaction->contract;
                                        }

                                        $exam->ball = $t;
                                        $exam->status = 3;
                                        $exam->confirm_date = $cr_at;

                                        $random = rand(0 , $ball);
                                        $ball2 = $ball - $random;
                                        $b = [$random , $ball2];
                                    }

                                    $exam->user_id = $user->id;
                                    $exam->student_id = $newStudent->id;
                                    $exam->direction_id = $newStudent->direction_id;
                                    $exam->language_id = $newStudent->language_id;
                                    $exam->edu_year_form_id = $newStudent->edu_year_form_id;
                                    $exam->edu_year_type_id = $newStudent->edu_year_type_id;
                                    $exam->edu_type_id = $newStudent->edu_type_id;
                                    $exam->edu_form_id = $newStudent->edu_form_id;
                                    $exam->correct_type = 1;
                                    $exam->created_by = 0;
                                    $exam->updated_by = 0;
                                    $exam->contract_second = '2'.$invois;
                                    $exam->contract_third = '3'.$invois;

                                    $directionSubjects = DirectionSubject::find()
                                        ->where([
                                            'direction_id' => $exam->direction_id,
                                            'status' => 1,
                                            'is_deleted' => 0
                                        ])->all();
                                    if (count($directionSubjects) > 0) {
                                        $exam->save(false);
                                        $i = 0;
                                        foreach ($directionSubjects as $directionSubject) {
                                            $examSubject = new ExamSubject();
                                            $examSubject->user_id = $user->id;
                                            $examSubject->student_id = $newStudent->id;
                                            $examSubject->exam_id = $exam->id;
                                            $examSubject->direction_id = $exam->direction_id;
                                            $examSubject->direction_subject_id = $directionSubject->id;
                                            $examSubject->subject_id = $directionSubject->subject_id;
                                            $examSubject->language_id = $exam->language_id;
                                            $examSubject->edu_year_form_id = $exam->edu_year_form_id;
                                            $examSubject->edu_year_type_id = $exam->edu_year_type_id;
                                            $examSubject->edu_type_id = $exam->edu_type_id;
                                            $examSubject->edu_form_id = $exam->edu_form_id;
                                            if ($entered == 1 && $exanStudentId > 0) {
                                                $examSubject->ball = $b[$i];
                                            }
                                            $examSubject->save(false);
                                            $i++;
                                        }

                                        $user->step = 5;
                                        $user->save(false);
                                    }
                                }
                            }

                        } else {
                            echo $phone."\n";
                        }
                    }
                }
                $bt++;
                echo $bt."\n";
            }
        }


        if (count($errors) == 0) {
            $transaction->commit();
            echo "tugadi.";
        } else {
            $transaction->rollBack();
            dd($errors);
        }
    }


    public function actionStd()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        $inputFileName = __DIR__ . '/excels/ss1.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $i = 1;
        foreach ($data as $key => $row) {
            if ($key != 0) {

                if ($row[0] == null) {
                    break;
                }

                $familya = $row[0];
                $ism = $row[1];
                $otasi = $row[2];
                $jinsi = $row[6];
                $tsana = $row[7];
                $seria = $row[8];
                $number = $row[9];
                $pin = $row[10];
                $pb = $row[11];
                $kusr = $row[12];
                $til = $row[13];
                $yil = $row[14];
                $code = $row[15];
                $form = $row[7];


                $user = new User();
                $user->username = $pin;
                $user->user_role = 'std';

                $password = $seria.$number;

                $user->setPassword($password);
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
                $user->generatePasswordResetToken();
                $user->status = 10;

                if ($user->save(false)) {

                    $newAuth = new AuthAssignment();
                    $newAuth->item_name = 'std';
                    $newAuth->user_id = $user->id;
                    $newAuth->created_at = time();
                    $newAuth->save(false);

                    $std = new Std();
                    $std->user_id = $user->id;
                    $std->first_name = $ism;
                    $std->last_name = $familya;
                    $std->middle_name = $otasi;
                    $std->student_phone = "+998 (94) 505-52-50";
                    $std->adress = "...";
                    $std->gender = $jinsi;
                    $std->birthday = $tsana;
                    $std->passport_number = $number;
                    $std->passport_serial = $seria;
                    $std->passport_pin = $pin;
                    $std->passport_issued_date = $pb;
                    $std->passport_given_date = "2025-01-01";
                    $std->passport_given_by = "UZB";
                    $std->status = 10;
                    $std->save(false);

                    $drift = Drift::findOne([
                       'code' => $code
                    ]);
                    if (!$drift) {
                        $errors[] = [$number. 'Drift'];
                        $transaction->rollBack();
                        dd($errors);
                    }

                    $t = 4;
                    if ($form > 1) {
                        $t = 5;
                    }
                    $qolgan = ($t - $kusr) + 1;

                    $dForm = DriftForm::findOne([
                        'drift_id' => $drift->id,
                        'edu_dureation' => $qolgan,
                        'language_id' => $til,
                        'edu_form_id' => $form,
                        'edu_year_id' => $yil,
                        'status' => 1,
                        'is_deleted' => 0
                    ]);
                    if (!$dForm) {
                        $errors[] = [$number. 'Dform'];
                        $transaction->rollBack();
                        dd($errors);
                    }

                    $course = DriftCourse::findOne([
                        'drift_form_id' => $dForm->id,
                        'status' => 1,
                        'is_deleted' => 0
                    ]);
                    if (!$course) {
                        $errors[] = [$number. 'Dcourse'];
                        $transaction->rollBack();
                        dd($errors);
                    }

                    $sgroup = new StudentGroup();
                    $sgroup->std_id = $std->id;
                    $sgroup->user_id = $std->user_id;
                    $sgroup->drift_id = $drift->id;
                    $sgroup->drift_form_id = $dForm->id;
                    $sgroup->drift_course_id = $course->id;
                    $sgroup->edu_year_id = $course->edu_year_id;
                    $sgroup->language_id = $dForm->language_id;
                    $sgroup->course_id = $course->course_id;
                    $sgroup->etype_id = 1;
                    $sgroup->price = $course->price;
                    $sgroup->save(false);

                } else {
                    $errors[] = [$number. 'User not saved.'];
                    $transaction->rollBack();
                    dd($errors);
                }
                echo $i++."\n";
            }
        }


        if (count($errors) == 0) {
            $transaction->commit();
            echo "tugadi. \n";
        } else {
            $transaction->rollBack();
            dd($errors);
        }
    }

}
