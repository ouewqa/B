<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 1/6
 * Time: 9:36
 */

namespace common\entities;

use common\models\UserEvent;

class UserEventEntity extends UserEvent
{
    const STATUS_ENABLE = 'enable';
    const STATUS_DISABLE = 'disable';

    const RECORD_YES = 'yes';
    const RECORD_NO = 'no';
}