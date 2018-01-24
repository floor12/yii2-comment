<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 11.11.2016
 * Time: 20:25
 *
 * @var \floor12\comments\Comment $model
 *
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['class' => 'modaledit-form'],
    'enableClientValidation' => true
]);


?>

<div class="modal-header">
    <h2><?= $model->isNewRecord ? "Добавление комментария" : "Редактирование комментария"; ?></h2>
</div>

<div class="modal-body">
    <?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'content')->label(false)->widget(\marqu3s\summernote\Summernote::className(), []) ?>
    <?= $form->field($model, 'files')->widget(\floor12\files\components\FileInputWidget::className()) ?>
    <?= $form->field($model, 'object_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'class')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>
</div>

<div class="modal-footer">
    <?= Html::a('Отмена', '', ['class' => 'btn btn-default modaledit-disable']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
