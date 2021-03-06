<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 2015/9/14
 * Time: 9:10
 */

namespace common\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Response;

class BaseController extends PerformanceRecordController
{
    /*public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $permissionName = $controller . '/' . $action;
        if (!Yii::$app->user->can($permissionName) && Yii::$app->getErrorHandler()->exception === null) {
            throw new UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
        }

        return true;
    }*/
    
    /**
     * JSON输出
     * @param array $response ['code'=> '', 'msg' => '', 'data' => '']
     * @return bool
     * @throws \yii\base\ExitException
     */
    public function jsonOut(array $response)
    {
        Yii::$app->getResponse()->clear();
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->setStatusCode(200);
        Yii::$app->response->data = $response;
        
        Yii::$app->end();
        return true;
    }
    
    public function htmlOut($html)
    {
        echo Json::encode($html);
        Yii::$app->end();
    }
    
    /**
     * 参数错误
     * @throws \yii\base\ExitException
     */
    protected function errorParam()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->error->error_param;
        Yii::$app->response->data = $data;
        Yii::$app->end();
    }

    /**
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    /*protected function getQuestionService()
    {
        return Yii::createObject(QuestionService::className());
    }*/
    
    /*public function __call($action, $params)
    {
        var_dump($action, $params);
        exit('~~~~~');
        //parent::__call($action, $params);
    }*/
}
