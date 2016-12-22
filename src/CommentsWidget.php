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

    public $object_id;
    public $classname;
    private $comments;


    function run()
    {

        $expression = new Expression("CASE WHEN parent_id = 0 THEN id ELSE parent_id END AS sort");

        $this->comments = Comment::find()->addSelect(["*", $expression])->where([
            'class' => $this->classname,
            'object_id' => $this->object_id,
        ])->orderBy("sort, created")->all();


        $commentsRender = Null;
        if ($this->comments) {
            foreach ($this->comments as $comment)
                $commentsRender .= $this->renderFile('@vendor/floor12/yii2-comments/views/_comment.php', ['model' => $comment]);
            return $this->renderFile('@vendor/floor12/yii2-comments/views/comments.php', ['comments' => $commentsRender]);
        }


    }
}