<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 09.11.2016
 * Time: 13:06
 */

namespace floor12\comments;


use yii\web\Controller;
use yii\filters\AccessControl;
use backend\components\UserBehavior;
use yii\web\ForbiddenHttpException;
use yii\db\Expression;
use \Yii;


class CommentController extends Controller
{
    public $layout = 'private';
    public $defaultAction = 'index';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex($object_id, $classname)
    {
        $expression = new Expression("CASE WHEN parent_id = 0 THEN id ELSE parent_id END AS sort");

        $comments = Comment::find()->addSelect(["*", $expression])->where([
            'class' => $classname,
            'object_id' => $object_id,
        ])->orderBy("sort, created")->all();


        $commentsRender = Null;
        if ($comments) {
            foreach ($comments as $comment)
                $commentsRender .= $this->renderFile('@vendor/floor12/yii2-comments/views/_comment.php', ['model' => $comment]);
            return $this->renderFile('@vendor/floor12/yii2-comments/views/comments.php', ['comments' => $commentsRender]);
        }


    }

    public function actionForm($classname = NULL, $object_id = 0, $parent = 0, $id = 0)
    {

        if ($id) {
            $model = Comment::findOne($id);
            if (!$model->canUpdate(Yii::$app->user->id) && !Yii::$app->user->can('admin'))
                throw new ForbiddenHttpException("Update this comment is not permitted");

        } else {
            $model = new Comment();
            $model->parent_id = $parent;
            if ($model->parent_id) {
                $model->object_id = $model->parent->object_id;
                $model->class = $model->parent->class;
            } else {
                $model->class = $classname;
                $model->object_id = $object_id;
            }
        }

//            if (($component == 'post') && !\Yii::$app->user->can('commentCreate', ['post' => Post::findOne($object_id)]))
//                throw new ForbiddenHttpException("Comment this post is not permitted");


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return "
            <script>
                info('Комментарий успешно сохранен',1);
                hideFormModal();
                commentBlock = $('#{$model->class}-{$model->object_id}');
                showComments(commentBlock)
            </script>";
        }

        return $this->renderAjax('@vendor/floor12/yii2-comments/views/_form.php', ['model' => $model]);
    }

    public function actionDelete()
    {
        $id = \Yii::$app->request->getBodyParams('id');
        if (!$id)
            throw new BadRequestHttpException;
        $model = Comment::findOne($id);
        if (!$model->canUpdate(Yii::$app->user->id) && !Yii::$app->user->can('admin'))
            throw new ForbiddenHttpException("Delete this comment is not permitted");
        if (!$model)
            throw new NotFoundHttpException;
        $model->delete();
        return "#{$model->class}-{$model->object_id}";
    }
}