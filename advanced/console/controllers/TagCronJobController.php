<?php
/**
 * 统计关键字的相关度，每周执行一次
 * Created by PhpStorm.
 * User: yuyj
 * Date: 11/11
 * Time: 17:50
 */

namespace console\controllers;

use common\entities\QuestionEntity;
use common\entities\TagRelationEntity;
use common\helpers\TimeHelper;
use common\services\TagService;
use Yii;
use yii\console\Controller;

class TagCronJobController extends Controller
{
    const LOOP_NUMBER = 500;

    public function actionIndex()
    {
        $this->actionRebuildTagRelation();
    }


    /**
     * 只处理relate类型的关系
     */
    public function actionRebuildTagRelation()
    {
        #reset
        TagRelationEntity::updateAll(['count_relation' => 0], ['type' => TagRelationEntity::TYPE_RELATE]);

        #loop rebuild
        $page = 1;
        $page_size = self::LOOP_NUMBER;

        while ($data = $this->rebuildTagRelation($page, $page_size)) {
            $page++;
            sleep(1);
        }
    }

    private function rebuildTagRelation($page = 1, $page_size = 500)
    {
        $limit = $page_size;
        $offset = max($page - 1, 0) * $page_size;

        $questions = QuestionEntity::find()->select(['tags'])->where(
            [
                'status' => [
                    QuestionEntity::STATUS_ORIGINAL,
                    QuestionEntity::STATUS_REVIEW,
                    QuestionEntity::STATUS_EDITED,
                    QuestionEntity::STATUS_RECOMMEND,
                    QuestionEntity::STATUS_LOCK,

                ],
            ]
        )->limit($limit)->offset($offset)->asArray()->column();

        if ($questions) {
            $tag_data = $tag_relations = [];
            foreach ($questions as $tag) {
                $tags = explode(',', $tag);
                #此处排序很重要，只负责A与B的关系，不管B与A的关系
                sort($tags, SORT_STRING);
                $tag_relations[] = $tags;
                $tag_data = array_merge($tag_data, $tags);
            }


            $all_tag_name_id = TagService::getTagIdByName($tag_data);

            $all_relations = [];

            foreach ($tag_relations as $tag) {
                if (count($tag) <= 1) {
                    continue;
                } else {
                    do {
                        $current_tag = array_shift($tag);
                        foreach ($tag as $tag_name) {
                            $all_relations[$current_tag][] = $tag_name;
                        }
                    } while (count($tag) > 1);
                }
            }

            $data = [];
            foreach ($all_relations as $tag_name_1 => $item_relation) {
                if (empty($all_tag_name_id[$tag_name_1])) {
                    echo sprintf('[F] Tag Name:[%s] is not exist.', $tag_name_1, PHP_EOL);
                    continue;
                }

                $item_relation = array_unique($item_relation);
                $tag_id_1 = $all_tag_name_id[$tag_name_1];
                foreach ($item_relation as $tag_name_2) {
                    $tag_id_2 = $all_tag_name_id[$tag_name_2];
                    $data[] = [
                        $tag_id_1,
                        $tag_id_2,
                        TagRelationEntity::TYPE_RELATE,
                        1,
                        TagRelationEntity::STATUS_ENABLE,
                    ];
                }
            }

            if ($data) {
                #batch add
                $insert_sql = Yii::$app->getDb()->createCommand()->batchInsert(
                    TagRelationEntity::tableName(),
                    ['tag_id_1', 'tag_id_2', 'type', 'count_relation', 'status'],
                    $data
                )->getRawSql();

                //exit($insert_sql);

                $command = Yii::$app->getDb()->createCommand(
                    sprintf(
                        '%s ON DUPLICATE KEY UPDATE `count_relation`=`count_relation`+1;',
                        $insert_sql,
                        TimeHelper::getCurrentTime()
                    )
                );

                $sql = $command->getRawSql();

                $result = $command->execute();
                if ($result) {
                    echo sprintf('[S] %s%s', $sql, PHP_EOL);
                } else {
                    echo sprintf('[F] %s%s', $sql, PHP_EOL);
                }
            }

            return true;
        } else {
            return false;
        }


    }
}
