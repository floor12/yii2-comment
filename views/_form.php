<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 11.11.2016
 * Time: 20:25
 *
 * @var \common\models\Position $model
 *
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\components\Summernote;

$form = ActiveForm::begin([
    'options' => ['class' => 'ajax-form'],
    'enableClientValidation' => true
]);

echo "<h2>";
echo $model->isNewRecord ? "Добавление комментария" : "Редактирование комментария";
echo "</h2>";

echo $form->errorSummary($model);


?>

<?= $form->field($model, 'content')->label(false)->widget(Summernote::className(), []); ?>

<?= $form->field($model, 'object_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'class')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>
<div class="modal-footer">
    <?= Html::a('Отмена', '', ['class' => 'btn btn-default disable']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
