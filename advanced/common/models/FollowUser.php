<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "follow_user".
 *
 * @property integer $user_id
 * @property integer $follow_user_id
 * @property string $created_at
 */
class FollowUser extends \common\models\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'follow_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'follow_user_id'], 'required'],
            [['user_id', 'follow_user_id', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'follow_user_id' => 'Follow User ID',
            'created_at' => '创建时间',
        ];
    }
}
