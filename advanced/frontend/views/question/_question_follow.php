<?php
/**
 * Created by PhpStorm.
 * User: Keen
 * Date: 2015/12/6
 * Time: 1:08
 */
use yii\helpers\Html;
use yii\widgets\Pjax;

/** @var $count_follow */
/** @var $id */
/** @var $is_followed */
?>
<?php Pjax::begin(
    [
        'enablePushState' => false,
        'id'              => 'question-follow-pjax',
        'timeout'         => 10000,
    ]
); ?>

<?= Html::a(
    $is_followed ? '取消关注' : '关注',
    ['question/follow', 'question_id' => $id],
    [
        'id'              => 'sideFollow',
        'class'           => 'btn btn-success btn-sm',
        'title'           => '关注后将获得更新提醒',
        'data-need-login' => true,
        'data-do'         => 'pjax',
    ]
) ?>
    <strong><?= $count_follow ?></strong> 关注
<?php Pjax::end(); ?>