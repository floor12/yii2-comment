<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 05.12.2016
 * Time: 16:14
 * @var $model \common\models\Comment
 */

use yii\helpers\Html;
use rmrevin\yii\fontawesome\FontAwesome;

?>
<div data-key="<?= $model->id ?>" class="comment <?php if ($model->parent_id) echo "subcomment"; ?>">

    <div class="comment-body">
        <img src="<?= $model->user->avatara ?>" class="avatar">
        <div class="comment-date"><?= \Yii::$app->formatter->asDatetime($model->created) ?></div>
        <div class="comment-author"><?= $model->user->fullname ?></div>
        <div class="comment-content">
            <?= $model->content; ?>

            <?= \floor12\files\components\FilesBlock::widget(['files' => $model->files, 'title' => 'Файлы:', 'downloadAll' => true, 'zipTitle' => "comment_" . $model->id]) ?>
        </div>

        <div class="comment-control">
            <?= Html::a(FontAwesome::icon('reply') . "Ответить", null, ['onclick' => "showForm('comment/form',{parent: {$model->id}})", 'class' => 'btn btn-xs btn-default']) ?>
            <?php if ($model->canUpdate(Yii::$app->user->id) || !Yii::$app->user->can('admin')): ?>
                <?= Html::a(FontAwesome::icon('pencil') . "Редактировать", null, ['onclick' => "showForm('comment/form',{$model->id})", 'class' => 'btn btn-xs btn-default']) ?>
                <?= Html::a(FontAwesome::icon('trash') . "Удалить", null, ['onclick' => "deleteComment({$model->id})", 'class' => 'btn btn-xs btn-default']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
