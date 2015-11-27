<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 10/22
 * Time: 9:45
 */

namespace common\components;

use common\entities\FavoriteCategoryEntity;
use common\entities\QuestionEntity;
use common\entities\UserProfileEntity;
use common\services\QuestionService;
use common\services\UserService;
use Yii;

class Updater extends BaseUpdater
{
    public static function clearNotifyCount($user_id)
    {
        $result = self::build()->table(UserProfileEntity::tableName())->set(
            [
                'count_notification' => 0,
            ]
        )->execute();

        if ($result && UserService::ensureUserHasCached($user_id)) {
            Yii::$app->redis->hSet([REDIS_KEY_USER, $user_id], 'count_notification', 0);
        }

        return $result;
    }

    public static function updateQuestionContent($id, $content)
    {
        $result = self::build()->sync(true)->table(QuestionEntity::tableName())->set(['content' => $content])->where(
            ['id' => $id]
        )->execute();

        if ($result && QuestionService::ensureQuestionHasCache($id)) {
            QuestionService::updateQuestionCache($id, ['content' => $content]);
        }

        return $result;
    }

    public static function updateQuestionActiveAt($id, $active_at)
    {
        $result = self::build()->sync(true)->table(QuestionEntity::tableName())->set(
            ['active_at' => $active_at]
        )->where(
            ['id' => $id]
        )->execute();

        if ($result && QuestionService::ensureQuestionHasCache($id)) {
            QuestionService::updateQuestionCache($id, ['active_at' => $active_at]);
        }

        return $result;
    }

    public static function updateFavoriteCategoryActiveAt($id, $active_at)
    {
        $result = self::build()->sync(true)->table(FavoriteCategoryEntity::tableName())->set(
            ['active_at' => $active_at]
        )->where(
            ['id' => $id]
        )->execute();

        //no redis cache
        return $result;
    }
}
