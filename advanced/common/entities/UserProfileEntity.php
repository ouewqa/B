<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 2015/9/10
 * Time: 14:12
 */

namespace common\entities;

use \dektrium\user\models\Profile;
use Yii;
use yii\helpers\ArrayHelper;

class UserProfileEntity extends Profile
{
    public static function tableName()
    {
        return 'user_profile';
    }

    public function attributeLabels()
    {
        #auto generate
        $attributes = [
            'user_id'               => 'User ID',
            'name'                  => '真实姓名',
            'nickname'              => '昵称',
            'sex'                   => 'Sex',
            'birthday'              => '生日',
            'title'                 => '头衔',
            'avatar'                => '头像',
            'description'           => '自我描述',
            'public_email'          => '公开邮箱',
            'gravatar_email'        => 'gravatar头像',
            'gravatar_id'           => 'Gravatar ID',
            'location'              => 'Location',
            'website'               => 'Website',
            'bio'                   => '个性签名',
            'province'              => '省',
            'city'                  => '市',
            'district'              => '区',
            'address'               => '地址',
            'longitude'             => '经度',
            'latitude'              => '维度',
            'count_favorite'        => '收藏数',
            'count_question'        => '提问数',
            'count_answer'          => '回答数',
            'count_follow'          => '关注用户数',
            'count_be_follow'       => '被关注用户数',
            'count_usefull'         => '支持数',
            'count_common_edit'     => '公共编辑数',
            'count_follow_question' => '关注问题数',
            'count_follow_tag'      => '关注标签数',
            'count_home_views'      => '主页查看数',
            'count_notification'    => '通知数',
            'wx_account'            => '微信账号',
            'wx_openid'             => '微信的openid',
        ];

        return ArrayHelper::merge(
            [
                'nickname'  => \Yii::t('user', 'Nickname'),
                'title'     => \Yii::t('user', 'Title'),
                'sex'       => \Yii::t('user', 'Sex'),
                'birthday'  => \Yii::t('user', 'Birthday'),
                'avatar'    => \Yii::t('user', 'Avatar'),
                'province'  => \Yii::t('user', 'Province'),
                'city'      => \Yii::t('user', 'City'),
                'district'  => \Yii::t('user', 'District'),
                'address'   => \Yii::t('user', 'Address'),
                'longitude' => \Yii::t('user', 'Longitude'),
                'latitude'  => \Yii::t('user', 'Latitude'),
            ],
            $attributes
        );
    }


    /**
     * 场景约束
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        //$scenarios['create'][]   = 'field';
        //$scenarios['update'][]   = 'field';
        //$scenarios['register'][] = 'field';
        return $scenarios;
    }

    /**
     * 字段规则
     * @return array
     */
    public function rules()
    {

        #auto generate
        $rules = [
            [['user_id'], 'required'],
            [
                [
                    'user_id',
                    'province',
                    'city',
                    'district',
                    'count_favorite',
                    'count_question',
                    'count_answer',
                    'count_follow',
                    'count_be_follow',
                    'count_usefull',
                    'count_common_edit',
                    'count_follow_question',
                    'count_follow_tag',
                    'count_home_views',
                    'count_notification',
                ],
                'integer',
            ],
            [['sex'], 'string'],
            [['birthday'], 'safe'],
            [['longitude', 'latitude'], 'number'],
            [
                ['name', 'avatar', 'public_email', 'gravatar_email', 'location', 'website', 'bio'],
                'string',
                'max' => 255,
            ],
            [['nickname', 'title'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 1024],
            [['gravatar_id', 'wx_openid'], 'string', 'max' => 32],
            [['address'], 'string', 'max' => 80],
            [['wx_account'], 'string', 'max' => 45],
        ];

        // add some rules
        //$rules['fieldRequired'] = ['field', 'required'];
        $rules['pcd'] = [['province', 'city', 'district'], 'integer', 'integerOnly' => true];
        $rules['sexIn'] = ['sex', 'in', 'range' => ['男', '女', '保密']];
        $rules['birthday'] = ['birthday', 'date', 'format' => 'php:Y/m/d'];
        $rules['addressLength'] = ['address', 'string', 'max' => '80'];
        $rules['avatarLength'] = ['avatar', 'string', 'max' => '255'];

        return $rules;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}