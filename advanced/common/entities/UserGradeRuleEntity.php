<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 1/5
 * Time: 19:19
 */

namespace common\entities;

use common\behaviors\UserGradeRuleBehavior;
use common\models\UserGradeRule;

class UserGradeRuleEntity extends UserGradeRule
{
    const STATUS_ENABLE = 'enable';
    const STATUS_DISABLE = 'disable';

    public function behaviors()
    {
        return [
            'user_event' => [
                'class' => UserGradeRuleBehavior::className(),
            ],
        ];
    }
}
