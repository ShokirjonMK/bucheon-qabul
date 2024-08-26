<?php
namespace frontend\controllers;

use backend\components\HttpBearerAuth;
use backend\components\PermissonCheck;
//use base\ResponseStatus;
use common\models\Actions;
use common\models\Permission;
use common\models\RoleRestriction;
use common\models\User;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

trait ActionTrait
{
    public function beforeAction($action)
    {
        $domen = $_SERVER['HTTP_HOST'];
        if ($domen != "shartnoma.tpu.uz") {
            return $this->redirect('https://shartnoma.tpu.uz/std/index');
        }
        return parent::beforeAction($action);
    }

}
