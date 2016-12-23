<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 06.07.2016
 * Time: 10:41
 */
namespace floor12\comments;

use yii\db\Expression;

class CommentsWidget extends \yii\base\Widget
{

    public $show = false;
    public $object_id;
    public $classname;
    public $btn_class = "btn btn-default btn-xs";

    private $class_hashed;
    private $selector;

    function init()
    {
        $this->class_hashed = Comment::prepereClassname($this->classname);
        $this->selector = $this->class_hashed . "-" . $this->object_id;

    }


    function run()
    {
        $total = Comment::find()->where(['class' => $this->class_hashed, 'object_id' => $this->object_id])->count();

        return $this->renderFile('@vendor/floor12/yii2-comments/views/widget.php', [
            'total' => $total,
            'btn_class' => $this->btn_class,
            'object_id' => $this->object_id,
            'selector' => $this->selector,
            'show' => $this->show,
            'class_hashed' => $this->class_hashed
        ]);


    }
}