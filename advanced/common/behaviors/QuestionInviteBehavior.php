<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 10/28
 * Time: 11:39
 */

namespace common\behaviors;

use common\components\Notifier;
use common\entities\NotificationEntity;
use common\models\AssociateModel;
use common\services\NotificationService;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class QuestionInviteBehavior
 * @package common\behaviors
 * @property \common\entities\QuestionInviteEntity owner
 */
class QuestionInviteBehavior extends BaseBehavior
{
    public function events()
    {
        Yii::trace('Begin ' . $this->className(), 'behavior');

        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterQuestionInviteInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterQuestionInviteUpdate',
        ];
    }

    public function afterQuestionInviteInsert()
    {
        Yii::trace('Process ' . __FUNCTION__, 'behavior');
        $this->dealWithNotifier();
    }

    public function afterQuestionInviteUpdate()
    {
        Yii::trace('Process ' . __FUNCTION__, 'behavior');
        $this->dealWithNotifier();
    }

    private function dealWithNotifier()
    {
        Yii::trace('Process ' . __FUNCTION__, 'behavior');
        $result = Notifier::build()->from($this->owner->created_by)
                          ->to($this->owner->invited_user_id)
                          ->where(
                              [
                                  AssociateModel::TYPE_QUESTION,
                                  $this->owner->question_id,
                              ],
                              [
                                  'question_id' => $this->owner->question_id,
                              ]
                          )
                          ->notice(
                              NotificationService::TYPE_USER_BE_INVITE_TO_ANSWER
                          );

        return $result;
    }
}
