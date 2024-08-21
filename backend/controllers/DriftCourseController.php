<?php

namespace backend\controllers;

use common\models\DriftCourse;
use common\models\DriftCourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DriftCourseController implements the CRUD actions for DriftCourse model.
 */
class DriftCourseController extends Controller
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
     * Updates an existing DriftCourse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $model;
        $driftForm = $oldModel->driftForm;
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $model->drift_form_id = $driftForm->id;
                $model->edu_year_id = $oldModel->edu_year_id;
                $result = DriftCourse::createItem($model, $post);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['drift-form/view', 'id' => $driftForm->id]);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    public function actionPrice()
    {
        $id = \Yii::$app->request->post('id');
        $course = DriftCourse::findOne($id);
        if ($course) {
            return $course->price;
        }
        return 0;
    }

    /**
     * Deletes an existing DriftCourse model.
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

        return $this->redirect(['drift-form/view' , 'id' => $model->drift_form_id]);
    }

    /**
     * Finds the DriftCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DriftCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DriftCourse::findOne(['id' => $id, 'is_deleted' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
