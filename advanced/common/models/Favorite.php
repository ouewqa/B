<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "favorite".
 *
 * @property string $favorite_category_id
 * @property string $associate_type
 * @property integer $associate_id
 * @property string $created_at
 * @property string $created_by
 * @property string $note
 */
class Favorite extends \common\models\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favorite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['favorite_category_id', 'associate_id', 'created_at', 'created_by'], 'integer'],
            [['associate_type', 'associate_id', 'created_by'], 'required'],
            [['associate_type'], 'string'],
            [['note'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'favorite_category_id' => '收藏夹分类ID',
            'associate_type' => '类型',
            'associate_id' => '关联的对象ID',
            'created_at' => '创建时间',
            'created_by' => 'Created By',
            'note' => '注解',
        ];
    }
}
