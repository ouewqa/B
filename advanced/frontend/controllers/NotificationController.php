<?php

namespace frontend\controllers;

use common\components\Error;
use common\controllers\BaseController;
use common\entities\NotificationEntity;
use common\helpers\TimeHelper;
use common\services\NotificationService;
use common\services\UserService;
use yii\data\Pagination;
use yii\filters\AccessControl;
use Yii;
use yii\web\NotFoundHttpException;

class NotificationController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $count = UserService::getUserNotificationCount(Yii::$app->user->id);

        $pages = new Pagination(
            [
                'totalCount' => $count,
                'pageSize'   => 50,
                'params'     => array_merge($_GET),
            ]
        );

        if ($count) {
            $data = NotificationEntity::find()->where(['receiver' => Yii::$app->user->id])
                                      ->limit($pages->limit)
                                      ->offset($pages->offset)
                                      ->orderBy('`date` DESC, id DESC')
                                      ->all();

            //Updater::clearNotifyCount(Yii::$app->user->id);
        } else {
            $data = [];
        }

        $data = NotificationService::makeUpNotification($data);


        return $this->render(
            'index',
            [
                'data'  => $data,
                'pages' => $pages,
            ]
        );
    }

    /**
     * 返回通知条数
     * @return mixed
     */
    public function actionGetNotificationCount()
    {
        $user = UserService::getUserById(Yii::$app->user->id);

        return $user['notification_count'];
    }


    public function actionReadAll()
    {
        $data = NotificationEntity::updateAll(
            [
                'status'  => NotificationEntity::STATUS_READ,
                'read_at' => TimeHelper::getCurrentTime(),
            ],
            [
                'user_id' => Yii::$app->user->id,
                'status'  => NotificationEntity::STATUS_UNREAD,
            ]
        );

        $result = Error::get($data);
        $this->jsonOut($result);

    }

    public function actionReadOne($id)
    {
        $data = NotificationEntity::updateAll(
            [
                'status'  => NotificationEntity::STATUS_READ,
                'read_at' => TimeHelper::getCurrentTime(),
            ],
            [
                'id'      => $id,
                'user_id' => Yii::$app->user->id,
                'status'  => NotificationEntity::STATUS_UNREAD,
            ]
        );

        $result = Error::get($data);

        $this->jsonOut($result);
    }

    protected function findModel($id)
    {
        if (($model = NotificationEntity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
