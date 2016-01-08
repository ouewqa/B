<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 1/5
 * Time: 19:19
 */

namespace common\entities;

use common\models\UserScoreRule;

class UserScoreRuleEntity extends UserScoreRule
{
    const STATUS_ENABLE = 'enable';
    const STATUS_DISABLE = 'disable';

    const LIMIT_TYPE_LIMITLESS = 'limitless';
    const LIMIT_TYPE_YEAR = 'year';
    const LIMIT_TYPE_SEASON = 'season';
    const LIMIT_TYPE_MONTH = 'month';
    const LIMIT_TYPE_WEEK = 'week';
    const LIMIT_TYPE_DAY = 'day';
    const LIMIT_TYPE_HOUR = 'hour';
    const LIMIT_TYPE_MINUTE = 'minute';
    const LIMIT_TYPE_SECOND = 'second';

}