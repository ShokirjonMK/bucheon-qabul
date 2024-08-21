<?php

namespace backend\controllers;

use common\models\Student;
use common\models\StudentOperator;
use common\models\StudentOperatorType;
use common\models\StudentOperatorTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentOperatorTypeController implements the CRUD actions for StudentOperatorType model.
 */
class StudentOperatorTypeController extends Controller
{
    use ActionTrait;

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all StudentOperatorType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudentOperatorTypeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentOperatorType model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StudentOperatorType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StudentOperatorType();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StudentOperatorType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StudentOperatorType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->save(false);

        return $this->redirect(['index']);
    }





    public function actionOperator($id)
    {
        $student = $this->findModelStudent($id);

        $model = new StudentOperator();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = StudentOperator::createItem($model, $student);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['student/view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('operator-create', [
            'model' => $model,
        ]);
    }

    public function actionList($id)
    {
        $studentOperator = StudentOperator::find()
            ->where(['student_id' => $id , 'is_deleted' => 0])
            ->orderBy('id desc')
            ->all();
        return $this->renderAjax('list', [
            'models' => $studentOperator,
        ]);
    }






    /**
     * Finds the StudentOperatorType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StudentOperatorType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentOperatorType::findOne(['id' => $id , 'is_deleted' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findModelStudent($id)
    {
        if (($model = Student::findOne(['id' => $id])) !== null) {
            $user = \Yii::$app->user->identity;
            if ($user->cons_id == $model->user->cons_id) {
                return $model;
            }
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
