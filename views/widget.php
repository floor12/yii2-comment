<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 22.12.2016
 * Time: 19:01
 *
 * @var $show boolean
 * @var $class_hashed string
 * @var $btn_class string
 * @var $object_id integer
 * @var $selector string
 * @var $this \yii\web\View
 *
 */

use yii\helpers\Html;
use \rmrevin\yii\fontawesome\FontAwesome;

\floor12\comments\CommentsAsset::register($this);

?>

<div class="comments-widget">
    <div class="comments-header">
        <?= Html::a(FontAwesome::icon('comments') . "Комментарии {$total}", null, ['class' => "comments-total " . $btn_class, 'data-object_id' => $object_id, 'data-class' => $class_hashed]); ?>
        <?= Html::a(FontAwesome::icon('plus') . "Добавить комментарий", null, ['class' => "comments-create " . $btn_class, 'data-object_id' => $object_id, 'data-class' => $class_hashed]); ?>
    </div>
    <?= Html::tag('div', null, ['class' => 'comments-comments', 'data-object_id' => $object_id, 'data-class' => $class_hashed, 'id' => $selector]) ?>
</div>
<?php if ($show) $this->registerJs("showComments($('#{$class_hashed}-{$object_id}'))", \yii\web\View::POS_END, "showcomment-{$class_hashed}-{$object_id}") ?>




