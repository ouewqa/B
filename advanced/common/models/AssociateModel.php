<?php
/**
 * Created by PhpStorm.
 * User: Keen
 * Date: 2016/1/16
 * Time: 17:48
 */

namespace common\models;

use yii\base\Model;

class AssociateModel extends Model
{
    const TYPE_QUESTION = 'question';
    const TYPE_ANSWER = 'answer';
    const TYPE_BLOG = 'blog';
    const TYPE_COMMENT = 'comment';
    const TYPE_ANSWER_COMMENT = 'answer_comment';
    const TYPE_USER = 'user';
    const TYPE_TAG = 'tag';
    const TYPE_TAG_PASSIVE = 'tag_passive';
}
