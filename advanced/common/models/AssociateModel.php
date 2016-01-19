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
    const TYPE_ARTICLE = 'article';
    const TYPE_ANSWER_COMMENT = 'answer_comment';
    const YPE_USER = 'user';
    const TYPE_TAG = 'tag';
}