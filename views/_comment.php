<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 05.12.2016
 * Time: 16:14
 * @var $model \common\models\Comment
 */

use floor12\comments\Comment;

?>
<div data-key="<?= $model->id ?>" class="comment <?php if ($model->parent_id) echo "subcomment"; ?>">

    <img src="<?= $model->user->avatar ?>" class="avatar">

    <div class="comment-body">
        <?php if (\Yii::$app->user->can('commentUpdate', ['comment' => $model])) { ?>
            <div class="comment-control-wrapper">
                <div class="comment-control">
                    <a onclick="showForm('comment/form',{id: <?= $model->id ?>})">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> редактировать</a>
                    <a onclick="deleteRoute('comment/delete',{id: <?= $model->id ?>})">
                        <i class="fa fa-trash" aria-hidden="true"></i> удалить</a>
                </div>
            </div>
        <?php } ?>
        <div class="comment-content">
            <?= $model->content; ?>
        </div>
    </div>

    <div class="object-summary">
        <div>
            <i class="fa fa-reply" aria-hidden="true"></i>
            <a onclick="showForm('comment/form',{parent: <?= $model->id ?>})">Ответить</a>
        </div>

        <div class="pull-right date">
            <?= \Yii::$app->formatter->asDatetime($model->created) ?>
        </div>
    </div>
</div>
